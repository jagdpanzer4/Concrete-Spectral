<?php defined('C5_EXECUTE') or die('Access Denied.');
/**
 * Spectral testimonial block template.
 *
 * @var string|null $image       Author avatar rendered by CMS (<img> tag)
 * @var string|null $name        Author name
 * @var string|null $position    Job title
 * @var string|null $company     Company name
 * @var string|null $companyURL  Company URL
 * @var string|null $paragraph   Quote text
 * @var string|null $awardImage  Award image rendered by CMS (<img> tag)
 */
?>
<figure class="sui-testimonial">

    <?php if ($paragraph): ?>
    <blockquote class="sui-testimonial__quote">
        <p><?= h($paragraph) ?></p>
    </blockquote>
    <?php endif; ?>

    <figcaption class="sui-testimonial__author">

        <?php if ($image): ?>
        <div class="sui-testimonial__avatar" aria-hidden="true">
            <?= $image ?>
        </div>
        <?php endif; ?>

        <div class="sui-testimonial__meta">
            <?php if ($name): ?>
            <strong class="sui-testimonial__name"><?= h($name) ?></strong>
            <?php endif; ?>

            <?php if ($position || $company): ?>
            <span class="sui-testimonial__role">
                <?php if ($position && $company && $companyURL): ?>
                    <?= h($position) ?>, <a href="<?= h($companyURL) ?>" class="sui-link" rel="noopener"><?= h($company) ?></a>
                <?php elseif ($position && $company): ?>
                    <?= h($position) ?>, <?= h($company) ?>
                <?php elseif ($position && $companyURL): ?>
                    <a href="<?= h($companyURL) ?>" class="sui-link" rel="noopener"><?= h($position) ?></a>
                <?php else: ?>
                    <?= h($position ?: $company) ?>
                <?php endif; ?>
            </span>
            <?php endif; ?>
        </div>

        <?php if ($awardImage): ?>
        <div class="sui-testimonial__award" aria-hidden="true">
            <?= $awardImage ?>
        </div>
        <?php endif; ?>

    </figcaption>

</figure>
