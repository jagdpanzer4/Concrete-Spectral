<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Support\Facade\Site;

$site  = Site::getSite();
$widmo = (string) ($site->getAttribute('spectral_theme') ?: 'spectral-chromatic');
$thUrl = $view->getThemeURL();
?>
<?php View::element('header_required', [
    'pageTitle'        => $c->getCollectionName(),
    'pageDescription'  => $c->getCollectionDescription(),
    'pageMetaKeywords' => '',
]); ?>
<link rel="stylesheet" href="<?= h($thUrl) ?>/css/theme.css">
<link rel="stylesheet" href="<?= h($thUrl) ?>/css/<?= h($widmo) ?>/main.css">
</head>
<body class="ccm-page-id-<?= $c->getCollectionID() ?> sui-theme-<?= h($widmo) ?>">
<div class="ccm-page">

    <?php $view->inc('elements/header.php'); ?>

    <div class="sui-announcement-bar-region">
        <?php (new GlobalArea('Announcement Bar'))->display($c); ?>
    </div>

    <div class="sui-hero-region">
        <?php (new Area('Hero'))->display($c); ?>
    </div>

    <section class="sui-feature-strip-region">
        <?php (new Area('Feature Strip'))->display($c); ?>
    </section>

    <main class="sui-main" id="main-content">
        <div class="sui-container">
            <?php (new Area('Main Content'))->display($c); ?>
        </div>
    </main>

    <section class="sui-pre-footer-region">
        <?php (new Area('Pre-Footer CTA'))->display($c); ?>
    </section>

    <?php $view->inc('elements/footer.php'); ?>

</div>
<?php View::element('footer_required'); ?>
<script type="module" src="<?= h($thUrl) ?>/css/<?= h($widmo) ?>/main.js"></script>
</body>
</html>
