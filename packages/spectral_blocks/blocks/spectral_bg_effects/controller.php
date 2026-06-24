<?php
namespace Concrete\Package\SpectralBlocks\Block\SpectralBgEffects;

use Concrete\Core\Block\BlockController;

class Controller extends BlockController
{
    protected $btTable           = 'btSpectralBgEffects';
    protected $btInterfaceWidth  = 580;
    protected $btInterfaceHeight = 480;
    protected $btCacheBlockOutput = false;

    public function getBlockTypeName(): string        { return t('Spectral Background Effects'); }
    public function getBlockTypeDescription(): string { return t('Section wrapper with animated background effects: gradient mesh, fireflies, noise, aurora, or grid pattern.'); }

    private const ALLOWED_EFFECTS   = ['gradient-mesh','fireflies','aurora','noise-texture','grid-pattern','radial-glow'];
    private const ALLOWED_INTENSITY = ['subtle','medium','intense'];
    private const ALLOWED_PADDING   = ['none','sm','md','lg','xl'];
    private const ALLOWED_TEXT      = ['light','dark','inherit'];

    public function view(): void
    {
        $this->set('effectType',    $this->effectType    ?? 'gradient-mesh');
        $this->set('colorA',        $this->colorA        ?? '');
        $this->set('colorB',        $this->colorB        ?? '');
        $this->set('colorC',        $this->colorC        ?? '');
        $this->set('intensity',     $this->intensity     ?? 'medium');
        $this->set('animated',  (bool)($this->animated  ?? 1));
        $this->set('particleCount', (int)($this->particleCount ?? 40));
        $this->set('minHeight',     $this->minHeight     ?? '400px');
        $this->set('padding',       $this->padding       ?? 'xl');
        $this->set('textColor',     $this->textColor     ?? 'light');
        $this->set('content',       $this->content       ?? '');
    }

    public function add(): void  { $this->edit(); }
    public function edit(): void { $this->view(); }

    public function save($args): void
    {
        $args['effectType']    = in_array($args['effectType'] ?? '', self::ALLOWED_EFFECTS)   ? $args['effectType']   : 'gradient-mesh';
        $args['intensity']     = in_array($args['intensity']  ?? '', self::ALLOWED_INTENSITY) ? $args['intensity']    : 'medium';
        $args['padding']       = in_array($args['padding']    ?? '', self::ALLOWED_PADDING)   ? $args['padding']      : 'xl';
        $args['textColor']     = in_array($args['textColor']  ?? '', self::ALLOWED_TEXT)      ? $args['textColor']    : 'light';
        $args['animated']      = (int)!empty($args['animated']);
        $args['particleCount'] = min(200, max(5, (int)($args['particleCount'] ?? 40)));
        $args['colorA']        = preg_replace('/[^a-zA-Z0-9#,.()\s%]/', '', $args['colorA'] ?? '');
        $args['colorB']        = preg_replace('/[^a-zA-Z0-9#,.()\s%]/', '', $args['colorB'] ?? '');
        $args['colorC']        = preg_replace('/[^a-zA-Z0-9#,.()\s%]/', '', $args['colorC'] ?? '');
        $args['minHeight']     = preg_replace('/[^a-zA-Z0-9%]/', '', $args['minHeight'] ?? '400px');
        // content is HTML — CCMS sanitizes via the rich text editor
        parent::save($args);
    }
}
