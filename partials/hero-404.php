<?php
$page = 'options';

$title = get_field('page_404_title', $page) ?? '';
$descr = get_field('page_404_descr', $page) ?? '';
$btn = get_field('page_404_btn', $page) ?? '';

$img = get_template_directory_uri() . '/assets/images/bg-404.png';
$img_light = get_template_directory_uri() . '/assets/images/img-404--light.png';
$img_mob_light = get_template_directory_uri() . '/assets/images/img-404-light-mob.png';
$img_mob_dark = get_template_directory_uri() . '/assets/images/img-404-dark-mob.png';
?>
<section class="hero-404" id="hero-404"
	style="--bg-light: url(<?php echo esc_url($img_light) ?>); --bg-dark: url(<?php echo esc_url($img) ?>); --bg-mob-light: url(<?php echo esc_url($img_mob_light) ?>); --bg-mob-dark: url(<?php echo esc_url($img_mob_dark) ?>);">
	<div class="container hero-404__container">
		<div class="hero-404__body">
			<h2 class="hero-404__title title-first descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<div class="hero-404__descr descr title-3">
				<?php echo wp_kses_post($descr) ?>
			</div>
			<a class="btn hero-404__btn" href="	<?php echo esc_attr($btn['url']) ?>">
				<?php echo esc_html($btn['title']) ?>
			</a>
		</div>
	</div>
	</div>
</section>