<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div x-data="spectralTabsEdit(<?= h(json_encode($entries)) ?>)" x-init="init()">

<div style="display:flex;gap:var(--space-4);margin-bottom:var(--space-5);flex-wrap:wrap;">
    <div style="flex:1;min-width:160px;">
        <label style="display:block;font-size:.85rem;margin-bottom:4px;"><?= t('Style') ?></label>
        <select name="tabStyle" style="width:100%">
            <option value="line"  <?= ($tabStyle  === 'line')  ? 'selected' : '' ?>><?= t('Underline') ?></option>
            <option value="pills" <?= ($tabStyle  === 'pills') ? 'selected' : '' ?>><?= t('Pills') ?></option>
        </select>
    </div>
    <div style="flex:1;min-width:160px;">
        <label style="display:block;font-size:.85rem;margin-bottom:4px;"><?= t('Default open tab') ?></label>
        <select name="activeTab">
            <?php for ($i = 0; $i < 10; $i++): ?>
            <option value="<?= $i ?>" <?= ((int)$activeTab === $i) ? 'selected' : '' ?>><?= t('Tab %s', $i + 1) ?></option>
            <?php endfor; ?>
        </select>
    </div>
</div>

<div style="margin-bottom:var(--space-4);">
    <template x-for="(tab, idx) in entries" :key="idx">
    <div style="border:1px solid #ddd;border-radius:6px;padding:12px;margin-bottom:8px;background:#f9f9f9;">
        <div style="display:flex;gap:8px;margin-bottom:8px;align-items:center;">
            <input type="text" x-model="tab.label" placeholder="<?= t('Tab label') ?>" style="flex:1;padding:6px 10px;border:1px solid #ccc;border-radius:4px;">
            <input type="text" x-model="tab.icon"  placeholder="<?= t('Icon (emoji or text)') ?>" style="width:120px;padding:6px 10px;border:1px solid #ccc;border-radius:4px;">
            <button type="button" @click="remove(idx)" style="background:#ef4444;color:#fff;border:none;border-radius:4px;padding:6px 10px;cursor:pointer;">✕</button>
        </div>
        <textarea x-model="tab.content" rows="4" placeholder="<?= t('Tab content (HTML)') ?>" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:.875rem;resize:vertical;"></textarea>
    </div>
    </template>
</div>

<button type="button" @click="addTab()" style="padding:8px 16px;background:var(--ccm-base-color,#3478f6);color:#fff;border:none;border-radius:4px;cursor:pointer;margin-bottom:12px;">
    + <?= t('Add Tab') ?>
</button>

<input type="hidden" name="entriesJson" :value="JSON.stringify(entries)">
</div>

<script>
function spectralTabsEdit(initial) {
    return {
        entries: initial && initial.length ? initial : [
            { label: '<?= t('Tab 1') ?>', icon: '', content: '' },
            { label: '<?= t('Tab 2') ?>', icon: '', content: '' },
        ],
        init() {},
        addTab() {
            this.entries.push({ label: '<?= t('New Tab') ?>', icon: '', content: '' });
        },
        remove(idx) {
            this.entries.splice(idx, 1);
        }
    };
}
</script>
