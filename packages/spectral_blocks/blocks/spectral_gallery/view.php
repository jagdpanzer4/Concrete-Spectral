<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<?php if (empty($images)): ?>
<?php if (isset($c) && $c->isEditMode()): ?>
<div class="ccm-edit-mode-disabled-item"><?= t('Gallery: no images added yet.') ?></div>
<?php endif; ?>
<?php return; endif; ?>

<?php
$uid       = 'gallery-' . $bID;
$isMasonry = ($layout === 'masonry');
$minPx     = max(120, (int) round(600 / $columns)) . 'px';
?>

<div
    class="sui-gallery<?= $isMasonry ? ' sui-gallery--masonry' : '' ?>"
    <?php if (!$isMasonry): ?>
    style="grid-template-columns:repeat(auto-fill,minmax(<?= h($minPx) ?>,1fr));"
    <?php endif; ?>
    x-data="spectralGallery<?= $uid ?>()"
    role="list"
    aria-label="<?= t('Image gallery') ?>"
>
    <?php foreach ($images as $i => $img): ?>
    <figure
        class="sui-gallery__item"
        role="listitem"
        <?php if ($lightbox): ?>@click="open(<?= $i ?>)" style="cursor:zoom-in;"<?php endif; ?>
    >
        <img
            src="<?= h($img['thumb'] ?: $img['url']) ?>"
            alt="<?= h($img['altText'] ?: $img['title']) ?>"
            loading="lazy"
            class="sui-gallery__img"
            style="width:100%;height:100%;object-fit:cover;display:block;"
        >
        <?php if ($showCap && !empty($img['caption'])): ?>
        <figcaption class="sui-gallery__caption"><?= h($img['caption']) ?></figcaption>
        <?php endif; ?>
    </figure>
    <?php endforeach; ?>
</div>

<?php if ($lightbox): ?>
<div
    class="sui-lightbox"
    x-data="spectralGallery<?= $uid ?>()"
    x-show="isOpen"
    x-cloak
    @keydown.escape.window="close()"
    role="dialog"
    aria-modal="true"
    aria-label="<?= t('Image lightbox') ?>"
>
    <button class="sui-lightbox__close" @click="close()" aria-label="<?= t('Close') ?>">✕</button>

    <button class="sui-lightbox__prev" @click="prev()" aria-label="<?= t('Previous') ?>">&#8249;</button>

    <div class="sui-lightbox__content" @click.self="close()">
        <template x-for="(img, i) in images" :key="i">
        <figure x-show="current === i" class="sui-lightbox__figure">
            <img :src="img.url" :alt="img.alt" class="sui-lightbox__img" style="max-width:90vw;max-height:80vh;object-fit:contain;border-radius:var(--radius-lg);">
            <figcaption x-show="img.caption" x-text="img.caption" class="sui-lightbox__caption" style="text-align:center;color:#fff;margin-top:var(--space-3);"></figcaption>
        </figure>
        </template>
    </div>

    <button class="sui-lightbox__next" @click="next()" aria-label="<?= t('Next') ?>">&#8250;</button>
</div>
<?php endif; ?>

<script>
(function() {
    var _data = {
        images: <?= json_encode(array_map(function($img) {
            return ['url' => $img['url'], 'alt' => $img['altText'] ?: $img['title'], 'caption' => $img['caption'] ?? ''];
        }, $images)) ?>,
        isOpen:  false,
        current: 0,
        open(i)  { this.current = i; this.isOpen = true; document.body.style.overflow = 'hidden'; },
        close()  { this.isOpen = false; document.body.style.overflow = ''; },
        prev()   { this.current = (this.current - 1 + this.images.length) % this.images.length; },
        next()   { this.current = (this.current + 1) % this.images.length; },
    };
    window['spectralGallery<?= $uid ?>'] = function() { return Object.assign({}, _data); };
})();
</script>
