<?php defined('C5_EXECUTE') or die('Access Denied.');
/** @var array $items */
if (empty($items)) { return; }
?>
<nav aria-label="<?= t('Breadcrumb') ?>" class="sui-breadcrumb">
    <ol class="sui-breadcrumb__list" style="list-style:none;margin:0;padding:0;display:flex;flex-wrap:wrap;align-items:center;gap:var(--space-1,4px);font-size:.875rem;">
        <?php foreach ($items as $i => $item):
            $isLast = ($i === count($items) - 1);
            $name   = $item->getName();
            $url    = $item->getURL();
        ?>
        <li class="sui-breadcrumb__item" style="display:flex;align-items:center;gap:var(--space-1,4px);">
            <?php if ($i > 0): ?><span aria-hidden="true" style="color:var(--color-muted);">›</span><?php endif; ?>
            <?php if ($isLast): ?>
            <span aria-current="page" style="color:var(--color-muted);"><?= h($name) ?></span>
            <?php else: ?>
            <a href="<?= h($url) ?>" class="sui-link"><?= h($name) ?></a>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ol>
</nav>
