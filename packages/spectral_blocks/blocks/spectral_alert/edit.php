<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div style="display:grid;gap:var(--space-4);">

<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-4);">
    <div>
        <label style="display:block;font-size:.85rem;margin-bottom:4px;"><?= t('Type') ?></label>
        <select name="alertType" style="width:100%;">
            <?php foreach (['info' => t('Info'), 'success' => t('Success'), 'warning' => t('Warning'), 'error' => t('Error')] as $val => $label): ?>
            <option value="<?= $val ?>" <?= ($alertType === $val) ? 'selected' : '' ?>><?= $label ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label style="display:block;font-size:.85rem;margin-bottom:4px;"><?= t('Icon (emoji or text)') ?></label>
        <input type="text" name="icon" value="<?= h($icon) ?>" style="width:100%;padding:6px 10px;border:1px solid #ccc;border-radius:4px;">
    </div>
</div>

<div>
    <label style="display:block;font-size:.85rem;margin-bottom:4px;"><?= t('Title') ?></label>
    <input type="text" name="alertTitle" value="<?= h($alertTitle) ?>" placeholder="<?= t('Optional bold heading') ?>" style="width:100%;padding:6px 10px;border:1px solid #ccc;border-radius:4px;">
</div>

<div>
    <label style="display:block;font-size:.85rem;margin-bottom:4px;"><?= t('Body') ?></label>
    <textarea name="alertBody" rows="4" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:.875rem;resize:vertical;"><?= h($alertBody) ?></textarea>
</div>

<label style="display:flex;gap:8px;align-items:center;font-size:.875rem;">
    <input type="checkbox" name="dismissible" <?= $dismissible ? 'checked' : '' ?>>
    <?= t('Dismissible (show ✕ close button)') ?>
</label>

</div>
