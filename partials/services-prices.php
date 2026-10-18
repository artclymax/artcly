<?php
$title = get_field('services_prices_title') ?? '';
$list = get_field('services_prices_list') ?? '';
?>
<?php if ($list): ?>
	<section class="section services-prices" id="services-prices">
		<div class="container services-prices__container">
			<h2 class="services-prices__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<div class="swiper services-prices-swiper"
				data-swiper="{'slidesPerView': 'auto', 'spaceBetween': 10, 'breakpoints': { '768': {'slidesPerView': 'auto', 'spaceBetween': 24 } } }">
				<div class="swiper-wrapper services-prices-swiper__wrapper">
					<?php foreach ($list as $item): ?>
						<div class="swiper-slide services-prices-slide">
							<a class="services-prices-slide__wrapper services-prices-card light-glass-card" href="<?php echo esc_attr($item['services_prices_list_btn']['url']) ?>">
								<?php if ($item['services_prices_list_image']): ?>
									<div class="services-prices-card__image">
										<?php echo wp_get_attachment_image(
											$item['services_prices_list_image']['ID'],
											'large',
											false,
											array(
												'class' => 'img',
												'alt' => $item['services_prices_list_image']['alt'] ?: $item['services_prices_list_title']
											)
										); ?>
									</div>
								<?php endif; ?>
								<h3 class="services-prices-card__title title-3">
									<?php echo esc_html($item['services_prices_list_title']) ?>
								</h3>
								<div class="services-prices-card__descr descr">
									<?php echo wp_kses_post($item['services_prices_list_descr']) ?>
								</div>
								<p class="services-prices-card__limits title-2">
									<?php echo esc_html($item['services_prices_list_limits']) ?>
								</p>
								<p class="services-prices-card__size title-3">
									<?php echo esc_html($item['services_prices_list_size']) ?>
								</p>
								<?php if ($item['services_prices_list_btn']): ?>
									<span class="services-prices-card__btn btn"
									>
										<?php echo esc_html($item['services_prices_list_btn']['title']) ?>
									</span>
								<?php endif; ?>
							</a>
						</div>
					<?php endforeach; ?>
				</div>

			</div>
			<div class="swiper-pagination services-prices-swiper__pagination"
				data-swiper-pagination=".services-prices-swiper"></div>
		</div>
	</section>
<?php endif; ?>