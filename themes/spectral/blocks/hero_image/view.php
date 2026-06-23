<?php

defined('C5_EXECUTE') or die('Access Denied.');

/**
 * @var Concrete\Core\Entity\File\File|null $image  File object set by controller view()
 * @var string|null                         $title
 * @var string|null                         $body
 * @var string|null                         $height  Viewport-height value (e.g. "60" → 60vh)
 * @var string|null                         $titleFormat  Heading tag, e.g. "h1"
 * @var HtmlObject\Link|null                $button
 * @var string|null                         $buttonIcon
 * @var string|null                         $buttonStyle
 * @var string|null                         $buttonColor
 * @var string|null                         $buttonSize
 * @var string                              $iconTag
 */

$heightVh    = (int) $height ?: 60;
$heightStyle = "min-height:{$heightVh}vh;";

if (isset($button)) {
    $buttonColor = $buttonColor ?? null;
    if ($buttonStyle === 'outline') {
        $button->addClass('btn btn-outline-' . $buttonColor);
    } elseif ($buttonStyle === 'link') {
        $button->addClass('btn btn-link');
    } else {
        $button->addClass('btn btn-' . $buttonColor);
    }
    if ($buttonSize) {
        $button->addClass('btn-' . $buttonSize);
    }
    if ($buttonIcon && $button->getValue()) {
        $iconTag = '<span class="me-3">' . $iconTag . '</span>';
    }
    $button->setValue($iconTag . $button->getValue());
}

$titleFormat = $titleFormat ?? 'h1';
?>
<section
    class="sui-hero"
    style="<?= $heightStyle ?>display:flex;align-items:center;position:relative;overflow:hidden;"
    aria-label="<?= t('Hero section') ?>"
>
    <?php if ($image && !$image->isError()): ?>
    <img
        src="<?= h($image->getURL()) ?>"
        alt=""
        aria-hidden="true"
        style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0;"
    >
    <?php endif; ?>
    <div class="sui-hero__overlay" style="position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,0,0,.35),rgba(0,0,0,.6));pointer-events:none;z-index:1;" aria-hidden="true"></div>
    <div class="sui-container sui-hero__content" style="position:relative;z-index:2;color:#fff;max-width:800px;margin:0 auto;padding:var(--space-12,48px) var(--space-4,16px);text-align:center;">
        <?php if ($title): ?>
            <<?= h($titleFormat) ?>><?= h($title) ?></<?= h($titleFormat) ?>>
        <?php endif; ?>
        <?php if ((string) $body !== ''): ?>
            <?= $body ?>
        <?php endif; ?>
        <?php if (isset($button)): ?>
            <div class="mt-4"><?= $button ?></div>
        <?php endif; ?>
    </div>
</section>
