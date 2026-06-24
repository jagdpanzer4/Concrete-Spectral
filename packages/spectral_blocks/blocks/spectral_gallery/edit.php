<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div x-data="spectralGalleryEdit(<?= h(json_encode(array_map(fn($img) => ['fID' => $img['fID'], 'caption' => $img['caption'], 'altText' => $img['altText'], 'url' => $img['thumb'] ?: $img['url']], $images))) ?>)">

<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-4);margin-bottom:var(--space-5);">
    <div>
        <label style="display:block;font-size:.85rem;margin-bottom:4px;"><?= t('Layout') ?></label>
        <select name="layout" style="width:100%;">
            <option value="grid"    <?= ($layout  === 'grid')    ? 'selected' : '' ?>><?= t('Grid') ?></option>
            <option value="masonry" <?= ($layout  === 'masonry') ? 'selected' : '' ?>><?= t('Masonry') ?></option>
        </select>
    </div>
    <div>
        <label style="display:block;font-size:.85rem;margin-bottom:4px;"><?= t('Columns') ?></label>
        <select name="columns" style="width:100%;">
            <?php for ($i = 1; $i <= 6; $i++): ?>
            <option value="<?= $i ?>" <?= ((int)$columns === $i) ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
        </select>
    </div>
</div>

<div style="display:flex;gap:var(--space-6);margin-bottom:var(--space-5);">
    <label style="display:flex;gap:6px;align-items:center;font-size:.875rem;">
        <input type="checkbox" name="lightbox" <?= $lightbox ? 'checked' : '' ?>> <?= t('Enable Lightbox') ?>
    </label>
    <label style="display:flex;gap:6px;align-items:center;font-size:.875rem;">
        <input type="checkbox" name="caption" <?= $caption ? 'checked' : '' ?>> <?= t('Show Captions') ?>
    </label>
</div>

<div x-ref="filesList">
    <template x-for="(img, idx) in items" :key="idx">
    <div style="display:flex;gap:8px;align-items:center;padding:8px;border:1px solid #ddd;border-radius:6px;margin-bottom:6px;background:#fafafa;">
        <img :src="img.url" alt="" style="width:64px;height:48px;object-fit:cover;border-radius:4px;flex-shrink:0;" x-show="img.url">
        <div style="flex:1;display:flex;flex-direction:column;gap:4px;">
            <input type="text" x-model="img.caption" placeholder="<?= t('Caption') ?>" style="width:100%;padding:4px 8px;border:1px solid #ccc;border-radius:4px;font-size:.8rem;">
            <input type="text" x-model="img.altText" placeholder="<?= t('Alt text') ?>" style="width:100%;padding:4px 8px;border:1px solid #ccc;border-radius:4px;font-size:.8rem;">
        </div>
        <button type="button" @click="remove(idx)" style="background:#ef4444;color:#fff;border:none;border-radius:4px;padding:6px 10px;cursor:pointer;flex-shrink:0;">✕</button>
    </div>
    </template>
</div>

<button type="button" onclick="CCM.app.$emit('OpenFilePicker', { multiple: true, onSelect: (files) => { window._spectralGalleryAdd(files) } })" style="padding:8px 16px;background:var(--ccm-base-color,#3478f6);color:#fff;border:none;border-radius:4px;cursor:pointer;margin-bottom:12px;">
    <?= t('Add Images from File Manager') ?>
</button>

<input type="hidden" name="imagesJson" x-bind:value="JSON.stringify(items)">
</div>

<script>
function spectralGalleryEdit(initial) {
    return {
        items: initial || [],
        remove(idx) { this.items.splice(idx, 1); },
        addImages(files) {
            files.forEach(f => this.items.push({ fID: f.fID, caption: '', altText: f.title || '', url: f.thumbnailURL || f.url || '' }));
        }
    };
}
</script>
