<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Support\Facade\Site;

$site     = Site::getSite();
$siteName = $site ? $site->getSiteName() : '';
?>
<footer class="sui-site-footer" role="contentinfo">

    <div class="sui-footer-top">
        <div class="sui-container">
            <div class="sui-footer-columns">
                <?php foreach (['Footer Column 1', 'Footer Column 2', 'Footer Column 3', 'Footer Column 4'] as $colName): ?>
                    <div class="sui-footer-col">
                        <?php $col = new GlobalArea($colName); $col->display($c); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="sui-footer-bar">
        <div class="sui-container sui-footer-bar-inner">
            <span class="sui-footer-copyright">
                &copy; <?= date('Y') ?> <?= h($siteName) ?>
            </span>
            <?php $footerNav = new GlobalArea('Footer Navigation'); $footerNav->display($c); ?>
            <?php $social = new GlobalArea('Footer Social Links'); $social->display($c); ?>
        </div>
    </div>

</footer>
