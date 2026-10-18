<?php
/*
Template Name: Услуга - Разработка landing page
Template Post Type: services
*/
?>
<?php get_header(); ?>
<?php get_template_part('partials/hero-single-services'); ?>
<div class="block-decor"
	style="--decor-bg: url('<?php echo get_template_directory_uri() . '/assets/images/decor/single-services-decor-bg.webp' ?>')">
	<?php get_template_part('partials/services-types'); ?>
	<?php get_template_part('partials/services-crm-certificate'); ?>
	<?php get_template_part('partials/services-about-block'); ?>
	<?php get_template_part('partials/services-benefits-grid'); ?>
	<?php get_template_part('partials/services-prices'); ?>
	<?php get_template_part('partials/services-crm-steps'); ?>
	<?php get_template_part('partials/services-faq'); ?>
	<?php get_template_part('partials/specialties', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/about/special.png']); ?>
	<?php get_template_part('partials/section-reviews'); ?>
	<?php get_template_part('partials/section-form'); ?>
</div>
<?php get_footer(); ?>