<?php defined('C5_EXECUTE') or die('Access Denied.');

/**
 * Spectral accordion — maps directly to Spectral UI showcase pattern.
 *
 * @var \Concrete\Block\Accordion\AccordionEntry[] $entries
 * @var string   $itemHeadingFormat  heading tag for screen-reader only label (h2/h3/h4)
 * @var string   $initialState       'open', 'openfirst', or null
 * @var bool     $alwaysOpen         allow multiple panels open simultaneously
 */

$initialState      = $initialState ?? null;
$alwaysOpen        = $alwaysOpen   ?? false;
$itemHeadingFormat = $itemHeadingFormat ?? 'h3';

// Determine which panel index is open by default (1-based to match Alpine)
$defaultOpen = null;
if ($initialState === 'openfirst') {
    $defaultOpen = 1;
} elseif ($initialState === 'open' && count($entries) > 0) {
    $defaultOpen = 1;
}

// Alpine state: single open (null = all closed) or set of open indices for alwaysOpen
$alpineInit = $alwaysOpen
    ? '{ opens: ' . ($defaultOpen ? '[1]' : '[]') . ' }'
    : '{ open: ' . ($defaultOpen ?? 'null') . ' }';
?>
<div class="sui-accordion" x-data="<?= h($alpineInit) ?>">

    <?php foreach ($entries as $i => $entry):
        $idx    = $i + 1;
        $btnId  = 'acc-btn-' . $bID . '-' . $idx;
        $panId  = 'acc-panel-' . $bID . '-' . $idx;

        if ($alwaysOpen) {
            $clickHandler  = "opens.includes($idx) ? opens = opens.filter(n => n !== $idx) : opens.push($idx)";
            $expandedBind  = "(opens.includes($idx)).toString()";
            $showBind      = "opens.includes($idx)";
        } else {
            $clickHandler  = "open = open === $idx ? null : $idx";
            $expandedBind  = "(open === $idx).toString()";
            $showBind      = "open === $idx";
        }
    ?>
    <div class="sui-accordion__item">

        <<?= h($itemHeadingFormat) ?> style="margin:0">
            <button class="sui-accordion__trigger"
                    type="button"
                    @click="<?= h($clickHandler) ?>"
                    :aria-expanded="<?= h($expandedBind) ?>"
                    aria-controls="<?= $panId ?>"
                    id="<?= $btnId ?>">
                <?= h($entry->getTitle()) ?>
                <span class="sui-accordion__icon" aria-hidden="true">▼</span>
            </button>
        </<?= h($itemHeadingFormat) ?>>

        <div class="sui-accordion__panel"
             id="<?= $panId ?>"
             role="region"
             aria-labelledby="<?= $btnId ?>"
             x-show="<?= $showBind ?>"
             x-transition:enter.duration.350ms
             x-transition:leave.duration.200ms
             style="display:none">
            <div class="sui-accordion__content">
                <?= $entry->getDescription() ?>
            </div>
        </div>

    </div>
    <?php endforeach; ?>

</div>
