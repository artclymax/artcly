<?php get_header(); ?>

<?php get_template_part('partials/hero-page'); ?>
<?php get_template_part('partials/contacts', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/contacts-decor.png']); ?>
<?php get_template_part('partials/cta-form', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/contacts-decor.png']); ?>

<?php get_footer(); ?>