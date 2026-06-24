<?php
namespace Concrete\Package\SpectralBlocks;

use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Package\Package;

class Controller extends Package
{
    protected $pkgHandle          = 'spectral_blocks';
    protected $appVersionRequired = '9.0.0';
    protected $pkgVersion         = '1.0.0';
    protected $pkgAutoloaderRegistries = [];

    public function getPackageName(): string
    {
        return t('Spectral UI Blocks');
    }

    public function getPackageDescription(): string
    {
        return t('Custom blocks from the Spectral UI design system: Tabs, Gallery, Feature Strip, Alert and Social Links.');
    }

    private const BLOCKS = [
        'spectral_tabs',
        'spectral_gallery',
        'spectral_feature_strip',
        'spectral_alert',
        'spectral_social_links',
    ];

    public function install()
    {
        $pkg = parent::install();
        foreach (self::BLOCKS as $handle) {
            BlockType::installBlockTypeFromPackage($handle, $pkg);
        }
        $this->fixAutoIncrements();
        return $pkg;
    }

    /** ADODB XML v0.3 doesn't reliably set AUTO_INCREMENT — fix after install */
    private function fixAutoIncrements(): void
    {
        $db = $this->app->make('database/connection');
        $tables = [
            'btSpectralTabsEntries'         => 'id',
            'btSpectralGalleryImages'        => 'id',
            'btSpectralFeatureStripItems'    => 'id',
            'btSpectralSocialLinksItems'     => 'id',
        ];
        foreach ($tables as $table => $col) {
            try {
                $db->executeQuery("ALTER TABLE `$table` MODIFY `$col` INT UNSIGNED NOT NULL AUTO_INCREMENT");
            } catch (\Exception $e) {
                // ignore if already correct
            }
        }
    }

    public function upgrade()
    {
        parent::upgrade();
        foreach (self::BLOCKS as $handle) {
            $bt = BlockType::getByHandle($handle);
            if (!$bt) {
                BlockType::installBlockTypeFromPackage($handle, $this);
            }
        }
    }

    public function uninstall()
    {
        parent::uninstall();
    }
}
