<?php
$title = get_field('services_hero_title') ?: get_the_title() ?? '';
$descr = get_the_content() ?: get_field('services_hero_descr') ?? '';

$form_title = get_field('services_hero_form_title') ?: 'Получите бесплатный аудит';
$form_descr = get_field('services_hero_form_descr') ?: 'Введите ваше имя и телефон и мы свяжемся с вами в ближайшее время';
?>

<section class="hero-single-services jarallax" id="hero-single-services">
	<div class="container hero-single-services__container">
		<div class="hero-single-services__breadcrumbs breadcrumbs">
			<?php if (function_exists('bcn_display')) {
				bcn_display();
			} ?>
		</div>
		<div class="hero-single-services__wrapper">
			<div class="hero-single-services__content">
				<h1 class="hero-single-services__title title-first title-mix descr">
					<?php echo wp_kses_post($title) ?>
				</h1>
				<div class="hero-single-services__descr title-3 descr">
					<?php echo wp_kses_post($descr) ?>
				</div>
			</div>
			<div class="hero-single-services__form hero-form">
				<h3 class="hero-form__title title-3">
					<?php echo esc_html($form_title) ?>
				</h3>
				<div class="hero-form__descr descr">
					<?php echo wp_kses_post($form_descr) ?>
				</div>
				<div class="hero-form__form">
					<?php echo do_shortcode('[contact-form-7 id="341d11a" title="Получите бесплатный аудит"]') ?>
				</div>
			</div>
		</div>
	</div>
	<div class="hero-single-services__image image-box jarallax-img" aria-hidden="true">
		<?php the_post_thumbnail() ?>
	</div>
</section>