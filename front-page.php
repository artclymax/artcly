<?php get_header(); ?>

<?php get_template_part('partials/hero'); ?>
<?php get_template_part('partials/complex-marketing'); ?>
<?php get_template_part('partials/section-services'); ?>
<?php get_template_part('partials/process'); ?>
<?php get_template_part('partials/results'); ?>
<?php get_template_part('partials/section-projects'); ?>
<?php get_template_part('partials/section-reviews'); ?>
<?php get_template_part('partials/section-about', null, ['has_btn' => false, 'bg' => get_template_directory_uri() . '/assets/images/decor/decor-4.png']); ?>
<?php get_template_part('partials/specialties', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/decor-5.png']); ?>

<?php get_template_part('partials/section-blog', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/decor-6.png']); ?>

<?php get_template_part('partials/section-form'); ?>

<?php get_footer(); ?>