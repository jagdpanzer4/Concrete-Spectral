<?php defined('C5_EXECUTE') or die('Access Denied.');
$platforms = \Concrete\Package\SpectralBlocks\Block\SpectralSocialLinks\Controller::getPlatforms();
?>
<div x-data="spectralSocialEdit(<?= h(json_encode($links)) ?>)">

<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-4);margin-bottom:var(--space-5);">
    <div>
        <label style="display:block;font-size:.85rem;margin-bottom:4px;"><?= t('Display Style') ?></label>
        <select name="style" style="width:100%;">
            <option value="icon"       <?= ($style==='icon')       ? 'selected' : '' ?>><?= t('Icons only') ?></option>
            <option value="icon-label" <?= ($style==='icon-label') ? 'selected' : '' ?>><?= t('Icons + Labels') ?></option>
        </select>
    </div>
    <div>
        <label style="display:block;font-size:.85rem;margin-bottom:4px;"><?= t('Size') ?></label>
        <select name="size" style="width:100%;">
            <option value="sm" <?= ($size==='sm') ? 'selected' : '' ?>>Small (32px)</option>
            <option value="md" <?= ($size==='md') ? 'selected' : '' ?>>Medium (44px)</option>
            <option value="lg" <?= ($size==='lg') ? 'selected' : '' ?>>Large (56px)</option>
        </select>
    </div>
</div>

<template x-for="(link, idx) in links" :key="idx">
<div style="display:grid;grid-template-columns:150px 1fr 1fr auto;gap:6px;align-items:center;margin-bottom:6px;">
    <select x-model="link.platform" style="padding:5px;border:1px solid #ccc;border-radius:4px;font-size:.875rem;">
        <?php foreach ($platforms as $p): ?>
        <option value="<?= $p ?>"><?= ucfirst($p) ?></option>
        <?php endforeach; ?>
    </select>
    <input x-model="link.url"   placeholder="https://..." style="padding:5px;border:1px solid #ccc;border-radius:4px;font-size:.875rem;">
    <input x-model="link.label" placeholder="<?= t('Label (optional)') ?>" style="padding:5px;border:1px solid #ccc;border-radius:4px;font-size:.875rem;">
    <button type="button" @click="links.splice(idx,1)" style="background:#ef4444;color:#fff;border:none;border-radius:4px;padding:5px 9px;cursor:pointer;">✕</button>
</div>
</template>

<button type="button" @click="links.push({platform:'github',url:'',label:''})" style="margin-top:6px;padding:7px 14px;background:var(--ccm-base-color,#3478f6);color:#fff;border:none;border-radius:4px;cursor:pointer;">
    + <?= t('Add Link') ?>
</button>

<input type="hidden" name="linksJson" :value="JSON.stringify(links)">
</div>

<script>
function spectralSocialEdit(initial) { return { links: initial && initial.length ? initial : [] }; }
</script>
