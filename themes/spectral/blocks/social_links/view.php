<?php defined('C5_EXECUTE') or die('Access Denied.');
/** @var array $links */
if (empty($links)) { return; }
?>
<ul class="sui-social-links" style="list-style:none;margin:0;padding:0;display:flex;flex-wrap:wrap;gap:var(--space-3,12px);align-items:center;" role="list">
    <?php foreach ($links as $link):
        $service = $link->getServiceName();
        $url     = $link->getURL();
        $icon    = method_exists($link, 'getIcon') ? $link->getIcon() : null;
    ?>
    <li>
        <a href="<?= h($url) ?>"
           target="_blank"
           rel="noopener noreferrer"
           aria-label="<?= h($service) ?>"
           class="sui-social-link"
           style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:var(--radius-full,9999px);border:1px solid var(--color-border);transition:background var(--duration-fast,.15s) ease;">
            <?php if ($icon): ?>
            <img src="<?= h($icon) ?>" alt="" aria-hidden="true" width="20" height="20">
            <?php else: ?>
            <span aria-hidden="true" style="font-size:.75rem;font-weight:600;text-transform:uppercase;"><?= h(mb_substr($service, 0, 2)) ?></span>
            <?php endif; ?>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
