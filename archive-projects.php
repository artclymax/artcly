<?php get_header(); ?>

<?php get_template_part('partials/hero-page'); ?>
<?php get_template_part('partials/page-projects', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/reviews-page-decor.png']); ?>
<?php get_template_part('partials/section-form'); ?>
<?php get_footer(); ?>