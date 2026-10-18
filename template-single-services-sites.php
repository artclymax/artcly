<?php
/*
Template Name: Услуга - Создание сайтов (2)
Template Post Type: services
*/
?>
<?php get_header(); ?>
<?php get_template_part('partials/services-sites/hero-single-services-noform'); ?>
<div class="block-decor"
	style="--decor-bg: url('<?php echo get_template_directory_uri() . '/assets/images/decor/single-services-decor-bg.webp' ?>')">
	<?php get_template_part('partials/services-sites/services-risks-second'); ?>
	<?php get_template_part('partials/services-sites/services-features-second'); ?>
	<?php get_template_part('partials/services-sites/services-cta-form-second'); ?>
	<?php get_template_part('partials/services-sites/type-of-services'); ?>
	<?php get_template_part('partials/services-sites/services-results-form'); ?>
	<?php get_template_part('partials/services-sites/services-process-deadlines'); ?>
	
	<?php get_template_part('partials/section-projects'); ?>
	<?php get_template_part('partials/section-reviews'); ?>
	<?php get_template_part('partials/services-faq'); ?>
	<?php get_template_part('partials/section-form'); ?>
</div>
<?php get_footer(); ?>