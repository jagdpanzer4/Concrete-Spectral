<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div
    class="sui-alert sui-alert--<?= h($alertType) ?>"
    role="alert"
    <?php if ($dismissible): ?>x-data="{ visible: true }" x-show="visible" x-transition<?php endif; ?>
>
    <div class="sui-alert__body">
        <?php if (!empty($icon)): ?>
        <span class="sui-alert__icon" aria-hidden="true"><?= h($icon) ?></span>
        <?php endif; ?>
        <div class="sui-alert__content">
            <?php if (!empty($alertTitle)): ?>
            <strong class="sui-alert__title"><?= h($alertTitle) ?></strong>
            <?php endif; ?>
            <?php if (!empty($alertBody)): ?>
            <div class="sui-alert__text"><?= $alertBody ?></div>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($dismissible): ?>
    <button class="sui-alert__close" @click="visible = false" aria-label="<?= t('Dismiss') ?>">✕</button>
    <?php endif; ?>
</div>
