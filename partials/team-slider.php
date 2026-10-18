<?php
$page = 'options';

$title = get_field('about_team_slider_title', $page) ?? '';

$args = [
	'post_type' => 'team',
	'posts_per_page' => -1, // все записи
	'orderby' => 'menu_order',
	'order' => 'ASC'
];

$query = new WP_Query($args);
?>
<section class="section team-slider" id="team-slider">
	<div class="container team-slider__container mb-title">
		<h2 class="team-slider__title title-1 title-mix descr">
			<?php echo wp_kses_post($title) ?>
		</h2>
	</div>
	<div class="container team-slider__swiper-container">
		<div class="swiper team-slider-swiper" data-swiper="{'slidesPerView': 'auto', 'freeMode': 'true'}">
			<div class="swiper-wrapper team-slider-swiper__wrapper">
				<?php
				if ($query->have_posts()):
					while ($query->have_posts()):
						$query->the_post();
						?>
						<div class="swiper-slide team-slider-slide">
							<div class="team-slider-slide__wrapper">
								<div class="team-slider-slide__image image-box">
									<?php the_post_thumbnail()?>
								</div>
								<h3 class="team-slider-slide__title title-2">
									<?php the_title() ?>
								</h3>
								<p class="team-slider-slide__position">
									<?php echo esc_html(get_field('team_position'))?>
								</p>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
		</div>
		<button class="swiper-btn swiper-btn__prev team-slider-swiper__btn team-slider-swiper__btn-prev hidden-mobile"
			type="button" aria-label="Назад" data-swiper-btn-prev=".team-slider-swiper">
			<svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path
					d="M0.646446 3.64645C0.451184 3.84171 0.451184 4.15829 0.646446 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.976311 4.7308 0.659729 4.53553 0.464467C4.34027 0.269205 4.02369 0.269205 3.82843 0.464467L0.646446 3.64645ZM13 4L13 3.5L1 3.5L1 4L1 4.5L13 4.5L13 4Z"
					fill="currentColor" />
			</svg>
		</button>
		<button class="swiper-btn swiper-btn__next team-slider-swiper__btn team-slider-swiper__btn-next hidden-mobile"
			type="button" aria-label="Вперёд" data-swiper-btn-next=".team-slider-swiper">
			<svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path
					d="M12.3536 4.35355C12.5488 4.15829 12.5488 3.84171 12.3536 3.64645L9.17157 0.464465C8.97631 0.269203 8.65973 0.269203 8.46447 0.464465C8.2692 0.659728 8.2692 0.97631 8.46447 1.17157L11.2929 4L8.46447 6.82843C8.2692 7.02369 8.2692 7.34027 8.46447 7.53553C8.65973 7.7308 8.97631 7.7308 9.17157 7.53553L12.3536 4.35355ZM0 4L4.37114e-08 4.5L12 4.5L12 4L12 3.5L-4.37114e-08 3.5L0 4Z"
					fill="currentColor" />
			</svg>
		</button>
	</div>
</section>