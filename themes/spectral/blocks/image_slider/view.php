<?php defined('C5_EXECUTE') or die('Access Denied.');
/**
 * Spectral image_slider — follows Spectral UI showcase pattern exactly.
 *
 * @var array    $rows            Slide entries: fID, title, description, linkURL, sortOrder
 * @var int|null $navigationType  0=arrows, 1=dots, 2=both, else=none
 * @var int|null $timeout         Auto-advance ms (default 4000)
 * @var int|null $noAnimate       1 = disable auto-advance
 * @var int|null $pause           1 = pause on hover
 * @var int|null $maxWidth        Max width px
 */

use Concrete\Core\Page\Page;

$c = Page::getCurrentPage();

if ($c && $c->isEditMode()) { ?>
    <div class="sui-slider" style="padding:2rem;background:var(--color-bg-elevated);border:2px dashed var(--color-border);border-radius:var(--radius-xl);text-align:center;color:var(--color-text-muted);">
        <p style="margin:0"><?= t('Image Slider — %d slide(s)', count($rows ?? [])) ?></p>
    </div>
<?php return; }

$slides     = $rows ?? [];
$total      = count($slides);
$navType    = (int)($navigationType ?? 0);
$intervalMs = (int)($timeout ?? 4000);
$autoplay   = empty($noAnimate) ? 'true' : 'false';
$pause      = !empty($pause);
$showArrows = in_array($navType, [0, 2], true);
$showDots   = in_array($navType, [1, 2], true);
$showControls = ($showArrows || $showDots) && $total > 1;
?>

<div class="sui-slider"
     role="region"
     aria-label="<?= t('Image Slider') ?>"
     <?php if (!empty($maxWidth)): ?>style="max-width:<?= (int)$maxWidth ?>px"<?php endif; ?>
     x-data="{
         current: 0,
         total: <?= $total ?>,
         _timer: null,
         prev()  { this.current = (this.current - 1 + this.total) % this.total },
         next()  { this.current = (this.current + 1) % this.total },
         goto(i) { this.current = i },
         startAuto() {
             if (<?= $autoplay ?> && this.total > 1) {
                 this._timer = setInterval(() => this.next(), <?= $intervalMs ?>);
             }
         },
         stopAuto() { clearInterval(this._timer) }
     }"
     x-init="startAuto()"
     <?php if ($pause): ?>@mouseenter="stopAuto()" @mouseleave="startAuto()"<?php endif; ?>>

    <?php if ($total > 0): ?>

    <div class="sui-slider__track"
         style="overflow:hidden;border-radius:var(--radius-xl);"
         :style="`transform:translateX(-${current * 100}%)`"
         aria-live="polite">
        <?php foreach ($slides as $i => $row):
            $f      = \File::getByID($row['fID']);
            $imgSrc = '';
            $imgAlt = h($row['title'] ?: t('Slide %s', $i + 1));
            if (is_object($f) && !$f->isError()) {
                $imgSrc = $f->getApprovedVersion()->getURL();
            }
        ?>
        <div class="sui-slider__slide"
             :class="{ 'is-active': current === <?= $i ?> }"
             :aria-hidden="(current !== <?= $i ?>).toString()">

            <?php if ($row['linkURL']): ?>
            <a href="<?= h($row['linkURL']) ?>" class="sui-slider__link">
            <?php endif; ?>

            <?php if ($imgSrc): ?>
            <img src="<?= h($imgSrc) ?>"
                 alt="<?= $imgAlt ?>"
                 class="sui-slider__image"
                 loading="<?= $i === 0 ? 'eager' : 'lazy' ?>">
            <?php endif; ?>

            <?php if ($row['linkURL']): ?></a><?php endif; ?>

            <?php if ($row['title'] || $row['description']): ?>
            <div class="sui-slider__caption">
                <?php if ($row['title']): ?>
                    <p class="sui-slider__caption-title"><?= h($row['title']) ?></p>
                <?php endif; ?>
                <?php if ($row['description']): ?>
                    <p class="sui-slider__caption-body"><?= h($row['description']) ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div>
        <?php endforeach; ?>
    </div>

    <?php if ($showControls): ?>
    <div class="sui-slider__controls">
        <?php if ($showArrows): ?>
        <button class="sui-slider__btn"
                @click="prev()"
                aria-label="<?= t('Previous slide') ?>">←</button>
        <?php endif; ?>

        <?php if ($showDots): ?>
        <div class="sui-slider__dots">
            <?php for ($i = 0; $i < $total; $i++): ?>
            <button class="sui-slider__dot"
                    :class="{ 'is-active': current === <?= $i ?> }"
                    @click="goto(<?= $i ?>)"
                    aria-label="<?= h(t('Go to slide %s', $i + 1)) ?>">
            </button>
            <?php endfor; ?>
        </div>
        <?php endif; ?>

        <?php if ($showArrows): ?>
        <button class="sui-slider__btn"
                @click="next()"
                aria-label="<?= t('Next slide') ?>">→</button>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <div style="padding:2rem;text-align:center;color:var(--color-text-muted);background:var(--color-bg-elevated);border-radius:var(--radius-xl);">
        <p><?= t('No slides entered.') ?></p>
    </div>
    <?php endif; ?>

</div>


use Concrete\Core\Page\Page;

$c = Page::getCurrentPage();

if ($c && $c->isEditMode()) { ?>
    <div class="sui-slider sui-slider--edit-mode ccm-edit-mode-disabled-item">
        <i class="fas fa-images sui-slider__edit-icon" aria-hidden="true"></i>
        <p><?= t('Image Slider disabled in edit mode.') ?></p>
        <?php if (!empty($rows)): ?>
        <div class="sui-slider__edit-dots" aria-hidden="true">
            <?php foreach ($rows as $row): ?>
                <i class="fas fa-circle"></i>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
<?php return;
} ?>

<?php
$slides       = $rows ?? [];
$total        = count($slides);
$navType      = (int) ($navigationType ?? 0);
$intervalMs   = (int) ($timeout ?? 4000);
$autoplay     = empty($noAnimate) ? 'true' : 'false';
$pauseOnHover = !empty($pause);
$showArrows   = in_array($navType, [0, 2], true);
$showDots     = in_array($navType, [1, 2], true);

// Default to arrows when navigationType is 0 and dots not set
if ($navType === 0 && !$showDots) {
    $showArrows = true;
}
?>

<div class="sui-slider sui-slider--overlay"
     role="region"
     aria-label="<?= t('Image Slider') ?>"
     <?php if ($maxWidth): ?>style="max-width: <?= (int) $maxWidth ?>px"<?php endif; ?>
     x-data="{
         current: 0,
         total: <?= $total ?>,
         autoplay: <?= $autoplay ?>,
         _timer: null,
         prev() { this.current = (this.current - 1 + this.total) % this.total },
         next() { this.current = (this.current + 1) % this.total },
         goto(i) { this.current = i },
         startAuto() {
             if (this.autoplay && this.total > 1) {
                 this._timer = setInterval(() => this.next(), <?= $intervalMs ?>);
             }
         },
         stopAuto() { clearInterval(this._timer) }
     }"
     x-init="startAuto()"
     <?php if ($pauseOnHover): ?>@mouseenter="stopAuto()" @mouseleave="startAuto()"<?php endif; ?>>

    <?php if ($total > 0): ?>

    <div class="sui-slider__track"
         aria-live="polite"
         aria-atomic="false"
         :style="`transform:translateX(-${current * 100}%)`">
        <?php foreach ($slides as $i => $row): ?>
            <?php
            $f      = \File::getByID($row['fID']);
            $imgSrc = '';
            $imgAlt = h($row['title'] ?: t('Slide %s', $i + 1));

            if (is_object($f) && !$f->isError()) {
                $fv     = $f->getVersion();
                $imgSrc = $fv->getURL();
            }
            ?>
            <div class="sui-slider__slide"
                 :aria-hidden="current !== <?= $i ?> ? 'true' : 'false'">

                <?php if ($row['linkURL']): ?>
                <a href="<?= h($row['linkURL']) ?>" class="sui-slider__link">
                <?php endif; ?>

                <?php if ($imgSrc): ?>
                <img
                    src="<?= h($imgSrc) ?>"
                    alt="<?= $imgAlt ?>"
                    class="sui-slider__image"
                    <?= $imgW ? 'width="' . (int) $imgW . '"' : '' ?>
                    <?= $imgH ? 'height="' . (int) $imgH . '"' : '' ?>
                    loading="<?= $i === 0 ? 'eager' : 'lazy' ?>">
                <?php endif; ?>

                <?php if ($row['linkURL']): ?>
                </a>
                <?php endif; ?>

                <?php if ($row['title'] || $row['description']): ?>
                <div class="sui-slider__caption">
                    <?php if ($row['title']): ?>
                        <h2 class="sui-slider__caption-title"><?= h($row['title']) ?></h2>
                    <?php endif; ?>
                    <?php if ($row['description']): ?>
                        <div class="sui-slider__caption-body"><?= $row['description'] ?></div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($showArrows && $total > 1): ?>
    <nav class="sui-slider__nav" aria-label="<?= t('Slider controls') ?>">
        <button class="sui-slider__nav-btn sui-slider__nav-btn--prev"
                @click="prev()"
                aria-label="<?= t('Previous slide') ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false" fill="currentColor">
                <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
            </svg>
        </button>
        <button class="sui-slider__nav-btn sui-slider__nav-btn--next"
                @click="next()"
                aria-label="<?= t('Next slide') ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false" fill="currentColor">
                <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
            </svg>
        </button>
    </nav>
    <?php endif; ?>

    <?php if ($showDots && $total > 1): ?>
    <div class="sui-slider__dots" role="tablist" aria-label="<?= t('Slide indicators') ?>">
        <?php foreach ($slides as $i => $row): ?>
            <button class="sui-slider__dot"
                    :class="{ 'sui-slider__dot--active': current === <?= $i ?> }"
                    @click="goto(<?= $i ?>)"
                    role="tab"
                    :aria-selected="current === <?= $i ?> ? 'true' : 'false'"
                    aria-label="<?= h(t('Go to slide %s', $i + 1)) ?>">
            </button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <div class="sui-slider__empty">
        <p><?= t('No Slides Entered.') ?></p>
    </div>
    <?php endif; ?>

</div>
