<?php
$title = get_field('single_services_showcase_title') ?? '';
$list = get_field('single_services_showcase_list') ?? '';
?>
<?php if ($list): ?>
	<section class="section services-showcase" id="services-showcase">
		<div class="container services-showcase__container">
			<h2 class="services-showcase__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
		</div>
		<div class="container services-showcase__swiper-container container--wide">
			<div class="swiper services-showcase-swiper" data-swiper="{'slidesPerView': 'auto', 'spaceBetween': 24 }">
				<div class="swiper-wrapper services-showcase-swiper__wrapper">
					<?php foreach ($list as $item): ?>
						<div class="swiper-slide services-showcase-slide">
							<div class="services-showcase-slide__wrapper">
								<a class="services-showcase-slide__image image-box" data-fancybox
									href="<?= esc_attr($item['single_services_showcase_list_image']['url']) ?>">
									<?php echo wp_get_attachment_image(
										$item['single_services_showcase_list_image']['ID'],
										'large',
										false,
										array(
											'class' => 'img',
											'alt' => $item['single_services_showcase_list_image']['alt'] ?: $item['single_services_showcase_list_title']
										)
									); ?>
								</a>
								<h3 class="services-showcase-slide__title title-3">
									<?php echo esc_html($item['single_services_showcase_list_title']) ?>
								</h3>
								<div class="services-showcase-slide__descr descr">
									<?php echo wp_kses_post($item['single_services_showcase_list_descr']) ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="swiper-pagination services-showcase-swiper__pagination visible-mobile"
					data-swiper-pagination=".services-showcase-swiper"></div>
			</div>
			<button class="hidden-mobile swiper-btn swiper-btn__prev services-showcase-swiper__btn services-showcase-swiper__btn-prev"
				type="button" aria-label="Назад" data-swiper-btn-prev=".services-showcase-swiper">
				<svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path
						d="M0.646446 3.64645C0.451184 3.84171 0.451184 4.15829 0.646446 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.976311 4.7308 0.659729 4.53553 0.464467C4.34027 0.269205 4.02369 0.269205 3.82843 0.464467L0.646446 3.64645ZM13 4L13 3.5L1 3.5L1 4L1 4.5L13 4.5L13 4Z"
						fill="currentColor" />
				</svg>
			</button>
			<button class="hidden-mobile swiper-btn swiper-btn__next services-showcase-swiper__btn services-showcase-swiper__btn-next"
				type="button" aria-label="Вперёд" data-swiper-btn-next=".services-showcase-swiper">
				<svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path
						d="M12.3536 4.35355C12.5488 4.15829 12.5488 3.84171 12.3536 3.64645L9.17157 0.464465C8.97631 0.269203 8.65973 0.269203 8.46447 0.464465C8.2692 0.659728 8.2692 0.97631 8.46447 1.17157L11.2929 4L8.46447 6.82843C8.2692 7.02369 8.2692 7.34027 8.46447 7.53553C8.65973 7.7308 8.97631 7.7308 9.17157 7.53553L12.3536 4.35355ZM0 4L4.37114e-08 4.5L12 4.5L12 4L12 3.5L-4.37114e-08 3.5L0 4Z"
						fill="currentColor" />
				</svg>
			</button>
		</div>
	</section>
<?php endif; ?>