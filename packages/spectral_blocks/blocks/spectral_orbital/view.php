<?php
/**
 * Spectral Orbital — view.php
 * CSS-only 3D rotating orbital showcase.
 * Items are positioned via PHP-computed inline transforms.
 */
defined('C5_EXECUTE') or die('Access Denied.');

/** @var string $centerIcon @var string $centerLabel @var string $centerSublabel */
/** @var string $ringSize @var string $animSpeed @var bool $showRing @var string $variant */
/** @var array  $items */

$ringPx = ['sm' => 200, 'md' => 300, 'lg' => 420][$ringSize] ?? 300;
$duration = ['slow' => '36s', 'normal' => '22s', 'fast' => '12s', 'pause' => '0s'][$animSpeed] ?? '22s';
$n = count($items);

// Item display size
$itemPx = ['sm' => 56, 'md' => 70, 'lg' => 86][$ringSize] ?? 70;

$uid = 'orbital-' . $this->bID;
?>
<div class="sui-orbital sui-orbital--<?= h($variant) ?> sui-orbital--<?= h($ringSize) ?>"
     style="--orbital-size: <?= $ringPx * 2 + $itemPx ?>px;
            --orbital-radius: <?= $ringPx ?>px;
            --orbital-item-size: <?= $itemPx ?>px;
            --orbital-duration: <?= $duration ?>;
            width: var(--orbital-size);
            height: var(--orbital-size);
            margin: 0 auto;
            position: relative;"
     aria-label="<?= h($centerLabel ?: 'Orbital showcase') ?>">

    <?php if ($showRing): ?>
    <div class="sui-orbital__ring-track" aria-hidden="true"
         style="position: absolute;
                inset: 0;
                border-radius: 50%;
                border: 1px dashed rgba(var(--color-brand-rgb, 124,58,237), 0.3);"></div>
    <?php endif; ?>

    <?php /* Rotating ring — items inside orbit with it */ ?>
    <div class="sui-orbital__ring"
         style="position: absolute; inset: 0;
                animation: sui-orbit <?= $duration ?> linear infinite;">

        <?php foreach ($items as $i => $item):
            $angle   = $n > 0 ? ($i * 360 / $n) : 0;
            $rad     = deg2rad($angle);
            // Position: center of ring + offset by radius in the angle direction
            // Using top/left so animation doesn't conflict with transform
            $x = 50 + 50 * sin($rad);   // % of ring container
            $y = 50 - 50 * cos($rad);   // % of ring container
            $color   = $item['color'] ? $item['color'] : 'var(--color-brand)';
            $icon    = htmlspecialchars($item['icon']    ?? '', ENT_QUOTES);
            $label   = htmlspecialchars($item['label']   ?? '', ENT_QUOTES);
            $sublabel= htmlspecialchars($item['sublabel']?? '', ENT_QUOTES);
        ?>
        <div class="sui-orbital__item"
             style="position: absolute;
                    left: <?= number_format($x, 4) ?>%;
                    top: <?= number_format($y, 4) ?>%;
                    width: var(--orbital-item-size);
                    height: var(--orbital-item-size);
                    margin-left: calc(var(--orbital-item-size) / -2);
                    margin-top: calc(var(--orbital-item-size) / -2);
                    animation: sui-counter-orbit <?= $duration ?> linear infinite;">

            <div class="sui-orbital__item-inner"
                 title="<?= $label ?>"
                 style="width: 100%; height: 100%;
                        display: flex; flex-direction: column;
                        align-items: center; justify-content: center;
                        border-radius: 50%;
                        border: 1px solid <?= $color ?>;
                        background: color-mix(in srgb, <?= $color ?> 12%, transparent);
                        font-size: calc(var(--orbital-item-size) * 0.38);
                        gap: 2px;
                        cursor: default;
                        transition: box-shadow var(--transition-fast);"
                 onmouseenter="this.style.boxShadow='0 0 18px <?= $color ?>66'"
                 onmouseleave="this.style.boxShadow='none'">
                <?php if ($icon): ?>
                <span aria-hidden="true"><?= $icon ?></span>
                <?php endif; ?>
                <?php if ($label): ?>
                <span style="font-size: calc(var(--orbital-item-size) * 0.14);
                             font-weight: 600; color: <?= $color ?>;
                             white-space: nowrap; overflow: hidden;
                             text-overflow: ellipsis; max-width: 90%;
                             text-align: center; line-height: 1.1;">
                    <?= $label ?>
                </span>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div><!-- /.sui-orbital__ring -->

    <?php /* Center */ ?>
    <div class="sui-orbital__center"
         style="position: absolute;
                top: 50%; left: 50%;
                transform: translate(-50%, -50%);
                z-index: 3;
                display: flex; flex-direction: column;
                align-items: center; justify-content: center;
                text-align: center;
                width: calc(var(--orbital-radius) * 0.72);
                height: calc(var(--orbital-radius) * 0.72);
                border-radius: 50%;">

        <?php if ($variant === 'glow'): ?>
        <div style="position: absolute; inset: -4px; border-radius: 50%;
                    background: radial-gradient(circle, var(--color-brand-glow, rgba(124,58,237,.25)) 0%, transparent 70%);
                    pointer-events: none;" aria-hidden="true"></div>
        <?php endif; ?>

        <div style="position: relative; z-index: 1;
                    width: 100%; height: 100%;
                    display: flex; flex-direction: column;
                    align-items: center; justify-content: center;
                    border-radius: 50%;
                    border: 2px solid var(--color-brand);
                    <?php if ($variant === 'glass'): ?>
                    background: rgba(var(--color-bg-elevated-rgb, 30,20,60), 0.5);
                    backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
                    <?php elseif ($variant === 'glow'): ?>
                    background: var(--color-bg-elevated);
                    box-shadow: 0 0 32px var(--color-brand-glow, rgba(124,58,237,.35));
                    <?php else: ?>
                    background: var(--color-bg-elevated);
                    <?php endif; ?>
                    padding: var(--space-4);">

            <?php if ($centerIcon): ?>
            <span style="font-size: calc(var(--orbital-radius) * 0.18); line-height: 1;" aria-hidden="true">
                <?= htmlspecialchars($centerIcon, ENT_QUOTES) ?>
            </span>
            <?php endif; ?>

            <?php if ($centerLabel): ?>
            <span style="font-family: var(--font-family-display);
                         font-size: calc(var(--orbital-radius) * 0.09);
                         font-weight: 700;
                         color: var(--color-text);
                         margin-top: var(--space-2);
                         line-height: 1.2;
                         text-align: center;">
                <?= htmlspecialchars($centerLabel, ENT_QUOTES) ?>
            </span>
            <?php endif; ?>

            <?php if ($centerSublabel): ?>
            <span style="font-size: calc(var(--orbital-radius) * 0.06);
                         color: var(--color-text-muted);
                         margin-top: var(--space-1);
                         line-height: 1.3;
                         text-align: center;">
                <?= htmlspecialchars($centerSublabel, ENT_QUOTES) ?>
            </span>
            <?php endif; ?>
        </div>
    </div>
</div>
