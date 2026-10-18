<?php
/*
Template Name: Блог - галерея + контент план
Template Post Type: blog
*/
$blog_grid = get_field('single_blog_grid') ?? [];
?>
<?php get_header(); ?>
<?php get_template_part('partials/hero-single-blog', null, ['bg' => get_template_directory_uri() . '/assets/images/decor/reviews-page-decor.png']); ?>

<?php if (!empty($blog_grid)): ?>
	<section class="section pt-0 single-blog-grid" id="single-blog-grid">
		<h2 class="visually-hidden">
			<?php the_title() ?>
		</h2>
		<div class="container single-blog-grid__container">
			<?php foreach ($blog_grid as $block): ?>
				<div class="single-blog-grid__item <?= $block['toggle'] ? 'single-blog-grid__item--reverse' : '' ?>">
					<?php if (!empty($block['gallery'])): ?>
						<div class="swiper single-blog-grid-swiper" data-swiper="{'slidesPerView': 1, 'rewind': true, 'spaceBetween': 24, 'pagination': { 'el': '.single-blog-grid-swiper__pagination', 'clickable': true }}">
							<div class="swiper-wrapper single-blog-grid-swiper__wrapper">
								<?php foreach ($block['gallery'] as $item): ?>
									<div class="swiper-slide single-blog-grid-slide">
										<a class="single-blog-grid-slide__wrapper image-box" href="<?= $item['url'] ?>" data-fancybox>
											<?php echo wp_get_attachment_image(
												$item['ID'],
												'large',
												false,
												array(
													'class' => 'img',
													'alt' => $item['alt'] ?: ''
												)
											); ?>
										</a>
									</div>
								<?php endforeach; ?>
							</div>
							<div class="swiper-pagination single-blog-grid-swiper__pagination" ></div>
						</div>
					<?php endif; ?>
					<?php if (!empty($block['descr'])): ?>
						<div class="single-blog-grid__descr descr">
							<?php echo wp_kses_post($block['descr']) ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
<?php else: ?>
	<div class="section pt-0 container container-blog single-blog-content">
		<ep the_content() ?>
	</div>
<?php endif; ?>


<?php get_template_part('partials/section-form'); ?>
<?php get_footer(); ?>