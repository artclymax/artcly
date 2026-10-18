<?php
$page = 'options';

$title = get_field('hero_title', $page) ?? '';
$descr = get_field('hero_descr', $page) ?? '';
$benefits = get_field('hero_benefits', $page) ?? '';
$btn = get_field('hero_btn', $page) ?? '';
$slider = get_field('hero_slider', $page) ?? '';
$image = get_field('hero_image', $page) ?? '';
$slider = array_merge($slider, $slider);
?>
<section class="hero jarallax" id="hero" style="background-image: url(<?php echo esc_url($image) ?>);">
	<div class="container hero__container">
		<div class="hero__body">
			<h2 class="hero__title">
				<span class="hero__title-main">
					<?php echo esc_html($title['main']) ?>
				</span>
				<span class="hero__title-second">
					<?php echo esc_html($title['second']) ?>
				</span>
			</h2>
			<div class="hero__descr descr">
				<?php echo wp_kses_post($descr) ?>
			</div>
			<?php if ($benefits): ?>
				<ul class="hero__list">
					<?php foreach ($benefits as $elem): ?>
						<li class="hero__item">
							<h3 class="hero__item-title">
								<?php echo esc_html($elem['title']) ?>
							</h3>
							<div class="hero__item-descr descr">
								<?php echo wp_kses_post($elem['descr']) ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<a class="btn hero__btn" href="	<?php echo esc_attr($btn['url']) ?>">
				<?php echo esc_html($btn['title']) ?>
			</a>
		</div>
		<?php if ($slider): ?>
			<div class="swiper hero-swiper-thumb">
				<div class="swiper-wrapper hero-swiper-thumb__wrapper">
					<?php foreach ($slider as $item): ?>
						<div class="swiper-slide hero-slide-thumb">
							<div class="hero-slide-thumb__wrapper">
								<a class="hero-slide-thumb__title text-2" href="<?php echo esc_attr($item['link']['url']) ?>">
									<?php echo esc_html($item['link']['title']) ?>
								</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>