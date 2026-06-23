<?php defined('C5_EXECUTE') or die('Access Denied.');

if (!isset($query) || !is_string($query)) {
    $query = '';
}
?>
<form class="sui-search-form" method="get" action="<?= h($view->url($resultTarget)) ?>" aria-label="<?= h(t('Site search')) ?>" role="search">

    <?php if ($query === '' && isset($baseSearchPath) && $baseSearchPath !== '') { ?>
    <input type="hidden" name="search_paths[]" value="<?= h($baseSearchPath) ?>" />
    <?php } elseif (isset($search_paths) && is_array($search_paths)) {
        foreach ($search_paths as $search_path) {
            if (is_string($search_path) && $search_path !== '') { ?>
    <input type="hidden" name="search_paths[]" value="<?= h($search_path) ?>" />
            <?php }
        }
    } ?>

    <?php if (isset($title) && $title !== '') { ?>
    <h3 class="sui-search-form__title" style="margin-bottom:var(--space-3,12px);"><?= h($title) ?></h3>
    <?php } ?>

    <div class="sui-search-form__row" style="display:flex;gap:var(--space-2,8px);align-items:stretch;">
        <label for="sui-search-input" class="sui-visually-hidden"><?= h(t('Search')) ?></label>
        <input
            id="sui-search-input"
            type="search"
            name="query"
            class="sui-input sui-search-form__input"
            value="<?= h($query) ?>"
            placeholder="<?= h(t('Search…')) ?>"
            style="flex:1;border-radius:var(--radius-base,4px);"
            autocomplete="off"
        />
        <button type="submit" name="submit" class="sui-btn sui-btn-primary sui-search-form__submit">
            <?= h(isset($buttonText) && $buttonText !== '' ? $buttonText : t('Search')) ?>
        </button>
    </div>

    <?php if (!empty($allowUserOptions)) { ?>
    <div class="sui-search-form__options" style="margin-top:var(--space-3,12px);">
        <span class="sui-search-form__options-label"><?= h(t('Search scope:')) ?></span>
        <label style="margin-left:var(--space-2,8px);">
            <input type="radio" name="options" value="ALL" <?= !empty($searchAll) ? 'checked' : '' ?> />
            <?= h(t('All Sites')) ?>
        </label>
        <label style="margin-left:var(--space-2,8px);">
            <input type="radio" name="options" value="CURRENT" <?= empty($searchAll) ? 'checked' : '' ?> />
            <?= h(t('Current Site')) ?>
        </label>
    </div>
    <?php } ?>

</form>

<?php if (!empty($do_search)) { ?>
<div class="sui-search-results" style="margin-top:var(--space-6,24px);">
    <?php if (empty($results)) { ?>
    <p class="sui-search-results__empty"><?= h(t('No results found. Please try a different keyword or phrase.')) ?></p>
    <?php } else { ?>
    <ul class="sui-search-results__list" style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:var(--space-4,16px);">
        <?php foreach ($results as $r) { ?>
        <li class="sui-search-results__item">
            <h3 class="sui-search-results__title" style="margin:0 0 var(--space-1,4px);">
                <a href="<?= h($r->getCollectionLink()) ?>" class="sui-link"><?= h($r->getCollectionName()) ?></a>
            </h3>
            <?php if ($r->getCollectionDescription()) { ?>
            <p class="sui-search-results__desc" style="margin:0;"><?= h($r->getCollectionDescription()) ?></p>
            <?php } ?>
        </li>
        <?php } ?>
    </ul>
    <?php if (isset($pagination) && $pagination->haveToPaginate()) {
        echo $pagination->renderDefaultView();
    } ?>
    <?php } ?>
</div>
<?php } ?>
