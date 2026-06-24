<?php
namespace Concrete\Package\SpectralBlocks\Block\SpectralOrbital;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Database\Connection\Connection;

class Controller extends BlockController
{
    protected $btTable              = 'btSpectralOrbital';
    protected $btExportTables       = ['btSpectralOrbital', 'btSpectralOrbitalItems'];
    protected $btInterfaceWidth     = 620;
    protected $btInterfaceHeight    = 540;
    protected $btCacheBlockOutput   = false;

    public function getBlockTypeName(): string        { return t('Spectral Orbital'); }
    public function getBlockTypeDescription(): string { return t('3D rotating orbital showcase with center focus and orbiting items.'); }

    // ── Load ──────────────────────────────────────────────────
    public function view(): void
    {
        /** @var Connection $db */
        $db = $this->app->make('database/connection');
        $items = $db->fetchAllAssociative(
            'SELECT * FROM btSpectralOrbitalItems WHERE bID=? ORDER BY sortOrder ASC',
            [$this->bID]
        );
        $this->set('centerIcon',     $this->centerIcon     ?? '');
        $this->set('centerLabel',    $this->centerLabel    ?? '');
        $this->set('centerSublabel', $this->centerSublabel ?? '');
        $this->set('ringSize',       $this->ringSize       ?? 'md');
        $this->set('animSpeed',      $this->animSpeed      ?? 'normal');
        $this->set('showRing',       (bool)($this->showRing ?? 1));
        $this->set('variant',        $this->variant        ?? 'glow');
        $this->set('items',          $items);
    }

    public function add(): void  { $this->edit(); }
    public function edit(): void
    {
        /** @var Connection $db */
        $db = $this->app->make('database/connection');
        $items = $this->bID
            ? $db->fetchAllAssociative('SELECT * FROM btSpectralOrbitalItems WHERE bID=? ORDER BY sortOrder ASC', [$this->bID])
            : [];
        $this->set('centerIcon',     $this->centerIcon     ?? '');
        $this->set('centerLabel',    $this->centerLabel    ?? '');
        $this->set('centerSublabel', $this->centerSublabel ?? '');
        $this->set('ringSize',       $this->ringSize       ?? 'md');
        $this->set('animSpeed',      $this->animSpeed      ?? 'normal');
        $this->set('showRing',   (int)($this->showRing     ?? 1));
        $this->set('variant',        $this->variant        ?? 'glow');
        $this->set('itemsJson',      json_encode($items));
    }

    // ── Save ──────────────────────────────────────────────────
    public function save($args): void
    {
        $args['centerIcon']     = strip_tags($args['centerIcon']     ?? '');
        $args['centerLabel']    = strip_tags($args['centerLabel']    ?? '');
        $args['centerSublabel'] = strip_tags($args['centerSublabel'] ?? '');
        $args['ringSize']       = in_array($args['ringSize'] ?? '', ['sm','md','lg']) ? $args['ringSize'] : 'md';
        $args['animSpeed']      = in_array($args['animSpeed'] ?? '', ['slow','normal','fast','pause']) ? $args['animSpeed'] : 'normal';
        $args['showRing']       = (int)!empty($args['showRing']);
        $args['variant']        = in_array($args['variant'] ?? '', ['glow','flat','glass']) ? $args['variant'] : 'glow';
        parent::save($args);

        /** @var Connection $db */
        $db = $this->app->make('database/connection');
        $db->executeQuery('DELETE FROM btSpectralOrbitalItems WHERE bID=?', [$this->bID]);

        $rawItems = json_decode($args['itemsJson'] ?? '[]', true) ?: [];
        foreach ($rawItems as $i => $item) {
            $db->insert('btSpectralOrbitalItems', [
                'bID'       => $this->bID,
                'sortOrder' => $i,
                'icon'      => strip_tags($item['icon']     ?? ''),
                'label'     => strip_tags($item['label']    ?? ''),
                'sublabel'  => strip_tags($item['sublabel'] ?? ''),
                'color'     => preg_replace('/[^a-zA-Z0-9#]/', '', $item['color'] ?? ''),
            ]);
        }
    }

    // ── Duplicate / Delete ────────────────────────────────────
    public function duplicate($newBID): void
    {
        parent::duplicate($newBID);
        /** @var Connection $db */
        $db    = $this->app->make('database/connection');
        $items = $db->fetchAllAssociative('SELECT * FROM btSpectralOrbitalItems WHERE bID=?', [$this->bID]);
        foreach ($items as $item) {
            unset($item['id']);
            $item['bID'] = $newBID;
            $db->insert('btSpectralOrbitalItems', $item);
        }
    }

    public function delete(): void
    {
        /** @var Connection $db */
        $db = $this->app->make('database/connection');
        $db->executeQuery('DELETE FROM btSpectralOrbitalItems WHERE bID=?', [$this->bID]);
        parent::delete();
    }
}
