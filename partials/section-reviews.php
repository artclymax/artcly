<?php
$page = 'options';

$title = get_field('section_reviews_title', $page) ?? '';
$btn = get_field('sections_reviews_btn', $page) ?? '';
$bg = $args['bg'] ?? '';

$args = [
	'post_type' => 'reviews',
	'posts_per_page' => 8,
	'orderby' => 'menu_order',
	'order' => 'ASC',
];

$query = new WP_Query($args);

$params = [
	'slidesPerView' => 1.5,
	'spaceBetween' => -10,
	'loop' => true,
	'effect' => 'coverflow',
	'coverflowEffect' => [
		'rotate' => 35,
		'stretch' => 0,
		'depth' => 150,
		'modifier' => 1,
		'slideShadows' => false,
	],
	'autoplay' => [
		'speed' => 3000,
		'disableOnInteraction' => true,
	],
	'grabCursor' => true,
	'centeredSlides' => true,
	'breakpoints' => [
		'768' => [
			'slidesPerView' => 3,
			'spaceBetween' => 20,
			'autoplay' => [
				'speed' => 3000,
				'disableOnInteraction' => true,
			],
		],
		'1024' => [
			'slidesPerView' => 4,
			'spaceBetween' => 20,
			'autoplay' => [
				'speed' => 3000,
				'disableOnInteraction' => true,
			],
		]
	]
];

$json = json_encode($params);
?>
<section class="section section-reviews" id="sections-reviews" style="--decor-bg: url('<?php echo esc_url($bg) ?>');">
	<div class="container section-reviews__container">
		<h2 class="section-reviews__title title-1 title-mix mb-title descr">
			<?php echo wp_kses_post($title) ?>
		</h2>
		<div class="section-reviews__slider">
			<div class="swiper section-reviews-swiper" data-swiper="<?php echo esc_attr($json) ?>">
				<div class="swiper-wrapper section-reviews-swiper__wrapper">
					<?php
					if ($query->have_posts()):
						while ($query->have_posts()):
							$query->the_post();
							?>
							<div class="swiper-slide section-reviews-slide">
								<a class="section-reviews-slide__wrapper-link image-box" href="<?php the_post_thumbnail_url() ?>"
									data-fancybox>
									<?php the_post_thumbnail() ?>
								</a>
							</div>
							<?php
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
				<div class="swiper-pagination section-reviews-swiper__pagination visible-mobile"
					data-swiper-pagination=".section-reviews-swiper">
				</div>
			</div>
			<button class="swiper-btn swiper-btn__prev section-reviews-swiper__btn section-reviews-swiper__btn-prev hidden-mobile"
				type="button" aria-label="Назад" data-swiper-btn-prev=".section-reviews-swiper">
				<svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path
						d="M0.646446 3.64645C0.451184 3.84171 0.451184 4.15829 0.646446 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.976311 4.7308 0.659729 4.53553 0.464467C4.34027 0.269205 4.02369 0.269205 3.82843 0.464467L0.646446 3.64645ZM13 4L13 3.5L1 3.5L1 4L1 4.5L13 4.5L13 4Z"
						fill="currentColor" />
				</svg>
			</button>
			<button class="swiper-btn swiper-btn__next section-reviews-swiper__btn section-reviews-swiper__btn-next hidden-mobile"
				type="button" aria-label="Вперёд" data-swiper-btn-next=".section-reviews-swiper">
				<svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path
						d="M12.3536 4.35355C12.5488 4.15829 12.5488 3.84171 12.3536 3.64645L9.17157 0.464465C8.97631 0.269203 8.65973 0.269203 8.46447 0.464465C8.2692 0.659728 8.2692 0.97631 8.46447 1.17157L11.2929 4L8.46447 6.82843C8.2692 7.02369 8.2692 7.34027 8.46447 7.53553C8.65973 7.7308 8.97631 7.7308 9.17157 7.53553L12.3536 4.35355ZM0 4L4.37114e-08 4.5L12 4.5L12 4L12 3.5L-4.37114e-08 3.5L0 4Z"
						fill="currentColor" />
				</svg>
			</button>
		</div>
		<a class="section-reviews__btn btn" href="<?php echo esc_attr($btn['url']) ?>">
			<?php echo esc_html($btn['title']) ?>
		</a>
	</div>
</section>