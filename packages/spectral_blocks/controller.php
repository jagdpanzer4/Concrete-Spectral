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
        return $pkg;
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
