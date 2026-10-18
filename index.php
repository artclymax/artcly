<?php get_header(); ?>


<?php if (have_posts()): ?>
	<?php while (have_posts()):
		the_post(); ?>
		<?php get_template_part('partials/hero-page', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/about/main.png']); ?>
	<?php endwhile; ?>
<?php else: ?>
	<div class="container descr index-section">
		<p>Записей не найдено.</p>
	</div>
<?php endif; ?>


<?php get_footer(); ?>