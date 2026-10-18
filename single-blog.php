<?php get_header(); ?>
<?php get_template_part('partials/hero-single-blog', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/reviews-page-decor.png']); ?>
<div class="section pt-0 container container-blog single-blog-content">
	<?php the_content() ?>
</div>
<?php get_template_part('partials/section-form'); ?>
<?php get_footer(); ?>