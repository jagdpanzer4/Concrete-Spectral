<?php defined('C5_EXECUTE') or die('Access Denied.');
/**
 * @var int|null    $fID
 * @var string      $title
 * @var string      $paragraph
 * @var string      $linkURL
 * @var string      $linkText
 */

$iconSrc = null;
if (!empty($fID)) {
    $f = \File::getByID($fID);
    if (is_object($f) && !$f->isError()) {
        $iconSrc = $f->getVersion()->getURL();
    }
}
?>
<div class="sui-card sui-elevation-1" style="padding:var(--space-6,24px);border-radius:var(--radius-lg);display:flex;flex-direction:column;gap:var(--space-4,16px);">
    <?php if ($iconSrc): ?>
    <img src="<?= h($iconSrc) ?>" alt="" aria-hidden="true" class="sui-feature-icon" style="width:48px;height:48px;object-fit:contain;">
    <?php endif; ?>

    <?php if (!empty($title)): ?>
    <h3 class="sui-h3 sui-heading"><?= h($title) ?></h3>
    <?php endif; ?>

    <?php if (!empty($paragraph)): ?>
    <div class="sui-body"><?= $paragraph ?></div>
    <?php endif; ?>

    <?php if (!empty($linkURL) && !empty($linkText)): ?>
    <a href="<?= h($linkURL) ?>" class="sui-btn sui-btn-text" style="margin-top:auto;align-self:flex-start;">
        <?= h($linkText) ?> <span aria-hidden="true">→</span>
    </a>
    <?php endif; ?>
</div>
