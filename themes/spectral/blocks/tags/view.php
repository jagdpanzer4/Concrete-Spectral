<?php defined('C5_EXECUTE') or die('Access Denied.');
/** @var array       $tags      */
/** @var string|null $searchURL */
if (empty($tags)) { return; }
?>
<div class="sui-tags" style="display:flex;flex-wrap:wrap;gap:var(--space-2,8px);" role="list" aria-label="<?= t('Tags') ?>">
    <?php foreach ($tags as $tag): ?>
    <span role="listitem">
        <?php if (!empty($searchURL)): ?>
        <a href="<?= h($searchURL . '?tag=' . rawurlencode($tag)) ?>"
           class="sui-chip sui-chip--outlined"
           style="display:inline-flex;align-items:center;padding:var(--space-1,4px) var(--space-3,12px);border-radius:var(--radius-full,9999px);border:1px solid var(--color-border);font-size:.875rem;text-decoration:none;">
            <?= h($tag) ?>
        </a>
        <?php else: ?>
        <span class="sui-chip" style="display:inline-flex;align-items:center;padding:var(--space-1,4px) var(--space-3,12px);border-radius:var(--radius-full,9999px);background:var(--color-surface-2);font-size:.875rem;">
            <?= h($tag) ?>
        </span>
        <?php endif; ?>
    </span>
    <?php endforeach; ?>
</div>
