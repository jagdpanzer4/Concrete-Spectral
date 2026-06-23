<?php defined('C5_EXECUTE') or die('Access Denied.');
/**
 * @var int|null    $fID
 * @var string      $alt
 * @var string|null $title
 * @var string      $linkURL
 * @var bool        $openLinkInNewWindow
 * @var int|null    $maxWidth
 * @var int|null    $maxHeight
 */
if (empty($fID)) { return; }

$f = \File::getByID($fID);
if (!is_object($f) || $f->isError()) { return; }

$img = $f->getVersion();
$src = $img->getURL();
$naturalW = $img->getAttribute('width') ?: null;
$naturalH = $img->getAttribute('height') ?: null;

$style = '';
if ($maxWidth)  { $style .= "max-width:{$maxWidth}px;"; }
if ($maxHeight) { $style .= "max-height:{$maxHeight}px;"; }

$imgTag = '<img src="' . h($src) . '"'
    . ' alt="'   . h($alt ?? '') . '"'
    . ($naturalW ? ' width="'  . (int)$naturalW . '"' : '')
    . ($naturalH ? ' height="' . (int)$naturalH . '"' : '')
    . ($style    ? ' style="'  . h($style) . '"' : '')
    . ' class="sui-img" loading="lazy">';

if ($linkURL): ?>
<figure class="sui-figure">
    <a href="<?= h($linkURL) ?>"<?= $openLinkInNewWindow ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
        <?= $imgTag ?>
    </a>
    <?php if ($title): ?><figcaption class="sui-caption sui-body-sm"><?= h($title) ?></figcaption><?php endif; ?>
</figure>
<?php else: ?>
<figure class="sui-figure">
    <?= $imgTag ?>
    <?php if ($title): ?><figcaption class="sui-caption sui-body-sm"><?= h($title) ?></figcaption><?php endif; ?>
</figure>
<?php endif; ?>
