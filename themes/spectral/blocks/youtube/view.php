<?php defined('C5_EXECUTE') or die('Access Denied.');
/**
 * Spectral youtube block template.
 *
 * @var string      $youtubeDomain  'www.youtube.com' or 'www.youtube-nocookie.com'
 * @var string      $videoID
 * @var string|null $playListID
 * @var string|null $playlist
 * @var int|null    $bID
 * @var string|null $sizing          '16:9'|'4:3'|'fixed'
 * @var int|null    $vWidth
 * @var int|null    $vHeight
 * @var bool|null   $autoplay
 * @var bool|null   $lazyLoad
 * @var int|null    $startSeconds
 */

use Concrete\Core\Url\Url;
use Concrete\Core\Localization\Localization;
use Concrete\Core\Page\Page;

$c    = Page::getCurrentPage();
$bID  = $bID ?? 0;

// --- Build query params (same logic as core view.php) ---
$params = [];
if (isset($playlist))                      { $params['playlist']   = $playlist; $videoID = ''; }
if (!empty($playListID))                   { $params['listType'] = 'playlist'; $params['list'] = $playListID; }
if (!empty($autoplay))                     { $params['autoplay']   = '1'; }
if (!empty($color))                        { $params['color']      = $color; }
if (isset($controls) && $controls !== '')  { $params['controls']   = $controls; }
$params['hl'] = Localization::activeLanguage();
if (!empty($iv_load_policy))               { $params['iv_load_policy'] = $iv_load_policy; }
if (!empty($loopEnd))                      { $params['loop'] = '1'; if (empty($playlist) && $videoID) { $params['playlist'] = $videoID; } }
if (!empty($modestbranding))               { $params['modestbranding'] = '1'; }
$params['rel'] = (!empty($rel)) ? '1' : '0';
if (!empty($showCaptions))                 { $params['cc_load_policy'] = '1'; $params['cc_lang_pref'] = Localization::activeLanguage(); }
if (!empty($startSeconds))                 { $params['start'] = $startSeconds; }

$source = Url::createFromUrl('https://' . $youtubeDomain);
$source->getQuery()->set($params);
$source->getPath()->set(['embed', $videoID]);
$srcAttr = h((string)$source);

// --- Sizing ---
$lazy = (!empty($lazyLoad)) ? 'loading="lazy"' : '';
if (!empty($vWidth) && !empty($vHeight)) {
    $wrapStyle  = 'style="width:' . (int)$vWidth . 'px;max-width:100%"';
    $frameAttrs = 'width="' . (int)$vWidth . '" height="' . (int)$vHeight . '"';
    $aspectClass = '';
} else {
    $aspect     = ($sizing === '4:3') ? 'sui-embed--4x3' : 'sui-embed--16x9';
    $wrapStyle  = '';
    $frameAttrs = '';
    $aspectClass = $aspect;
}

if (is_object($c) && $c->isEditMode()): ?>
    <div class="sui-media-placeholder ccm-edit-mode-disabled-item" <?= $wrapStyle ?>>
        <span>&#9654; <?= t('YouTube — disabled in edit mode') ?></span>
    </div>
<?php else: ?>
    <div class="sui-embed <?= $aspectClass ?>" id="youtube<?= $bID ?>" <?= $wrapStyle ?>>
        <iframe class="sui-embed__frame"
                src="<?= $srcAttr ?>"
                <?= $frameAttrs ?>
                <?= !empty($title) ? 'title="' . h($title) . '"' : '' ?>
                referrerpolicy="strict-origin-when-cross-origin"
                allow="autoplay; encrypted-media"
                allowfullscreen
                <?= $lazy ?>></iframe>
    </div>
<?php endif; ?>
