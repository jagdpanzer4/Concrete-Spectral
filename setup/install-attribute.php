<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Attribute\Category\CategoryService;
use Concrete\Core\Attribute\Type as AttributeType;

$service  = app(CategoryService::class);
$category = $service->getByHandle('site');

if ($category->getAttributeKeyByHandle('spectral_theme')) {
    echo "Attribute 'spectral_theme' already exists — skipping.\n";
    return;
}

$type = AttributeType::getByHandle('text');
if (!$type) {
    echo "ERROR: 'text' attribute type not found in this CMS installation.\n";
    return;
}

$category->add($type, [
    'akHandle'       => 'spectral_theme',
    'akName'         => 'Spectral Theme (Widmo)',
    'akIsSearchable' => false,
]);

echo "✓ Site attribute 'spectral_theme' created (type: text).\n";
echo "  Dashboard → System & Settings → Sites → Attributes\n";
echo "  Set 'Spectral Theme (Widmo)' to one of:\n";

$cssDir = DIR_APPLICATION . '/themes/spectral/css';
if (is_dir($cssDir)) {
    foreach (scandir($cssDir) as $entry) {
        if ($entry[0] !== '.' && is_dir("$cssDir/$entry")) {
            echo "    - $entry\n";
        }
    }
} else {
    echo "    - spectral-chromatic (default)\n";
    echo "    - spectral-light\n";
    echo "  (Deploy theme first, then re-run for live widmo list)\n";
}

echo "  Leave empty to use default: spectral-chromatic\n";
