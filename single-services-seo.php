<?php
/*
Template Name: Услуга - SEO-оптимизация сайта
Template Post Type: services
*/
?>
<?php get_header(); ?>
<?php get_template_part('partials/hero-single-services'); ?>
<div class="block-decor"
	style="--decor-bg: url('<?php echo get_template_directory_uri() . '/assets/images/decor/single-services-decor-bg.webp' ?>')">

	<?php get_template_part('partials/services-features'); ?>
	<?php get_template_part('partials/services-risks'); ?>
	<?php get_template_part('partials/section-form'); ?>
	<?php get_template_part('partials/services-benefits'); ?>
	<?php get_template_part('partials/services-types'); ?>
	<?php get_template_part('partials/services-cta-form'); ?>
	<?php get_template_part('partials/services-projects-slider'); ?>
	<?php get_template_part('partials/section-reviews'); ?>
	<?php get_template_part('partials/services-faq'); ?> 
	<?php get_template_part('partials/services-cta-form-last'); ?> 
</div>
<?php get_footer(); ?>