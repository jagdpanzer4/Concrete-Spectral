<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<?php if (empty($entries)): ?>
<p style="color:var(--color-text-muted);padding:var(--space-4);"><?= t('No tabs defined.') ?></p>
<?php return; endif; ?>

<?php
$uid      = 'tabs-' . $bID;
$isPills  = ($tabStyle === 'pills');
$tabClass = 'sui-tabs' . ($isPills ? ' sui-tabs--pills' : '');
?>

<div class="<?= h($tabClass) ?>" x-data="{ active: <?= (int) $activeTab ?> }" role="tablist" aria-label="<?= t('Content tabs') ?>">

    <div class="sui-tabs__nav" role="tablist">
        <?php foreach ($entries as $i => $tab): ?>
        <button
            class="sui-tabs__tab"
            :class="{ 'sui-tabs__tab--active': active === <?= $i ?> }"
            @click="active = <?= $i ?>"
            role="tab"
            :aria-selected="active === <?= $i ?> ? 'true' : 'false'"
            :tabindex="active === <?= $i ?> ? 0 : -1"
            id="<?= h($uid) ?>-tab-<?= $i ?>"
            aria-controls="<?= h($uid) ?>-panel-<?= $i ?>"
        >
            <?php if (!empty($tab['icon'])): ?>
            <span class="sui-tabs__tab-icon" aria-hidden="true"><?= h($tab['icon']) ?></span>
            <?php endif; ?>
            <?= h($tab['label']) ?>
        </button>
        <?php endforeach; ?>
    </div>

    <?php foreach ($entries as $i => $tab): ?>
    <div
        class="sui-tabs__panel"
        x-show="active === <?= $i ?>"
        x-transition:enter="sui-transition-enter"
        x-transition:enter-start="sui-transition-enter-start"
        x-transition:enter-end="sui-transition-enter-end"
        role="tabpanel"
        id="<?= h($uid) ?>-panel-<?= $i ?>"
        aria-labelledby="<?= h($uid) ?>-tab-<?= $i ?>"
    >
        <?php if (!empty($tab['content'])): ?>
        <?= $tab['content'] ?>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>

</div>
