<?php
namespace Concrete\Package\SpectralBlocks\Block\SpectralFeatureStrip;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Database\Connection\Connection;

class Controller extends BlockController
{
    protected $btTable           = 'btSpectralFeatureStrip';
    protected $btExportTables    = ['btSpectralFeatureStrip', 'btSpectralFeatureStripItems'];
    protected $btInterfaceWidth  = 600;
    protected $btInterfaceHeight = 500;

    public function getBlockTypeName(): string        { return t('Spectral Feature Strip'); }
    public function getBlockTypeDescription(): string { return t('Horizontal row of icon + title + subtitle feature highlights.'); }

    private function getItems(): array
    {
        return $this->app->make(Connection::class)->fetchAllAssociative(
            'SELECT * FROM btSpectralFeatureStripItems WHERE bID=? ORDER BY sortOrder ASC',
            [$this->bID]
        );
    }

    public function view(): void
    {
        $this->set('items', $this->getItems());
        $this->set('align', $this->align ?? 'center');
    }

    public function add(): void
    {
        $this->set('align', 'center');
        $this->set('items', [
            ['icon' => '⚡', 'title' => t('Fast'), 'subtitle' => t('Built for speed'), 'linkURL' => ''],
            ['icon' => '🎨', 'title' => t('Beautiful'), 'subtitle' => t('Spectral design system'), 'linkURL' => ''],
            ['icon' => '🔒', 'title' => t('Secure'), 'subtitle' => t('Enterprise-grade'), 'linkURL' => ''],
        ]);
    }

    public function edit(): void
    {
        $this->set('align', $this->align ?? 'center');
        $this->set('items', $this->getItems());
    }

    public function save($args): void
    {
        $db = $this->app->make(Connection::class);
        parent::save(['align' => in_array($args['align'] ?? '', ['left','center','right']) ? $args['align'] : 'center']);
        $db->executeQuery('DELETE FROM btSpectralFeatureStripItems WHERE bID=?', [$this->bID]);
        foreach (json_decode($args['itemsJson'] ?? '[]', true) ?: [] as $i => $item) {
            $db->insert('btSpectralFeatureStripItems', [
                'bID' => $this->bID, 'sortOrder' => $i,
                'icon'     => substr($item['icon']     ?? '', 0, 100),
                'title'    => substr($item['title']    ?? '', 0, 255),
                'subtitle' => substr($item['subtitle'] ?? '', 0, 500),
                'linkURL'  => substr($item['linkURL']  ?? '', 0, 512),
            ]);
        }
    }

    public function duplicate($newBID): void
    {
        parent::duplicate($newBID);
        $db = $this->app->make(Connection::class);
        foreach ($db->fetchAllAssociative('SELECT sortOrder,icon,title,subtitle,linkURL FROM btSpectralFeatureStripItems WHERE bID=?', [$this->bID]) as $r) {
            $r['bID'] = $newBID; $db->insert('btSpectralFeatureStripItems', $r);
        }
    }

    public function delete(): void
    {
        $this->app->make(Connection::class)->executeQuery('DELETE FROM btSpectralFeatureStripItems WHERE bID=?', [$this->bID]);
        parent::delete();
    }
}
