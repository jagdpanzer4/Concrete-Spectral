<?php defined('C5_EXECUTE') or die('Access Denied.');
/** @var string|null $title */
/** @var string $formatting */
/** @var bool $useFilterTitle */

if ($useFilterTitle ?? false) {
    $currentTopic = $currentTopic ?? null;
    if (is_object($currentTopic) && ($useFilterTopic ?? false)) {
        $title = $controller->formatPageTitle($currentTopic->getTreeNodeDisplayName(), $tagTextFormat ?? false);
    }
    if (isset($tag) && ($useFilterTag ?? false)) {
        $title = $controller->formatPageTitle($tag, $tagTextFormat ?? false);
    }
    if (isset($year) && isset($month) && ($useFilterDate ?? false)) {
        $srv = app('helper/date');
        $title = $controller->formatPageTitle(
            $srv->date($filterDateFormat ?? 'F Y', strtotime("$year-$month-01")),
            $dateTextFormat ?? false
        );
    }
}

if (!empty($title)): ?>
<<?= h($formatting) ?> class="sui-h sui-heading-section ccm-block-page-title">
    <?= h($title) ?>
</<?= h($formatting) ?>>
<?php endif; ?>
