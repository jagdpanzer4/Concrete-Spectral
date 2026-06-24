<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div x-data='{
    effectType:    "<?= h($effectType) ?>",
    colorA:        "<?= h($colorA) ?>",
    colorB:        "<?= h($colorB) ?>",
    colorC:        "<?= h($colorC) ?>",
    intensity:     "<?= h($intensity) ?>",
    animated:      <?= $animated ? 'true' : 'false' ?>,
    particleCount: <?= (int)$particleCount ?>,
    minHeight:     "<?= h($minHeight) ?>",
    padding:       "<?= h($padding) ?>",
    textColor:     "<?= h($textColor) ?>",
}' style="font-size:14px;">

    <input type="hidden" name="effectType"    :value="effectType">
    <input type="hidden" name="colorA"        :value="colorA">
    <input type="hidden" name="colorB"        :value="colorB">
    <input type="hidden" name="colorC"        :value="colorC">
    <input type="hidden" name="intensity"     :value="intensity">
    <input type="hidden" name="animated"      :value="animated ? 1 : 0">
    <input type="hidden" name="particleCount" :value="particleCount">
    <input type="hidden" name="minHeight"     :value="minHeight">
    <input type="hidden" name="padding"       :value="padding">
    <input type="hidden" name="textColor"     :value="textColor">

    <!-- Effect Type -->
    <div style="margin-bottom:12px;">
        <label style="display:block;font-size:11px;font-weight:600;margin-bottom:4px;color:#a78bfa;">Effect Type</label>
        <select x-model="effectType"
                style="width:100%;padding:6px 10px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:5px;">
            <option value="gradient-mesh">Gradient Mesh</option>
            <option value="particles">Particles (Canvas)</option>
            <option value="aurora">Aurora Borealis</option>
            <option value="radial-glow">Radial Glow</option>
            <option value="grid-pattern">Grid Pattern</option>
            <option value="noise-texture">Noise Texture</option>
            <option value="fireflies">Fireflies (Alpine.js)</option>
        </select>
    </div>

    <!-- Colors -->
    <fieldset style="border:1px solid #555;border-radius:6px;padding:10px 14px;margin-bottom:12px;">
        <legend style="padding:0 6px;font-size:11px;font-weight:600;color:#a78bfa;">Colors (leave empty = theme defaults)</legend>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;align-items:center;">
            <div>
                <label style="display:block;font-size:11px;margin-bottom:3px;">Color A (primary)</label>
                <input type="color" x-model="colorA"
                       style="width:100%;height:36px;padding:2px;background:#1a1a2e;border:1px solid #444;border-radius:4px;cursor:pointer;">
                <input type="text" x-model="colorA" placeholder="or CSS value"
                       style="width:100%;margin-top:3px;padding:4px 6px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;font-size:11px;">
            </div>
            <div>
                <label style="display:block;font-size:11px;margin-bottom:3px;">Color B (accent)</label>
                <input type="color" x-model="colorB"
                       style="width:100%;height:36px;padding:2px;background:#1a1a2e;border:1px solid #444;border-radius:4px;cursor:pointer;">
                <input type="text" x-model="colorB" placeholder="or CSS value"
                       style="width:100%;margin-top:3px;padding:4px 6px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;font-size:11px;">
            </div>
            <div>
                <label style="display:block;font-size:11px;margin-bottom:3px;">Color C (base)</label>
                <input type="color" x-model="colorC"
                       style="width:100%;height:36px;padding:2px;background:#1a1a2e;border:1px solid #444;border-radius:4px;cursor:pointer;">
                <input type="text" x-model="colorC" placeholder="or CSS value"
                       style="width:100%;margin-top:3px;padding:4px 6px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;font-size:11px;">
            </div>
        </div>
    </fieldset>

    <!-- Layout & Behavior -->
    <fieldset style="border:1px solid #555;border-radius:6px;padding:10px 14px;margin-bottom:12px;">
        <legend style="padding:0 6px;font-size:11px;font-weight:600;color:#a78bfa;">Layout &amp; Behavior</legend>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:8px;">
            <div>
                <label style="display:block;font-size:11px;margin-bottom:3px;">Intensity</label>
                <select x-model="intensity"
                        style="width:100%;padding:5px 8px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;">
                    <option value="subtle">Subtle</option>
                    <option value="medium">Medium</option>
                    <option value="intense">Intense</option>
                </select>
            </div>
            <div>
                <label style="display:block;font-size:11px;margin-bottom:3px;">Padding</label>
                <select x-model="padding"
                        style="width:100%;padding:5px 8px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;">
                    <option value="none">None</option>
                    <option value="sm">Small</option>
                    <option value="md">Medium</option>
                    <option value="lg">Large</option>
                    <option value="xl">X-Large</option>
                </select>
            </div>
            <div>
                <label style="display:block;font-size:11px;margin-bottom:3px;">Text Color</label>
                <select x-model="textColor"
                        style="width:100%;padding:5px 8px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;">
                    <option value="light">Light (white)</option>
                    <option value="dark">Dark</option>
                    <option value="inherit">Inherit</option>
                </select>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;align-items:end;">
            <div>
                <label style="display:block;font-size:11px;margin-bottom:3px;">Min Height</label>
                <input type="text" x-model="minHeight" placeholder="400px"
                       style="width:100%;padding:5px 8px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;">
            </div>
            <div x-show="effectType === 'fireflies' || effectType === 'particles'">
                <label style="display:block;font-size:11px;margin-bottom:3px;">Particle Count</label>
                <input type="number" x-model.number="particleCount" min="5" max="200"
                       style="width:100%;padding:5px 8px;background:#1a1a2e;color:#e2e8f0;border:1px solid #444;border-radius:4px;">
            </div>
            <div style="padding-top:18px;">
                <label style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                    <input type="checkbox" x-model="animated"> Animated
                </label>
            </div>
        </div>
    </fieldset>

    <p style="font-size:11px;color:#64748b;margin:0;">
        💡 After saving, place other blocks inside the "<strong>BG Content</strong>" area that appears within this section.
    </p>
</div>
