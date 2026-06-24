<?php
namespace Concrete\Package\SpectralBlocks\Block\SpectralSocialLinks;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Database\Connection\Connection;

class Controller extends BlockController
{
    protected $btTable           = 'btSpectralSocialLinks';
    protected $btExportTables    = ['btSpectralSocialLinks', 'btSpectralSocialLinksItems'];
    protected $btInterfaceWidth  = 560;
    protected $btInterfaceHeight = 460;

    public function getBlockTypeName(): string        { return t('Spectral Social Links'); }
    public function getBlockTypeDescription(): string { return t('Row of social media icon links with SVG icons.'); }

    public static function getPlatforms(): array
    {
        return ['github','twitter','linkedin','instagram','youtube','facebook','tiktok','discord','mastodon','bluesky'];
    }

    private function getItems(): array
    {
        return $this->app->make(Connection::class)->fetchAllAssociative(
            'SELECT * FROM btSpectralSocialLinksItems WHERE bID=? ORDER BY sortOrder ASC',
            [$this->bID]
        );
    }

    public function view(): void
    {
        $this->set('links',  $this->getItems());
        $this->set('style',  $this->style ?? 'icon');
        $this->set('size',   $this->size  ?? 'md');
    }

    public function add(): void
    {
        $this->set('style', 'icon');
        $this->set('size',  'md');
        $this->set('links', []);
    }

    public function edit(): void
    {
        $this->set('style', $this->style ?? 'icon');
        $this->set('size',  $this->size  ?? 'md');
        $this->set('links', $this->getItems());
    }

    public function save($args): void
    {
        $db = $this->app->make(Connection::class);
        parent::save([
            'style' => in_array($args['style'] ?? '', ['icon','icon-label']) ? $args['style'] : 'icon',
            'size'  => in_array($args['size']  ?? '', ['sm','md','lg'])      ? $args['size']  : 'md',
        ]);
        $db->executeQuery('DELETE FROM btSpectralSocialLinksItems WHERE bID=?', [$this->bID]);
        foreach (json_decode($args['linksJson'] ?? '[]', true) ?: [] as $i => $item) {
            $db->insert('btSpectralSocialLinksItems', [
                'bID'       => $this->bID,
                'sortOrder' => $i,
                'platform'  => substr($item['platform'] ?? '', 0, 50),
                'url'       => substr($item['url']      ?? '', 0, 512),
                'label'     => substr($item['label']    ?? '', 0, 100),
            ]);
        }
    }

    public function duplicate($newBID): void
    {
        parent::duplicate($newBID);
        $db = $this->app->make(Connection::class);
        foreach ($db->fetchAllAssociative('SELECT sortOrder,platform,url,label FROM btSpectralSocialLinksItems WHERE bID=?', [$this->bID]) as $r) {
            $r['bID'] = $newBID; $db->insert('btSpectralSocialLinksItems', $r);
        }
    }

    public function delete(): void
    {
        $this->app->make(Connection::class)->executeQuery('DELETE FROM btSpectralSocialLinksItems WHERE bID=?', [$this->bID]);
        parent::delete();
    }
}
