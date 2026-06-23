<?php defined('C5_EXECUTE') or die('Access Denied.');
/** @var \Concrete\Block\Autonav\Controller $controller */

/**
 * Spectral autonav block template.
 *
 * Flat $navItems array properties used:
 *   ->url, ->name, ->target, ->level, ->subDepth,
 *   ->hasSubmenu, ->isCurrent, ->inPath, ->isHome, ->cID
 *
 * Level-1 items with children become Alpine.js button-triggered dropdowns.
 * Deeper sub-items with children render as plain nested <ul> lists inside
 * the already-open Alpine panel.
 */

$navItems = $controller->getNavItems();
$c = \Concrete\Core\Page\Page::getCurrentPage();
?>
<?php if (count($navItems) > 0): ?>
<nav class="sui-nav" aria-label="<?= t('Main navigation') ?>">
    <ul class="sui-nav__list">
        <?php foreach ($navItems as $ni):
            $isActive   = $ni->isCurrent || $ni->inPath;
            $linkClass  = 'sui-nav__link' . ($isActive ? ' sui-nav__link--active' : '');
            $ariaCurrent = $ni->isCurrent ? ' aria-current="page"' : '';
        ?>
        <?php if ($ni->level === 1 && $ni->hasSubmenu): ?>
            <li class="sui-nav__item sui-nav__item--has-dropdown"
                x-data="{ open: false }"
                @click.outside="open = false">
                <button
                    type="button"
                    class="<?= $linkClass ?>"
                    @click="open = !open"
                    :aria-expanded="open.toString()"
                    aria-haspopup="true"
                    <?= $ariaCurrent ?>
                ><?= h($ni->name) ?><span class="sui-nav__caret" aria-hidden="true" :class="{ 'sui-nav__caret--open': open }"></span></button>
                <ul class="sui-nav__dropdown"
                    x-show="open"
                    x-transition:enter="sui-transition-enter"
                    x-transition:enter-start="sui-transition-enter-start"
                    x-transition:enter-end="sui-transition-enter-end"
                    x-transition:leave="sui-transition-leave"
                    x-transition:leave-start="sui-transition-leave-start"
                    x-transition:leave-end="sui-transition-leave-end"
                    style="display:none">
        <?php elseif ($ni->hasSubmenu): ?>
            <li class="sui-nav__item">
                <a href="<?= h($ni->url) ?>"
                   target="<?= h($ni->target) ?>"
                   class="<?= $linkClass ?>"<?= $ariaCurrent ?>><?= h($ni->name) ?></a>
                <ul class="sui-nav__dropdown sui-nav__dropdown--nested">
        <?php else: ?>
            <li class="sui-nav__item">
                <a href="<?= h($ni->url) ?>"
                   target="<?= h($ni->target) ?>"
                   class="<?= $linkClass ?>"<?= $ariaCurrent ?>><?= h($ni->name) ?></a>
            </li>
            <?= str_repeat('</ul></li>', $ni->subDepth) ?>
        <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</nav>
<?php elseif (is_object($c) && $c->isEditMode()): ?>
    <div class="ccm-edit-mode-disabled-item"><?= t('Empty Auto-Nav Block.') ?></div>
<?php endif; ?>
