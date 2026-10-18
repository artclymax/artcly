<?php

$bg = $args['bg'] ?? '';
?>

<section class="section page-reviews pt-0" id="page-reviews" style="--decor-bg: url('<?php echo esc_url($bg) ?>');">
	<div class="container page-reviews__container">
		<ul class="page-reviews__list grid">
			<?php if (have_posts()): ?>
				<?php while (have_posts()):
					the_post(); ?>

					<li class="page-reviews__item page-reviews-item">
						<a class="page-reviews-item__link-wrapper" href="<?php the_post_thumbnail_url() ?>" data-fancybox>
							<div class="page-reviews-item__image image-box">
								<?php the_post_thumbnail() ?>
							</div>
							<h3 class="page-reviews-item__title title-2">
								<?php the_title() ?>
							</h3>
							<div class="page-reviews-item__author descr">
								<?php the_content() ?>
							</div>
						</a>
					</li>

				<?php endwhile; ?>
			<?php endif; ?>
		</ul>
		<div class="pagination-page page-projects__pagination">
			<?php
			echo paginate_links([
				'total' => $wp_query->max_num_pages,
				'mid_size' => 1,
				'current' => max(1, get_query_var('paged')),
				'prev_next' => false
			]);
			?>
		</div>
	</div>
</section>