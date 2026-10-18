<?php
$bg = $args['bg'] ?? '';
?>


<section class="section page-blog pt-0" id="page-blog" style="--decor-bg: url('<?php echo esc_url($bg) ?>');">
	<div class="container page-blog__container">
		<ul class="page-blog__list grid">
			<?php if (have_posts()): ?>
				<?php while (have_posts()):
					the_post(); ?>
					<li class="page-blog__item section-blog-item">
						<div class="section-blog-item__image image-box">
							<?php the_post_thumbnail('large') ?>
						</div>
						<a class="section-blog-item__link" href="<?php the_permalink() ?>">
							<time class="section-blog-item__data" datetime="<?php echo get_the_date('Y-m-d') ?>">
								<?php the_date() ?>
							</time>
							<h3 class="section-blog-item__title title-3">
								<?php the_title(); ?>
							</h3>
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