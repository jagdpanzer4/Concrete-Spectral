<?php defined('C5_EXECUTE') or die('Access Denied.');
/**
 * Spectral file block template.
 *
 * @var Concrete\Block\File\Controller $controller
 * @var bool $forceDownload
 */

use Concrete\Core\Page\Page;
use Concrete\Core\Permission\Checker as Permissions;

$c  = Page::getCurrentPage();
$f  = $controller->getFileObject();
$fp = $f ? new Permissions($f) : null;

if ($f && $fp && $fp->canViewFile()):
    $href = !empty($forceDownload) ? $f->getForceDownloadURL() : $f->getDownloadURL();
    $fv   = $f->getApprovedVersion();
    $ext  = $fv ? strtolower(pathinfo($fv->getFilename(), PATHINFO_EXTENSION)) : '';
    $size = $fv ? $fv->getSize() : '';

    // Pick icon by extension group
    $icon = '📄';
    if (in_array($ext, ['pdf']))                         $icon = '📕';
    elseif (in_array($ext, ['zip','gz','rar','7z']))     $icon = '📦';
    elseif (in_array($ext, ['jpg','jpeg','png','gif','webp','svg'])) $icon = '🖼️';
    elseif (in_array($ext, ['mp4','webm','mov','avi']))  $icon = '🎬';
    elseif (in_array($ext, ['mp3','wav','ogg','flac']))  $icon = '🎵';
    elseif (in_array($ext, ['doc','docx','odt']))        $icon = '📝';
    elseif (in_array($ext, ['xls','xlsx','csv']))        $icon = '📊';
    elseif (in_array($ext, ['ppt','pptx']))              $icon = '📊';
?>
<div class="sui-file-block">
    <a class="sui-file-block__link" href="<?= h($href) ?>"
       <?= !empty($forceDownload) ? 'download' : '' ?>>
        <span class="sui-file-block__icon" aria-hidden="true"><?= $icon ?></span>
        <span class="sui-file-block__name"><?= h(stripslashes($controller->getLinkText())) ?></span>
        <?php if ($size): ?>
        <span class="sui-file-block__size"><?= h($size) ?></span>
        <?php endif; ?>
    </a>
</div>
<?php elseif ($c && $c->isEditMode()): ?>
<div class="sui-media-placeholder ccm-edit-mode-disabled-item">
    <span><?= t('Empty File Block') ?></span>
</div>
<?php endif; ?>
