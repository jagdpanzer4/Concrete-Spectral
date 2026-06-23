<?php defined('C5_EXECUTE') or die('Access Denied.');
/** @var \Concrete\Core\Navigation\Breadcrumb\PageBreadcrumb|null $breadcrumb */
$breadcrumb = $breadcrumb ?? null;
if (!$breadcrumb || count($breadcrumb->getItems()) === 0) { return; }
$breadcrumbItems = $breadcrumb->getItems();
?>
<nav aria-label="<?= t('Breadcrumb') ?>" class="sui-breadcrumb">
    <ol class="sui-breadcrumb__list" style="list-style:none;margin:0;padding:0;display:flex;flex-wrap:wrap;align-items:center;gap:var(--space-1,4px);font-size:.875rem;">
        <?php $i = 0; foreach ($breadcrumbItems as $item): ?>
        <li class="sui-breadcrumb__item" style="display:flex;align-items:center;gap:var(--space-1,4px);">
            <?php if ($i > 0): ?><span aria-hidden="true" style="color:var(--color-muted);">›</span><?php endif; ?>
            <?php if ($item->isActive()): ?>
            <span aria-current="page" style="color:var(--color-muted);"><?= h($item->getName()) ?></span>
            <?php else: ?>
            <a href="<?= h($item->getUrl()) ?>" class="sui-link"><?= h($item->getName()) ?></a>
            <?php endif; ?>
        </li>
        <?php ++$i; endforeach; ?>
    </ol>
</nav>
