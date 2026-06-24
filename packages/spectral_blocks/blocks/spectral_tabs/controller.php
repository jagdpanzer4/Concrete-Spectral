<?php
namespace Concrete\Package\SpectralBlocks\Block\SpectralTabs;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Database\Connection\Connection;

class Controller extends BlockController
{
    protected $btTable              = 'btSpectralTabs';
    protected $btExportTables       = ['btSpectralTabs', 'btSpectralTabsEntries'];
    protected $btInterfaceWidth     = 640;
    protected $btInterfaceHeight    = 520;
    protected $btCacheBlockRecord   = true;
    protected $btCacheBlockOutput   = false; // Alpine.js state — don't cache

    public function getBlockTypeDescription(): string { return t('Tabbed content sections with Spectral UI styling.'); }
    public function getBlockTypeName(): string         { return t('Spectral Tabs'); }

    public function view(): void
    {
        $this->set('entries',      $this->getEntries());
        $this->set('tabStyle',     $this->tabStyle     ?? 'line');
        $this->set('headingFormat',$this->headingFormat ?? 'h3');
        $this->set('activeTab',    (int) ($this->activeTab ?? 0));
    }

    public function getEntries(): array
    {
        $db = $this->app->make(Connection::class);
        return $db->fetchAllAssociative(
            'SELECT * FROM btSpectralTabsEntries WHERE bID = ? ORDER BY sortOrder ASC',
            [$this->bID]
        );
    }

    public function add(): void
    {
        $this->set('tabStyle',     'line');
        $this->set('headingFormat','h3');
        $this->set('activeTab',    0);
        $this->set('entries',      [
            ['id' => '', 'label' => t('Tab 1'), 'icon' => '', 'content' => '<p>' . t('Content for tab 1.') . '</p>'],
            ['id' => '', 'label' => t('Tab 2'), 'icon' => '', 'content' => '<p>' . t('Content for tab 2.') . '</p>'],
        ]);
    }

    public function edit(): void
    {
        $this->set('tabStyle',     $this->tabStyle     ?? 'line');
        $this->set('headingFormat',$this->headingFormat ?? 'h3');
        $this->set('activeTab',    (int) ($this->activeTab ?? 0));
        $this->set('entries',      $this->getEntries());
    }

    public function save($args): void
    {
        $db = $this->app->make(Connection::class);

        parent::save([
            'tabStyle'      => $args['tabStyle']      ?? 'line',
            'headingFormat' => $args['headingFormat']  ?? 'h3',
            'activeTab'     => (int) ($args['activeTab'] ?? 0),
        ]);

        $db->executeQuery('DELETE FROM btSpectralTabsEntries WHERE bID = ?', [$this->bID]);

        $entries = json_decode($args['entriesJson'] ?? '[]', true) ?: [];
        foreach ($entries as $i => $e) {
            $db->insert('btSpectralTabsEntries', [
                'bID'       => $this->bID,
                'sortOrder' => $i,
                'label'     => substr(strip_tags($e['label'] ?? ''), 0, 255),
                'icon'      => substr(strip_tags($e['icon']  ?? ''), 0, 100),
                'content'   => $e['content'] ?? '',
            ]);
        }
    }

    public function duplicate($newBID): void
    {
        parent::duplicate($newBID);
        $db = $this->app->make(Connection::class);
        $rows = $db->fetchAllAssociative(
            'SELECT sortOrder,label,icon,content FROM btSpectralTabsEntries WHERE bID=?',
            [$this->bID]
        );
        foreach ($rows as $r) {
            $r['bID'] = $newBID;
            $db->insert('btSpectralTabsEntries', $r);
        }
    }

    public function delete(): void
    {
        $db = $this->app->make(Connection::class);
        $db->executeQuery('DELETE FROM btSpectralTabsEntries WHERE bID=?', [$this->bID]);
        parent::delete();
    }
}
