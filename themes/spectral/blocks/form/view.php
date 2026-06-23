<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Block\Form\MiniSurvey;

$app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();

$survey     = $controller;
$miniSurvey = new MiniSurvey($b);
$miniSurvey->frontEndMode = true;

$bID        = (int) $bID;
$qsID       = (int) ($survey->questionSetId);
$formAction = $view->action('submit_form') . '#formblock' . $bID;

$questionsRS = $miniSurvey->loadQuestions($qsID, $bID);
$questions   = [];
while ($questionRow = $questionsRS->fetch()) {
    $question          = $questionRow;
    $question['input'] = $miniSurvey->loadInputType($questionRow, false);

    if ($questionRow['inputType'] === 'text') {
        $question['type'] = 'textarea';
    } elseif ($questionRow['inputType'] === 'field') {
        $question['type'] = 'text';
    } else {
        $question['type'] = $questionRow['inputType'];
    }

    $question['labelFor'] = 'for="Question' . $questionRow['msqID'] . '"';

    if ($question['type'] === 'textarea') {
        $question['input'] = str_replace('style="width:95%"', '', $question['input']);
    }

    $questions[] = $question;
}

$success  = (\Request::request('surveySuccess') && \Request::request('qsid') == $qsID);
$thanksMsg = $survey->thankyouMsg;

$errorHeader = $formResponse ?? null;
$errors      = isset($errors) && is_array($errors) ? $errors : [];
if (isset($invalidIP) && $invalidIP) {
    $errors[] = $invalidIP;
}

$surveyBlockInfo = $miniSurvey->getMiniSurveyBlockInfoByQuestionId($qsID, $bID);
$captcha         = $surveyBlockInfo['displayCaptcha'] ? $app->make('helper/validation/captcha') : false;
?>

<div id="formblock<?= $bID ?>" class="sui-form-block">

    <?php if ($success) { ?>

    <div class="sui-alert sui-alert--success" role="alert">
        <?= h($thanksMsg) ?>
    </div>

    <?php } else { ?>

    <?php if ($errors) { ?>
    <div class="sui-alert sui-alert--error" role="alert">
        <?php if ($errorHeader) { ?>
        <p><?= h($errorHeader) ?></p>
        <?php } ?>
        <?php foreach ($errors as $error) { ?>
        <p><?= h($error) ?></p>
        <?php } ?>
    </div>
    <?php } ?>

    <form
        id="miniSurveyView<?= $bID ?>"
        class="sui-form"
        method="post"
        enctype="multipart/form-data"
        action="<?= h($formAction) ?>"
        novalidate
    >
        <?= Core::make('token')->output('form_block_submit_qs_' . $qsID) ?>

        <div class="sui-form__fields">
            <?php foreach ($questions as $question) {
                $hasError = isset($errorDetails[$question['msqID']]);
                $inputType = $question['type'];
            ?>
            <div class="sui-form__group<?= $hasError ? ' sui-form__group--error' : '' ?> field-<?= h($inputType) ?>">

                <label class="sui-label" <?= $question['labelFor'] ?>>
                    <?= h($question['question']) ?>
                    <?php if ($question['required']) { ?>
                    <span class="sui-label__required" aria-hidden="true"> *</span>
                    <span class="sui-visually-hidden"><?= h(t('Required')) ?></span>
                    <?php } ?>
                </label>

                <?php
                /*
                 * CC9 renders the raw input HTML via loadInputType(). We apply Spectral
                 * classes by post-processing that HTML string for the common input types.
                 * select/radio/checkbox HTML is rendered verbatim; CSS targets them via
                 * the .field-* wrapper or override classes injected below.
                 */
                $inputHtml = $question['input'];

                if ($inputType === 'text' || $inputType === 'email' || $inputType === 'telephone' || $inputType === 'url' || $inputType === 'number') {
                    // Inject sui-input class onto the <input> tag
                    $inputHtml = preg_replace(
                        '/(<input\b)(\s)/i',
                        '$1 class="sui-input" $2',
                        $inputHtml,
                        1
                    );
                } elseif ($inputType === 'textarea') {
                    $inputHtml = preg_replace(
                        '/(<textarea\b)(\s)/i',
                        '$1 class="sui-textarea" $2',
                        $inputHtml,
                        1
                    );
                } elseif ($inputType === 'select' || $inputType === 'selectmultiple') {
                    $inputHtml = preg_replace(
                        '/(<select\b)(\s)/i',
                        '$1 class="sui-select" $2',
                        $inputHtml,
                        1
                    );
                } elseif ($inputType === 'checkbox') {
                    $inputHtml = preg_replace(
                        '/(<input\b([^>]*?type=["\']checkbox["\'][^>]*?))(\/?>)/i',
                        '$1 class="sui-checkbox"$3',
                        $inputHtml
                    );
                } elseif ($inputType === 'radio') {
                    $inputHtml = preg_replace(
                        '/(<input\b([^>]*?type=["\']radio["\'][^>]*?))(\/?>)/i',
                        '$1 class="sui-radio"$3',
                        $inputHtml
                    );
                }

                echo $inputHtml;
                ?>

                <?php if ($hasError) { ?>
                    <?php foreach ((array)($errorDetails[$question['msqID']] ?? []) as $errMsg): ?>
                    <span class="sui-form__error" role="alert"><?= h($errMsg) ?></span>
                    <?php endforeach; ?>
                <?php } ?>

            </div>
            <?php } ?>
        </div><!-- .sui-form__fields -->

        <?php if ($captcha) { ?>
        <div class="sui-form__group sui-form__group--captcha">
            <?php
            $captchaLabel = $captcha->label();
            if (!empty($captchaLabel)) { ?>
            <label class="sui-label"><?= h($captchaLabel) ?></label>
            <?php } ?>
            <div class="sui-form__captcha-display"><?php $captcha->display(); ?></div>
            <div class="sui-form__captcha-input"><?php $captcha->showInput(); ?></div>
        </div>
        <?php } ?>

        <div class="sui-form__actions">
            <button type="submit" name="Submit" class="sui-btn sui-btn-primary">
                <?= h(t($survey->submitText)) ?>
            </button>
        </div>

        <input type="hidden" name="qsID" value="<?= $qsID ?>"/>
        <input type="hidden" name="pURI" value="<?= h($pURI ?? '') ?>"/>

    </form>

    <?php } ?>

</div><!-- .sui-form-block -->
