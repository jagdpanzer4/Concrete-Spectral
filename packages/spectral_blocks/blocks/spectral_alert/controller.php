<?php
namespace Concrete\Package\SpectralBlocks\Block\SpectralAlert;

use Concrete\Core\Block\BlockController;

class Controller extends BlockController
{
    protected $btTable           = 'btSpectralAlert';
    protected $btInterfaceWidth  = 560;
    protected $btInterfaceHeight = 420;
    protected $btCacheBlockOutput = false; // dismissible state

    public function getBlockTypeName(): string        { return t('Spectral Alert'); }
    public function getBlockTypeDescription(): string { return t('Styled alert banner: info, success, warning or error with optional dismiss button.'); }

    private static array $TYPES = ['info', 'success', 'warning', 'error'];
    private static array $ICONS = ['info' => 'ℹ️', 'success' => '✅', 'warning' => '⚠️', 'error' => '🚫'];

    public function view(): void
    {
        $type = in_array($this->alertType ?? '', self::$TYPES) ? $this->alertType : 'info';
        $this->set('alertType',   $type);
        $this->set('alertTitle',  $this->alertTitle  ?? '');
        $this->set('alertBody',   $this->alertBody   ?? '');
        $this->set('dismissible', (bool) ($this->dismissible ?? false));
        $this->set('icon',        $this->icon ?: (self::$ICONS[$type] ?? ''));
    }

    public function add(): void
    {
        $this->set('alertType',   'info');
        $this->set('alertTitle',  '');
        $this->set('alertBody',   '');
        $this->set('dismissible', false);
        $this->set('icon',        self::$ICONS['info']);
    }

    public function edit(): void { $this->view(); }

    public function save($args): void
    {
        $type = in_array($args['alertType'] ?? '', self::$TYPES) ? $args['alertType'] : 'info';
        parent::save([
            'alertType'   => $type,
            'alertTitle'  => substr(strip_tags($args['alertTitle'] ?? ''), 0, 255),
            'alertBody'   => $args['alertBody'] ?? '',
            'dismissible' => isset($args['dismissible']) ? 1 : 0,
            'icon'        => substr(strip_tags($args['icon'] ?? ''), 0, 100),
        ]);
    }
}
