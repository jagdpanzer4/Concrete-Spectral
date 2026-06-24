<?php
namespace Concrete\Package\SpectralBlocks\Block\SpectralGallery;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Database\Connection\Connection;
use Concrete\Core\File\File;

class Controller extends BlockController
{
    protected $btTable           = 'btSpectralGallery';
    protected $btExportTables    = ['btSpectralGallery', 'btSpectralGalleryImages'];
    protected $btInterfaceWidth  = 680;
    protected $btInterfaceHeight = 580;
    protected $btCacheBlockOutput = false;

    public function getBlockTypeName(): string        { return t('Spectral Gallery'); }
    public function getBlockTypeDescription(): string { return t('Image grid with optional lightbox, captions and masonry layout.'); }

    public function view(): void
    {
        $images = $this->getImages();
        $this->set('images',   $images);
        $this->set('layout',   $this->layout   ?? 'grid');
        $this->set('columns',  (int) ($this->columns ?? 3));
        $this->set('lightbox', (bool) ($this->lightbox ?? true));
        $this->set('showCap',  (bool) ($this->caption ?? true));
    }

    public function getImages(): array
    {
        $db   = $this->app->make(Connection::class);
        $rows = $db->fetchAllAssociative(
            'SELECT * FROM btSpectralGalleryImages WHERE bID=? ORDER BY sortOrder ASC',
            [$this->bID]
        );
        $result = [];
        foreach ($rows as $row) {
            $f = File::getByID((int) $row['fID']);
            if ($f && !$f->isError()) {
                $fv = $f->getApprovedVersion();
                $row['url']   = $fv ? $fv->getURL() : '';
                $row['thumb'] = $fv ? $fv->getThumbnailURL('file_manager_listing') : '';
                $row['title'] = $fv ? $fv->getTitle() : '';
                $result[] = $row;
            }
        }
        return $result;
    }

    public function add(): void
    {
        $this->set('layout',  'grid');
        $this->set('columns', 3);
        $this->set('lightbox', 1);
        $this->set('caption',  1);
        $this->set('images', []);
    }

    public function edit(): void
    {
        $this->set('layout',  $this->layout  ?? 'grid');
        $this->set('columns', (int) ($this->columns ?? 3));
        $this->set('lightbox', (int) ($this->lightbox ?? 1));
        $this->set('caption',  (int) ($this->caption  ?? 1));
        $this->set('images',  $this->getImages());
    }

    public function save($args): void
    {
        $db = $this->app->make(Connection::class);

        parent::save([
            'layout'  => in_array($args['layout'] ?? '', ['grid','masonry']) ? $args['layout'] : 'grid',
            'columns' => max(1, min(6, (int) ($args['columns'] ?? 3))),
            'lightbox'=> isset($args['lightbox']) ? 1 : 0,
            'caption' => isset($args['caption'])  ? 1 : 0,
        ]);

        $db->executeQuery('DELETE FROM btSpectralGalleryImages WHERE bID=?', [$this->bID]);

        $items = json_decode($args['imagesJson'] ?? '[]', true) ?: [];
        foreach ($items as $i => $item) {
            $fID = (int) ($item['fID'] ?? 0);
            if ($fID < 1) continue;
            $db->insert('btSpectralGalleryImages', [
                'bID'       => $this->bID,
                'sortOrder' => $i,
                'fID'       => $fID,
                'caption'   => substr($item['caption'] ?? '', 0, 500),
                'altText'   => substr($item['altText'] ?? '', 0, 500),
            ]);
        }
    }

    public function duplicate($newBID): void
    {
        parent::duplicate($newBID);
        $db = $this->app->make(Connection::class);
        $rows = $db->fetchAllAssociative(
            'SELECT sortOrder,fID,caption,altText FROM btSpectralGalleryImages WHERE bID=?',
            [$this->bID]
        );
        foreach ($rows as $r) {
            $r['bID'] = $newBID;
            $db->insert('btSpectralGalleryImages', $r);
        }
    }

    public function delete(): void
    {
        $db = $this->app->make(Connection::class);
        $db->executeQuery('DELETE FROM btSpectralGalleryImages WHERE bID=?', [$this->bID]);
        parent::delete();
    }
}
