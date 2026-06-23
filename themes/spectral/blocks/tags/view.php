<?php defined('C5_EXECUTE') or die('Access Denied.');
/**
 * @var \Concrete\Core\Entity\Attribute\Value\Value\SelectValueOption[] $options
 * @var string $selectedOptionID
 * @var string|null $selectedTag
 * @var string|null $title
 * @var string $titleFormat
 * @var \Concrete\Block\Tags\Controller $controller
 */
$titleFormat = $titleFormat ?? 'h5';
if (empty($options)) { return; }
?>
<?php if (!empty($title)): ?>
<<?= $titleFormat ?>><?= h($title) ?></<?= $titleFormat ?>>
<?php endif; ?>
<div class="sui-tags" style="display:flex;flex-wrap:wrap;gap:var(--space-2,8px);" role="list" aria-label="<?= t('Tags') ?>">
    <?php foreach ($options as $option):
        $isSelected = isset($selectedTag) && mb_strtolower($option->getSelectAttributeOptionValue()) === mb_strtolower($selectedTag);
        $tagUrl = $controller->getTagLink($option);
    ?>
    <span role="listitem">
        <a href="<?= h($tagUrl) ?>"
           class="sui-chip sui-chip--outlined<?= $isSelected ? ' sui-chip--active' : '' ?>"
           style="display:inline-flex;align-items:center;padding:var(--space-1,4px) var(--space-3,12px);border-radius:var(--radius-full,9999px);border:1px solid var(--color-border);font-size:.875rem;text-decoration:none;"
           <?= $isSelected ? 'aria-current="true"' : '' ?>>
            <?= h($option->getSelectAttributeOptionDisplayValue()) ?>
        </a>
    </span>
    <?php endforeach; ?>
</div>
