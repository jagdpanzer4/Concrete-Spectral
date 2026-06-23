<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Support\Facade\Site;

$site  = Site::getSite();
$widmo = (string) ($site->getAttribute('spectral_theme') ?: 'spectral-chromatic');
$theme = $c->getCollectionThemeObject();
$thUrl = $theme->getThemeURL();
?>
<?php View::element('header_required', [
    'pageTitle'        => $c->getCollectionName(),
    'pageDescription'  => $c->getCollectionDescription(),
    'pageMetaKeywords' => '',
]); ?>
<link rel="stylesheet" href="<?= h($thUrl) ?>/css/theme.css">
<link rel="stylesheet" href="<?= h($thUrl) ?>/css/<?= h($widmo) ?>/main.css">
<?= $view->getThemeStyles() ?>
</head>
<body class="ccm-page-id-<?= $c->getCollectionID() ?> sui-theme-<?= h($widmo) ?> sui-landing-page">
<div class="ccm-page">

    <?php $view->inc('elements/header.php'); ?>

    <div class="sui-hero-region">
        <?php (new Area('Hero'))->display($c); ?>
    </div>

    <?php foreach (['Section 1', 'Section 2', 'Section 3', 'Section 4'] as $i => $sectionName): ?>
    <section class="sui-landing-section sui-landing-section--<?= $i + 1 ?>">
        <div class="sui-container">
            <?php (new Area($sectionName))->display($c); ?>
        </div>
    </section>
    <?php endforeach; ?>

    <section class="sui-pre-footer-region">
        <?php (new Area('Pre-Footer CTA'))->display($c); ?>
    </section>

    <?php $view->inc('elements/footer.php'); ?>

</div>
<?php View::element('footer_required'); ?>
<script type="module" src="<?= h($thUrl) ?>/css/<?= h($widmo) ?>/main.js"></script>
</body>
</html>
