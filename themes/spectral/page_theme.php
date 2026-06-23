<?php
namespace Application\Theme\Spectral;

use Concrete\Core\Page\Theme\Theme;
use Concrete\Core\Page\Theme\CustomizableInterface;
use Concrete\Core\StyleCustomizer\Customizer\Type\SkinCustomizerType;
use Concrete\Core\StyleCustomizer\Customizer\Type\TypeInterface;

class PageTheme extends Theme implements CustomizableInterface
{
    protected $pThemeName        = 'Spectral';
    protected $pThemeDescription = 'Concrete CMS theme powered by Spectral UI design system.';
    protected $pThemeVersion     = '1.0.0';

    public function getThemeCustomizerType(): TypeInterface
    {
        /** @var SkinCustomizerType $type */
        $type = \Core::make(SkinCustomizerType::class);
        $type->setLanguage('scss');
        return $type;
    }

    public function registerAssets(): void
    {
        // Widmo CSS+JS bundles are loaded dynamically per page template
        // via the spectral_theme site attribute. theme.css is static.
    }

    public function getThemePageTypeClasses(): array
    {
        return [
            'full_width'   => t('Full Width'),
            'with_sidebar' => t('With Sidebar'),
            'landing'      => t('Landing Page'),
        ];
    }

    public function getThemeEditorClasses(): array
    {
        return [
            ['title' => t('Display Heading'),  'attributes' => ['class' => 'sui-heading-display']],
            ['title' => t('Section Heading'),  'attributes' => ['class' => 'sui-heading-section']],
            ['title' => t('Muted Text'),        'attributes' => ['class' => 'sui-text-muted']],
            ['title' => t('Brand Text'),        'attributes' => ['class' => 'sui-text-brand']],
            ['title' => t('Card'),              'attributes' => ['class' => 'sui-card']],
            ['title' => t('Glass Card'),        'attributes' => ['class' => 'sui-card sui-glass']],
            ['title' => t('Primary Button'),    'attributes' => ['class' => 'sui-btn sui-btn-primary']],
            ['title' => t('Secondary Button'),  'attributes' => ['class' => 'sui-btn sui-btn-secondary']],
            ['title' => t('Ghost Button'),      'attributes' => ['class' => 'sui-btn sui-btn-ghost']],
            ['title' => t('Badge'),             'attributes' => ['class' => 'sui-badge']],
            ['title' => t('Brand Badge'),       'attributes' => ['class' => 'sui-badge sui-badge-brand']],
        ];
    }
}
