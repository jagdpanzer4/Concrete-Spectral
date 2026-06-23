<?php defined('C5_EXECUTE') or die('Access Denied.');
/**
 * Spectral theme override for accordion/edit.php
 *
 * Replaces the broken <ckeditor v-model> binding with a plain <textarea>
 * that reliably syncs to the Vue model via @input. Structurally identical
 * to the CCMS core template; only the description field changes.
 *
 * @var \Concrete\Core\Form\Service\Form $form
 * @var \Concrete\Block\Accordion\AccordionEntry[] $entries
 * @var string|null $initialState
 * @var string|null $itemHeadingFormat
 * @var int|null $alwaysOpen
 * @var int|null $flush
 */

use Concrete\Core\Application\Service\UserInterface;
use Concrete\Core\Support\Facade\Application;

$app = Application::getFacadeApplication();
$userInterface = $app->make(UserInterface::class);

echo $userInterface->tabs([
    ['accordion-content', t('Content'), true],
    ['accordion-settings', t('Settings')],
]);
?>

<div class="tab-content">

  <div class="tab-pane active" id="accordion-content" role="tabpanel">

    <div data-vue-app="accordion-block">

      <input type="hidden" name="accordionBlockData" :value="JSON.stringify(entries)" />

      <div class="p-2 btn-toolbar border-primary mb-2 border" role="toolbar">
        <button type="button" class="btn-sm btn btn-secondary" @click="addEntry">
          <i class="fas fa-plus-circle"></i> <?= t('Add Entry') ?>
        </button>
      </div>

      <draggable class="image-container" v-model="entries" :options="{handle:'.accordion-entry-move'}">
        <div v-for="(entry, index) in entries"
             :class="{'position-relative': true, 'p-2': true, 'm-2': true, 'bg-light': true, 'bg-opacity-50': !entry.expanded}">

          <div class="btn-group" style="position: absolute; top: 0; right: 0">
            <a href="javascript:void(0)" v-if="entry.expanded"
               class="d-flex align-items-center btn btn-secondary btn-sm"
               @click="entry.expanded = false">
              <i class="fas fa-compress-alt"></i>
            </a>
            <a href="javascript:void(0)" v-if="!entry.expanded"
               class="d-flex align-items-center btn btn-secondary btn-sm"
               @click="entry.expanded = true">
              <i class="fas fa-expand-alt"></i>
            </a>
            <a href="javascript:void(0)"
               class="d-flex align-items-center btn btn-secondary btn-sm accordion-entry-move">
              <i class="fa fa-arrows-alt"></i>
            </a>
            <a href="javascript:void(0)" @click="deleteEntry(index)"
               class="d-flex align-items-center btn btn-secondary btn-sm">
              <i class="fas fa-times"></i>
            </a>
          </div>

          <div v-if="entry.expanded">
            <div class="mb-3">
              <label class="form-label"><?= t('Title') ?></label>
              <input type="text" autocomplete="off" class="form-control" v-model="entry.title" />
            </div>
            <div class="mb-3">
              <label class="form-label"><?= t('Body') ?></label>
              <!-- Plain textarea — reliable sync with Vue model via @input.
                   Avoids the broken v-model binding on the CKEditor Vue component. -->
              <textarea class="form-control"
                        rows="6"
                        :value="entry.description"
                        @input="entry.description = $event.target.value"
                        placeholder="<?= t('Enter HTML content or plain text…') ?>"></textarea>
              <small class="form-text text-muted"><?= t('HTML is supported.') ?></small>
            </div>
          </div>

          <div v-else>
            <a href="javascript:void(0)" style="cursor:move" class="d-block">{{entry.title}}</a>
          </div>

        </div>
      </draggable>

    </div>

  </div>

  <div class="tab-pane" id="accordion-settings" role="tabpanel">
    <fieldset>

      <div class="form-group">
        <?= $form->label('initialState', t('Initial State')) ?>
        <?= $form->select('initialState',
            ['openfirst' => t('First Item Open'), 'closed' => t('All Items Closed'), 'open' => t('All Items Open')],
            $initialState ?? 'openfirst') ?>
      </div>

      <div class="form-group">
        <?= $form->label('itemHeadingFormat', t('Item Heading Format')) ?>
        <?= $form->select('itemHeadingFormat',
            \Concrete\Core\Block\BlockController::$btTitleFormats,
            $itemHeadingFormat ?? 'h2') ?>
      </div>

      <div class="form-group">
        <?= $form->label('options', t('Options')) ?>
        <div class="form-check">
          <?= $form->checkbox('alwaysOpen', '1', $alwaysOpen ?? false) ?>
          <?= $form->label('alwaysOpen',
              t('Always Open (keep items open when another opens)'),
              ['class' => 'form-check-label']) ?>
        </div>
        <div class="form-check">
          <?= $form->checkbox('flush', '1', $flush ?? false) ?>
          <?= $form->label('flush',
              t('Flush (render accordion edge-to-edge)'),
              ['class' => 'form-check-label']) ?>
        </div>
      </div>

    </fieldset>
  </div>

</div>

<script>
$(function () {
    Concrete.Vue.activateContext('accordion', function (Vue, config) {
        new Vue({
            el: 'div[data-vue-app=accordion-block]',
            components: config.components,
            data: {
                entries: <?= json_encode(
                    array_map(fn($e) => [
                        'title'       => $e->getTitle(),
                        'description' => $e->getDescription(),
                        'expanded'    => false,
                    ], $entries ?? [])
                ) ?>
            },
            methods: {
                addEntry () {
                    this.entries.push({ title: '', description: '', expanded: true });
                },
                deleteEntry (index) {
                    this.entries.splice(index, 1);
                }
            }
        });
    });
});
</script>
