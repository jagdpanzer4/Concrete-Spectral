<?php
defined('C5_EXECUTE') or die('Access Denied.');

/**
 * Spectral template for the native page_list block.
 *
 * Variables injected by the controller:
 * @var \Concrete\Core\Page\Page[]           $pages
 * @var bool                                 $displayThumbnail
 * @var bool|int                             $includeName
 * @var bool|int                             $includeDescription
 * @var bool|int                             $includeDate
 * @var bool|int                             $useButtonForLink
 * @var string                               $buttonLinkText
 * @var string|null                          $pageListTitle
 * @var string                               $titleFormat   e.g. "h2"
 * @var string|null                          $rssUrl
 * @var bool                                 $showPagination
 * @var string                               $pagination    HTML from CMS paginator
 * @var string                               $noResultsMessage
 * @var \Concrete\Core\Utility\Service\Text  $th
 * @var \Concrete\Core\Localization\Service\Date $dh
 */

$c = \Page::getCurrentPage();

if (is_object($c) && $c->isEditMode() && $controller->isBlockEmpty()) {
    echo '<div class="ccm-edit-mode-disabled-item">' . t('Empty Page List Block.') . '</div>';
    return;
}
?>
<section class="sui-page-list" aria-label="<?= isset($pageListTitle) && $pageListTitle ? h($pageListTitle) : t('Page list') ?>">

    <?php if (isset($pageListTitle) && $pageListTitle): ?>
    <header class="sui-page-list__header" style="margin-bottom:var(--space-6,24px);">
        <<?= $titleFormat ?> class="sui-heading"><?= h($pageListTitle) ?></<?= $titleFormat ?>>
        <?php if (isset($rssUrl) && $rssUrl): ?>
        <a href="<?= h($rssUrl) ?>" target="_blank" rel="noopener" class="sui-page-list__rss" aria-label="<?= t('RSS feed') ?>" style="margin-left:var(--space-3,12px);color:var(--color-primary);">
            <i class="fas fa-rss" aria-hidden="true"></i>
        </a>
        <?php endif; ?>
    </header>
    <?php elseif (isset($rssUrl) && $rssUrl): ?>
    <a href="<?= h($rssUrl) ?>" target="_blank" rel="noopener" class="sui-page-list__rss" aria-label="<?= t('RSS feed') ?>" style="display:block;margin-bottom:var(--space-4,16px);color:var(--color-primary);">
        <i class="fas fa-rss" aria-hidden="true"></i>
    </a>
    <?php endif; ?>

    <?php if (count($pages) === 0): ?>
    <p class="sui-page-list__empty" style="color:var(--color-text-secondary);">
        <?= h($noResultsMessage) ?>
    </p>

    <?php else: ?>
    <div
        class="sui-page-list__grid"
        style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:var(--space-6,24px);"
        role="list"
    >
        <?php foreach ($pages as $page): ?>
        <?php
            $title       = $page->getCollectionName();
            $description = $page->getCollectionDescription();
            $description = $controller->truncateSummaries
                ? $th->wordSafeShortText($description, $controller->truncateChars)
                : $description;

            if ($page->getCollectionPointerExternalLink() !== '') {
                $url    = $page->getCollectionPointerExternalLink();
                $target = $page->openCollectionPointerExternalLinkInNewWindow() ? '_blank' : '_self';
            } else {
                $url    = $page->getCollectionLink();
                $target = $page->getAttribute('nav_target') ?: '_self';
            }

            $targetAttr = ($target === '_blank') ? ' target="_blank" rel="noopener"' : '';

            $date      = $dh->formatDateTime($page->getCollectionDatePublic(), true);
            $thumbnail = false;
            if ($displayThumbnail) {
                $thumbnail = $page->getAttribute('thumbnail');
            }
        ?>
        <article class="sui-card sui-elevation-1" role="listitem" style="border-radius:var(--radius-lg);overflow:hidden;display:flex;flex-direction:column;">

            <?php if (is_object($thumbnail)): ?>
            <div class="sui-card__media" style="overflow:hidden;max-height:200px;">
                <?php
                $img = \Core::make('html/image', ['f' => $thumbnail]);
                $tag = $img->getTag();
                $tag->setAttribute('alt', $title);
                $tag->setAttribute('style', 'width:100%;height:200px;object-fit:cover;display:block;');
                echo $tag;
                ?>
            </div>
            <?php endif; ?>

            <div class="sui-card__body" style="padding:var(--space-5,20px);display:flex;flex-direction:column;flex:1;gap:var(--space-3,12px);">

                <?php if (isset($includeName) && $includeName && $title): ?>
                <h3 class="sui-card__title sui-heading" style="margin:0;font-size:var(--text-lg,1.125rem);">
                    <?php if (!isset($useButtonForLink) || !$useButtonForLink): ?>
                    <a href="<?= h($url) ?>"<?= $targetAttr ?> style="color:inherit;text-decoration:none;">
                        <?= h($title) ?>
                    </a>
                    <?php else: ?>
                    <?= h($title) ?>
                    <?php endif; ?>
                </h3>
                <?php endif; ?>

                <?php if (isset($includeDate) && $includeDate && $date): ?>
                <time class="sui-page-list__date" datetime="<?= h($page->getCollectionDatePublic()) ?>" style="font-size:var(--text-sm,0.875rem);color:var(--color-text-secondary);">
                    <?= h($date) ?>
                </time>
                <?php endif; ?>

                <?php if (isset($includeDescription) && $includeDescription && $description): ?>
                <p class="sui-card__text" style="margin:0;color:var(--color-text-secondary);flex:1;">
                    <?= h($description) ?>
                </p>
                <?php endif; ?>

                <?php if (isset($useButtonForLink) && $useButtonForLink): ?>
                <div class="sui-card__actions" style="margin-top:auto;padding-top:var(--space-3,12px);">
                    <a href="<?= h($url) ?>"<?= $targetAttr ?> class="sui-btn sui-btn-primary" style="display:inline-flex;align-items:center;gap:var(--space-2,8px);">
                        <?= h($buttonLinkText ?: t('Read more')) ?>
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
                <?php elseif (!isset($includeName) || !$includeName): ?>
                <div class="sui-card__actions" style="margin-top:auto;padding-top:var(--space-3,12px);">
                    <a href="<?= h($url) ?>"<?= $targetAttr ?> class="sui-btn sui-btn-text" style="display:inline-flex;align-items:center;gap:var(--space-2,8px);">
                        <?= t('Read more') ?>
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
                <?php endif; ?>

            </div><!-- .sui-card__body -->
        </article>
        <?php endforeach; ?>
    </div><!-- .sui-page-list__grid -->
    <?php endif; ?>

    <?php if ($showPagination): ?>
    <nav class="sui-page-list__pagination" aria-label="<?= t('Page list pagination') ?>" style="margin-top:var(--space-8,32px);">
        <?= $pagination ?>
    </nav>
    <?php endif; ?>

</section>
