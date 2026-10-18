<?php
/*
Template Name: Услуга
Template Post Type: services
*/
?>
<?php get_header(); ?>
<?php get_template_part('partials/hero-single-services'); ?>
<div class="block-decor"
	style="--decor-bg: url('<?php echo get_template_directory_uri() . '/assets/images/decor/single-services-decor-bg.webp' ?>')">

	<?php get_template_part('partials/services-risks'); ?>
	<?php get_template_part('partials/services-benefits'); ?>
	<?php get_template_part('partials/services-for-whom'); ?>
	<?php get_template_part('partials/services-features'); ?>
	<?php get_template_part('partials/services-showcase'); ?>
	<?php get_template_part('partials/services-types'); ?>
	<?php get_template_part('partials/services-features'); ?>
	<?php get_template_part('partials/services-approach'); ?>
	<?php get_template_part('partials/services-steps'); ?>
	<?php get_template_part('partials/section-projects'); ?>
	<?php get_template_part('partials/section-reviews'); ?>
	<?php get_template_part('partials/services-faq'); ?>
	<?php get_template_part('partials/section-form'); ?>
</div>
<?php get_footer(); ?>