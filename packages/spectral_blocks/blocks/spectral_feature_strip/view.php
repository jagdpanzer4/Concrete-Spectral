<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<?php if (empty($items)) return; ?>
<div class="sui-feature-strip-region" style="text-align:<?= h($align) ?>;">
    <?php foreach ($items as $item): ?>
    <?php $tag = !empty($item['linkURL']) ? 'a' : 'div'; ?>
    <<?= $tag ?>
        class="sui-feature-strip"
        <?= !empty($item['linkURL']) ? 'href="' . h($item['linkURL']) . '"' : '' ?>
    >
        <?php if (!empty($item['icon'])): ?>
        <span class="sui-feature-icon" aria-hidden="true"><?= h($item['icon']) ?></span>
        <?php endif; ?>
        <strong class="sui-feature-strip__title"><?= h($item['title']) ?></strong>
        <?php if (!empty($item['subtitle'])): ?>
        <span class="sui-feature-strip__subtitle"><?= h($item['subtitle']) ?></span>
        <?php endif; ?>
    </<?= $tag ?>>
    <?php endforeach; ?>
</div>
