<?php
/**
 * Spectral Background Effects — view.php
 * Renders a section with animated background effect.
 * Effects are pure CSS (gradient-mesh, aurora, radial-glow, grid-pattern, noise-texture),
 * CSS + Alpine.js JS (fireflies), or Canvas API via Spectral UI particles.js.
 */
defined('C5_EXECUTE') or die('Access Denied.');

/** @var string $effectType @var string $colorA @var string $colorB @var string $colorC */
/** @var string $intensity  @var bool $animated @var int $particleCount */
/** @var string $minHeight  @var string $padding @var string $textColor @var string $content */

$uid = 'bg-' . $bID;

// Resolve colors — fallback to CSS custom properties
$ca = $colorA ?: 'var(--color-brand)';
$cb = $colorB ?: 'var(--color-accent, #06b6d4)';
$cc = $colorC ?: 'var(--color-bg)';

// Intensity → opacity multiplier string for CSS
$opacityMap = ['subtle' => '.08', 'medium' => '.18', 'intense' => '.38'];
$opacity = $opacityMap[$intensity] ?? '.18';

// Padding map
$padMap = ['none' => '0', 'sm' => 'var(--space-6)', 'md' => 'var(--space-12)', 'lg' => 'var(--space-16)', 'xl' => 'var(--space-20)'];
$pad = $padMap[$padding] ?? 'var(--space-12)';

// Text color
$txtColor = $textColor === 'light' ? '#fff' : ($textColor === 'dark' ? '#0f0f1a' : 'inherit');

// Animation duration scale by intensity
$animDur = ['subtle' => '18s', 'medium' => '12s', 'intense' => '7s'][$intensity] ?? '12s';
?>

<?php
// For particles effect the canvas is injected by particles.js into the SECTION itself.
// Convert color to RGB tuple for data-particles-color (format: "r,g,b")
$particlesColorRgb = '124,58,237'; // default brand violet
if ($colorA && preg_match('/^#([0-9a-f]{6})$/i', $colorA, $m)) {
    $particlesColorRgb = implode(',', [hexdec(substr($m[1],0,2)), hexdec(substr($m[1],2,2)), hexdec(substr($m[1],4,2))]);
}
$speedMap    = ['subtle' => '0.25', 'medium' => '0.5', 'intense' => '1.0'];
$connectDist = ['subtle' => '80',   'medium' => '130', 'intense' => '180'];
$pSpeed      = $speedMap[$intensity]   ?? '0.5';
$pConnect    = $connectDist[$intensity] ?? '130';
?>
<section id="<?= $uid ?>"
         class="sui-bg-effects sui-bg-effects--<?= h($effectType) ?> sui-bg-effects--<?= h($intensity) ?><?= $effectType === 'particles' ? ' sui-effect-canvas' : '' ?>"
         <?php if ($effectType === 'particles' && $animated): ?>
         data-effect="particles"
         data-particles-count="<?= $particleCount ?>"
         data-particles-color="<?= $particlesColorRgb ?>"
         data-particles-speed="<?= $pSpeed ?>"
         data-particles-connect-distance="<?= $pConnect ?>"
         <?php endif; ?>
         style="position: relative;
                overflow: hidden;
                min-height: <?= h($minHeight) ?>;
                padding: <?= $pad ?> var(--space-6);
                color: <?= $txtColor ?>;">

    <?php /* ──────────── BG LAYER ──────────── */ ?>
    <div class="sui-bg-effects__layer" aria-hidden="true"
         style="position: absolute; inset: 0; pointer-events: none; z-index: 0;">

        <?php if ($effectType === 'gradient-mesh'): ?>
        <div style="position:absolute;inset:0;
             background:
               radial-gradient(ellipse 80% 60% at 20% 30%,  color-mix(in srgb, <?= $ca ?> <?= (int)($opacity*100) ?>%, transparent) 0%, transparent 70%),
               radial-gradient(ellipse 60% 80% at 80% 70%,  color-mix(in srgb, <?= $cb ?> <?= (int)($opacity*100) ?>%, transparent) 0%, transparent 70%),
               radial-gradient(ellipse 50% 50% at 50% 50%,  color-mix(in srgb, <?= $cc ?> <?= max(4, (int)($opacity*50)) ?>%, transparent) 0%, transparent 60%);
             <?= $animated ? "animation: sui-bg-mesh-shift {$animDur} ease-in-out infinite alternate;" : '' ?>">
        </div>

        <?php elseif ($effectType === 'aurora'): ?>
        <div style="position:absolute;inset:0;
             background:
               conic-gradient(from 180deg at 50% 30%,
                 color-mix(in srgb, <?= $ca ?> <?= (int)($opacity*100) ?>%, transparent),
                 color-mix(in srgb, <?= $cb ?> <?= (int)($opacity*100) ?>%, transparent),
                 color-mix(in srgb, <?= $cc ?> <?= (int)($opacity*50) ?>%, transparent),
                 color-mix(in srgb, <?= $ca ?> <?= (int)($opacity*100) ?>%, transparent));
             filter: blur(40px);
             transform: scaleY(0.5) translateY(-30%);
             transform-origin: top center;
             <?= $animated ? "animation: sui-bg-aurora {$animDur} ease-in-out infinite alternate;" : '' ?>">
        </div>

        <?php elseif ($effectType === 'radial-glow'): ?>
        <div style="position:absolute;inset:0;
             background:
               radial-gradient(circle 60% at 50% 50%,
                 color-mix(in srgb, <?= $ca ?> <?= (int)($opacity*100) ?>%, transparent) 0%,
                 transparent 70%);
             <?= $animated ? "animation: sui-bg-pulse {$animDur} ease-in-out infinite alternate;" : '' ?>">
        </div>

        <?php elseif ($effectType === 'grid-pattern'): ?>
        <div style="position:absolute;inset:0;
             background-image:
               linear-gradient(color-mix(in srgb, <?= $ca ?> <?= (int)($opacity*100) ?>%, transparent) 1px, transparent 1px),
               linear-gradient(to right, color-mix(in srgb, <?= $ca ?> <?= (int)($opacity*100) ?>%, transparent) 1px, transparent 1px);
             background-size: 48px 48px;
             mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%);
             -webkit-mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%);
             <?= $animated ? "animation: sui-bg-grid-drift {$animDur} linear infinite;" : '' ?>">
        </div>

        <?php elseif ($effectType === 'noise-texture'): ?>
        <div style="position:absolute;inset:0;
             background-color: color-mix(in srgb, <?= $ca ?> <?= (int)($opacity*50) ?>%, transparent);
             opacity: <?= $opacity ?>;">
            <?php /* SVG noise filter */ ?>
            <svg style="position:absolute;inset:0;width:100%;height:100%;opacity:<?= $opacity ?>;" xmlns="http://www.w3.org/2000/svg">
                <filter id="<?= $uid ?>-noise">
                    <feTurbulence type="fractalNoise" baseFrequency="0.65" numOctaves="3" stitchTiles="stitch"/>
                    <feColorMatrix type="saturate" values="0"/>
                </filter>
                <rect width="100%" height="100%" filter="url(#<?= $uid ?>-noise)"/>
            </svg>
        </div>

        <?php elseif ($effectType === 'particles'): ?>
        <?php /* Canvas is injected by Spectral particles.js via data-effect="particles" on <section>.
                  Provide a tinted background so particles are visible against dark/light backgrounds. */ ?>
        <div style="position:absolute;inset:0;
             background: color-mix(in srgb, <?= $ca ?> <?= (int)($opacity*30) ?>%, transparent);">
        </div>

        <?php elseif ($effectType === 'fireflies'): ?>
        <?php /* Firefly particles rendered via Alpine.js + CSS */ ?>
        <div x-data="{
            particles: [],
            init() {
                const n = <?= $particleCount ?>;
                for (let i = 0; i < n; i++) {
                    this.particles.push({
                        x: Math.random() * 100,
                        y: Math.random() * 100,
                        size: Math.random() * 4 + 2,
                        dur: (Math.random() * 12 + 8).toFixed(1),
                        delay: (Math.random() * -20).toFixed(1),
                        opacity: (Math.random() * 0.6 + 0.2).toFixed(2),
                    });
                }
            }
        }" style="position:absolute;inset:0;overflow:hidden;">
            <template x-for="(p, i) in particles" :key="i">
                <div :style="`position:absolute;
                    left:${p.x}%;top:${p.y}%;
                    width:${p.size}px;height:${p.size}px;
                    border-radius:50%;
                    background: <?= $ca ?>;
                    box-shadow: 0 0 ${p.size*3}px <?= $ca ?>;
                    opacity:0;
                    animation: sui-firefly ${p.dur}s ${p.delay}s ease-in-out infinite;`">
                </div>
            </template>
        </div>
        <?php endif; ?>

    </div><!-- /.sui-bg-effects__layer -->

    <?php /* ──────────── CONTENT ──────────── */ ?>
    <div class="<?= $effectType === 'particles' ? 'sui-effect-canvas__content' : '' ?>"
         style="position: relative; z-index: 1; max-width: var(--content-max-width, 1200px); margin: 0 auto;">
        <?php if ($content): ?>
        <?= $content ?>
        <?php endif; ?>

        <?php /* CCMS-editable area inside the section */ ?>
        <?php $area = new \Concrete\Core\Area\Area('BG Content ' . $bID); ?>
        <?php $area->display($c ?? null); ?>
    </div>
</section>

<?php /* ──────────── KEYFRAMES (injected once per page) ──────────── */ ?>
<?php if ($animated): ?>
<style>
@keyframes sui-bg-mesh-shift {
    0%   { background-position: 0% 0%, 100% 100%, 50% 50%; }
    100% { background-position: 30% 40%, 70% 60%, 50% 50%; }
}
@keyframes sui-bg-aurora {
    0%   { transform: scaleY(0.5) translateY(-30%) rotate(0deg); }
    100% { transform: scaleY(0.6) translateY(-10%) rotate(3deg); }
}
@keyframes sui-bg-pulse {
    0%   { transform: scale(1); opacity: 1; }
    100% { transform: scale(1.15); opacity: 0.7; }
}
@keyframes sui-bg-grid-drift {
    0%   { background-position: 0 0; }
    100% { background-position: 48px 48px; }
}
@keyframes sui-firefly {
    0%,100% { opacity: 0; transform: translate(0,0) scale(1); }
    30%      { opacity: 1; }
    50%      { opacity: 0.6; transform: translate(<?= rand(-40,40) ?>px, <?= rand(-30,30) ?>px) scale(1.4); }
    70%      { opacity: 0.9; }
}
@media (prefers-reduced-motion: reduce) {
    .sui-bg-effects * { animation: none !important; }
}
</style>
<?php endif; ?>
