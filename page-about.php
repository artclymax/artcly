<?php get_header(); ?>

<?php get_template_part('partials/hero-page', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/about/main.png']); ?>
<?php get_template_part('partials/section-about', null, ['has_btn' => true, 'class' => 'pt-0']); ?>
<?php get_template_part('partials/about-benefits', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/about/benefits.png']); ?>
<?php get_template_part('partials/specialties', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/about/special.png']); ?>
<?php get_template_part('partials/about-team', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/about/team.png']); ?>
<?php get_template_part('partials/team-slider'); ?>
<?php get_template_part('partials/about-steps', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/about/steps.png']); ?>
<?php get_template_part('partials/section-projects'); ?>
<?php get_template_part('partials/section-reviews', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/about/reviews.png']); ?>
<?php get_template_part('partials/section-form'); ?>

<?php get_footer(); ?>