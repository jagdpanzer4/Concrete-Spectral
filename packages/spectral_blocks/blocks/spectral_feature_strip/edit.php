<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div x-data="spectralStripEdit(<?= h(json_encode($items)) ?>)">

<div style="margin-bottom:var(--space-4);">
    <label style="font-size:.85rem;display:block;margin-bottom:4px;"><?= t('Alignment') ?></label>
    <select name="align">
        <option value="left"   <?= $align==='left'   ?'selected':'' ?>>Left</option>
        <option value="center" <?= $align==='center' ?'selected':'' ?>>Center</option>
        <option value="right"  <?= $align==='right'  ?'selected':'' ?>>Right</option>
    </select>
</div>

<template x-for="(item, idx) in items" :key="idx">
<div style="display:grid;grid-template-columns:80px 1fr 1fr 1fr auto;gap:6px;align-items:center;margin-bottom:6px;">
    <input x-model="item.icon"     placeholder="<?= t('Icon') ?>" style="padding:5px;border:1px solid #ccc;border-radius:4px;font-size:.875rem;">
    <input x-model="item.title"    placeholder="<?= t('Title') ?>" style="padding:5px;border:1px solid #ccc;border-radius:4px;font-size:.875rem;">
    <input x-model="item.subtitle" placeholder="<?= t('Subtitle') ?>" style="padding:5px;border:1px solid #ccc;border-radius:4px;font-size:.875rem;">
    <input x-model="item.linkURL"  placeholder="<?= t('Link URL (optional)') ?>" style="padding:5px;border:1px solid #ccc;border-radius:4px;font-size:.875rem;">
    <button type="button" @click="items.splice(idx,1)" style="background:#ef4444;color:#fff;border:none;border-radius:4px;padding:5px 9px;cursor:pointer;">✕</button>
</div>
</template>

<button type="button" @click="items.push({icon:'✨',title:'',subtitle:'',linkURL:''})" style="margin-top:6px;padding:7px 14px;background:var(--ccm-base-color,#3478f6);color:#fff;border:none;border-radius:4px;cursor:pointer;">
    + <?= t('Add Item') ?>
</button>

<input type="hidden" name="itemsJson" :value="JSON.stringify(items)">
</div>

<script>
function spectralStripEdit(initial) { return { items: initial && initial.length ? initial : [{icon:'⚡',title:'',subtitle:'',linkURL:''}] }; }
</script>
