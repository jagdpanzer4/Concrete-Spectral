<?php defined('C5_EXECUTE') or die('Access Denied.');

if (!$previousLinkURL && !$nextLinkURL) {
    return;
}
?>
<nav class="sui-pagination" aria-label="<?= h(t('Page navigation')) ?>">
    <div class="sui-pagination__inner" style="display:flex;justify-content:space-between;align-items:center;gap:var(--space-4,16px);">

        <?php if ($previousLinkURL) { ?>
        <a href="<?= h($previousLinkURL) ?>"
           class="sui-btn sui-btn-outlined sui-pagination__prev"
           rel="prev"
           aria-label="<?= h(t('Previous page')) ?>">
            <span aria-hidden="true">&larr;</span>
            <span style="margin-left:var(--space-2,8px);"><?= $previousLinkText ?></span>
        </a>
        <?php } else { ?>
        <span class="sui-pagination__spacer"></span>
        <?php } ?>

        <?php if ($nextLinkURL) { ?>
        <a href="<?= h($nextLinkURL) ?>"
           class="sui-btn sui-btn-outlined sui-pagination__next"
           rel="next"
           aria-label="<?= h(t('Next page')) ?>">
            <span style="margin-right:var(--space-2,8px);"><?= $nextLinkText ?></span>
            <span aria-hidden="true">&rarr;</span>
        </a>
        <?php } else { ?>
        <span class="sui-pagination__spacer"></span>
        <?php } ?>

    </div>
</nav>
