<?php defined('C5_EXECUTE') or die('Access Denied.');
/**
 * @var array       $rows          Slide entries: fID, title, description, linkURL, internalLinkCID, sortOrder
 * @var int|null    $navigationType 0=arrows, 1=dots, 2=both, else=none
 * @var int|null    $timeout       Auto-advance interval in ms (default 4000)
 * @var int|null    $speed         Transition speed in ms (default 500)
 * @var int|null    $noAnimate     1 = disable auto-advance
 * @var int|null    $pause         1 = pause on hover
 * @var int|null    $maxWidth      Max width in px
 */

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

<div class="sui-slider"
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

    <div class="sui-slider__track" aria-live="polite" aria-atomic="false">
        <?php foreach ($slides as $i => $row): ?>
            <?php
            $f      = \File::getByID($row['fID']);
            $imgSrc = '';
            $imgW   = null;
            $imgH   = null;
            $imgAlt = h($row['title'] ?: t('Slide %s', $i + 1));

            if (is_object($f) && !$f->isError()) {
                $fv     = $f->getVersion();
                $imgSrc = $fv->getURL();
                $imgW   = $fv->getAttribute('width') ?: null;
                $imgH   = $fv->getAttribute('height') ?: null;
            }
            ?>
            <div class="sui-slider__slide"
                 x-show="current === <?= $i ?>"
                 x-transition.opacity.duration.<?= (int) ($speed ?? 500) ?>ms
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
