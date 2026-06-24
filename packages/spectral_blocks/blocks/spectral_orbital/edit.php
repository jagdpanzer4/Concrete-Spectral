<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div x-data='{
    centerIcon:     "<?= addslashes(h($centerIcon)) ?>",
    centerLabel:    "<?= addslashes(h($centerLabel)) ?>",
    centerSublabel: "<?= addslashes(h($centerSublabel)) ?>",
    ringSize:       "<?= h($ringSize) ?>",
    animSpeed:      "<?= h($animSpeed) ?>",
    showRing:       <?= $showRing ? 'true' : 'false' ?>,
    variant:        "<?= h($variant) ?>",
    items: <?= $itemsJson ?: '[]' ?>,
    addItem() {
        this.items.push({ icon: "⭐", label: "Item", sublabel: "", color: "#7c3aed" });
    },
    removeItem(i) { this.items.splice(i, 1); },
    moveUp(i)     { if (i > 0) { let t = this.items.splice(i,1)[0]; this.items.splice(i-1,0,t); } },
    moveDown(i)   { if (i < this.items.length-1) { let t = this.items.splice(i,1)[0]; this.items.splice(i+1,0,t); } },
}' style="font-size:14px;">

    <input type="hidden" name="itemsJson"       :value="JSON.stringify(items)">
    <input type="hidden" name="centerIcon"      :value="centerIcon">
    <input type="hidden" name="centerLabel"     :value="centerLabel">
    <input type="hidden" name="centerSublabel"  :value="centerSublabel">
    <input type="hidden" name="ringSize"        :value="ringSize">
    <input type="hidden" name="animSpeed"       :value="animSpeed">
    <input type="hidden" name="showRing"        :value="showRing ? 1 : 0">
    <input type="hidden" name="variant"         :value="variant">

    <!-- Center -->
    <fieldset style="border:1px solid #555;border-radius:6px;padding:10px 14px;margin-bottom:12px;">
        <legend style="padding:0 6px;font-weight:600;color:#a78bfa;">Center</legend>
        <div style="display:grid;grid-template-columns:80px 1fr 1fr;gap:8px;align-items:end;">
            <div>
                <label style="display:block;font-size:11px;margin-bottom:3px;">Icon / Emoji</label>
                <input type="text" x-model="centerIcon"
                       placeholder="🚀"
                       style="width:100%;padding:5px 8px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;">
            </div>
            <div>
                <label style="display:block;font-size:11px;margin-bottom:3px;">Title</label>
                <input type="text" x-model="centerLabel"
                       placeholder="Spectral UI"
                       style="width:100%;padding:5px 8px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;">
            </div>
            <div>
                <label style="display:block;font-size:11px;margin-bottom:3px;">Subtitle</label>
                <input type="text" x-model="centerSublabel"
                       placeholder="Design System"
                       style="width:100%;padding:5px 8px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;">
            </div>
        </div>
    </fieldset>

    <!-- Options -->
    <fieldset style="border:1px solid #555;border-radius:6px;padding:10px 14px;margin-bottom:12px;">
        <legend style="padding:0 6px;font-weight:600;color:#a78bfa;">Options</legend>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr 100px;gap:8px;align-items:end;">
            <div>
                <label style="display:block;font-size:11px;margin-bottom:3px;">Ring Size</label>
                <select x-model="ringSize"
                        style="width:100%;padding:5px 8px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;">
                    <option value="sm">Small (200px)</option>
                    <option value="md">Medium (300px)</option>
                    <option value="lg">Large (420px)</option>
                </select>
            </div>
            <div>
                <label style="display:block;font-size:11px;margin-bottom:3px;">Animation Speed</label>
                <select x-model="animSpeed"
                        style="width:100%;padding:5px 8px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;">
                    <option value="slow">Slow (36s)</option>
                    <option value="normal">Normal (22s)</option>
                    <option value="fast">Fast (12s)</option>
                    <option value="pause">Paused</option>
                </select>
            </div>
            <div>
                <label style="display:block;font-size:11px;margin-bottom:3px;">Variant</label>
                <select x-model="variant"
                        style="width:100%;padding:5px 8px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;">
                    <option value="glow">Glow</option>
                    <option value="glass">Glass</option>
                    <option value="flat">Flat</option>
                </select>
            </div>
            <div style="padding-top:18px;">
                <label style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                    <input type="checkbox" x-model="showRing"> Show ring track
                </label>
            </div>
        </div>
    </fieldset>

    <!-- Orbital Items -->
    <div style="font-weight:600;margin-bottom:6px;color:#a78bfa;">
        Orbital Items <span x-text="'(' + items.length + ')'" style="font-weight:400;color:#94a3b8;"></span>
    </div>
    <div style="max-height:240px;overflow-y:auto;border:1px solid #333;border-radius:6px;padding:6px;">
        <template x-if="items.length === 0">
            <p style="color:#64748b;text-align:center;padding:12px;font-size:12px;">
                No items yet — add some below
            </p>
        </template>
        <template x-for="(item, idx) in items" :key="idx">
            <div style="display:grid;grid-template-columns:60px 1fr 1fr 70px 24px 24px 24px;gap:6px;align-items:center;
                        padding:5px 4px;border-bottom:1px solid #2a2a3e;" x-bind:style="idx===items.length-1 ? 'border-bottom:none' : ''">
                <input type="text" x-model="item.icon"
                       placeholder="Icon"
                       style="padding:4px 6px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;font-size:18px;text-align:center;">
                <input type="text" x-model="item.label"
                       placeholder="Label"
                       style="padding:4px 6px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;">
                <input type="text" x-model="item.sublabel"
                       placeholder="Sublabel"
                       style="padding:4px 6px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;">
                <input type="color" x-model="item.color"
                       style="width:100%;height:30px;padding:1px;background:#1a1a2e;border:1px solid #444;border-radius:4px;cursor:pointer;">
                <button type="button" @click="moveUp(idx)"
                        title="Move up"
                        style="background:none;border:1px solid #444;border-radius:3px;color:#94a3b8;cursor:pointer;padding:2px 5px;">↑</button>
                <button type="button" @click="moveDown(idx)"
                        title="Move down"
                        style="background:none;border:1px solid #444;border-radius:3px;color:#94a3b8;cursor:pointer;padding:2px 5px;">↓</button>
                <button type="button" @click="removeItem(idx)"
                        title="Remove"
                        style="background:none;border:1px solid #c0392b;border-radius:3px;color:#e74c3c;cursor:pointer;padding:2px 5px;">✕</button>
            </div>
        </template>
    </div>
    <button type="button" @click="addItem()"
            style="margin-top:8px;padding:6px 14px;background:var(--color-brand,#7c3aed);color:#fff;
                   border:none;border-radius:5px;cursor:pointer;font-size:13px;">
        + Add Item
    </button>
</div>
