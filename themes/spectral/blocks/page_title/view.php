<?php defined('C5_EXECUTE') or die('Access Denied.');
/** @var string|null $title */
/** @var string $formatting */
/** @var bool $useFilterTitle */

// Re-apply same filter logic as core (copy from concrete/blocks/page_title/view.php)
if (!empty($useFilterTitle)) {
    $currentTopic = $currentTopic ?? null;
    if (is_object($currentTopic) && !empty($useFilterTopic)) {
        $title = $controller->formatPageTitle($currentTopic->getTreeNodeDisplayName(), $tagTextFormat ?? false);
    }
    if (!empty($tag) && !empty($useFilterTag)) {
        $title = $controller->formatPageTitle($tag, $tagTextFormat ?? false);
    }
    if (!empty($year) && !empty($month) && !empty($useFilterDate)) {
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
