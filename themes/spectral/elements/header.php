<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Support\Facade\Site;
use Concrete\Core\Support\Facade\Url;

$site     = Site::getSite();
$siteName = $site ? $site->getSiteName() : '';
$logoAttr = $site ? $site->getAttribute('site_logo') : null;
?>
<a href="#main-content" class="sui-skip-link"><?= t('Skip to main content') ?></a>

<header class="sui-site-header" x-data="{ menuOpen: false }">
    <div class="sui-container">
        <nav class="sui-nav-primary" role="navigation" aria-label="<?= t('Main navigation') ?>">

            <a href="<?= URL::to('/') ?>" class="sui-nav-brand" aria-label="<?= h($siteName) ?>">
                <?php if ($logoAttr && is_object($logoAttr) && method_exists($logoAttr, 'getFile') && $logoAttr->getFile()): ?>
                    <img src="<?= h($logoAttr->getFile()->getRelativePath()) ?>"
                         alt="<?= h($siteName) ?>"
                         class="sui-nav-logo-img">
                <?php else: ?>
                    <span class="sui-nav-logo-text"><?= h($siteName) ?></span>
                <?php endif; ?>
            </a>

            <div class="sui-nav-links"
                 id="sui-mobile-nav"
                 :class="{ 'sui-nav-links--open': menuOpen }">
                <?php $mainNav = new GlobalArea('Main Navigation'); $mainNav->display($c); ?>
            </div>

            <div class="sui-nav-actions">
                <?php $headerCta = new GlobalArea('Header CTA'); $headerCta->display($c); ?>
                <button
                    class="sui-nav-toggle"
                    @click="menuOpen = !menuOpen"
                    :aria-expanded="menuOpen ? 'true' : 'false'"
                    aria-controls="sui-mobile-nav"
                    aria-label="<?= t('Toggle navigation') ?>">
                    <span class="sui-nav-toggle-bar"></span>
                    <span class="sui-nav-toggle-bar"></span>
                    <span class="sui-nav-toggle-bar"></span>
                </button>
            </div>

        </nav>
    </div>
</header>
