<?php defined('C5_EXECUTE') or die('Access Denied.');
/**
 * @var int|null $fID
 * @var string   $content
 * @var int      $height
 */

$bgStyle = '';
if (!empty($fID)) {
    $f = \File::getByID($fID);
    if (is_object($f) && !$f->isError()) {
        $bgStyle = 'background-image:url(' . h($f->getVersion()->getURL()) . ');';
    }
}

$heightStyle = $height ? "min-height:{$height}px;" : 'min-height:480px;';
?>
<section
    class="sui-hero"
    style="<?= $bgStyle . $heightStyle ?>background-size:cover;background-position:center;display:flex;align-items:center;position:relative;overflow:hidden;"
    aria-label="<?= t('Hero section') ?>"
>
    <div class="sui-hero__overlay" style="position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,0,0,.35),rgba(0,0,0,.6));pointer-events:none;" aria-hidden="true"></div>
    <div class="sui-container sui-hero__content" style="position:relative;z-index:1;color:#fff;max-width:800px;margin:0 auto;padding:var(--space-12,48px) var(--space-4,16px);text-align:center;">
        <?= $content ?>
    </div>
</section>
