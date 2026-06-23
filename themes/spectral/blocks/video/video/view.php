<?php defined('C5_EXECUTE') or die('Access Denied.');
/**
 * Spectral video block template.
 *
 * @var string|null $mp4URL
 * @var string|null $oggURL
 * @var string|null $webmURL
 * @var string|null $posterURL
 * @var int|null    $videoSize   0=auto, 1=full-width, 2=fixed
 * @var int|null    $width
 * @var string|null $title
 */

use Concrete\Core\Page\Page;

$c = Page::getCurrentPage();

if (is_object($c) && $c->isEditMode()): ?>
    <div class="sui-media-placeholder ccm-edit-mode-disabled-item">
        <span>&#9654; <?= t('Video — disabled in edit mode') ?></span>
    </div>
<?php elseif (!$webmURL && !$oggURL && !$mp4URL): ?>
    <div class="sui-media-placeholder">
        <span><?= t('No video files selected.') ?></span>
    </div>
<?php else:
    if ((int)$videoSize === 1) {
        $styleAttr = 'style="width:100%"';
    } elseif ((int)$videoSize === 2 && !empty($width)) {
        $styleAttr = 'width="' . (int)$width . '" style="max-width:100%"';
    } else {
        $styleAttr = 'style="max-width:100%"';
    }
?>
<div class="sui-video-wrapper">
    <video class="sui-video"
           controls
           <?= !empty($posterURL) ? 'poster="' . h($posterURL) . '"' : '' ?>
           <?= $styleAttr ?>
           <?= !empty($title) ? 'title="' . h($title) . '"' : '' ?>>
        <?php if ($webmURL): ?>
        <source src="<?= h($webmURL) ?>" type="video/webm">
        <?php endif; ?>
        <?php if ($mp4URL): ?>
        <source src="<?= h($mp4URL) ?>" type="video/mp4">
        <?php endif; ?>
        <?php if ($oggURL): ?>
        <source src="<?= h($oggURL) ?>" type="video/ogg">
        <?php endif; ?>
        <p><?= t("Your browser doesn't support the HTML5 video tag.") ?></p>
    </video>
</div>
<?php endif; ?>
