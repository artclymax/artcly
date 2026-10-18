<?php
$page = 'options';

$title = get_field('section_blog_title', $page) ?? '';
$btn = get_field('section_blog_link', $page) ?? [];
$bg = $args['bg'] ?? '';

$args = [
	'post_type' => 'blog',
	'posts_per_page' => 6,
	'orderby' => 'menu_order',
	'order' => 'ASC'
];

$query = new WP_Query($args);
?>
<section class="section section-blog" id="section-blog" style="--decor-bg: url('<?php echo esc_attr($bg); ?>')">
	<div class="container section-blog__container">
		<h2 class="section-blog__title title-1 title-mix mb-title descr">
			<?php echo wp_kses_post($title) ?>
		</h2>
		<ul class="section-blog__list grid">
			<?php
			if ($query->have_posts()):
				while ($query->have_posts()):
					$query->the_post();
					?>
					<li class="section-blog__item section-blog-item">
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
					<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</ul>
		<a class="section-blog__btn btn" href="<?php echo esc_url($btn['url']) ?>">
			<?php echo esc_html($btn['title']) ?>
		</a>
	</div>
</section>