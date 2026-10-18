<?php
$title = get_field('services_hero_title') ?: get_the_title() ?? '';
$descr = get_the_content() ?: get_field('services_hero_descr') ?? '';
$note = get_field('services_hero_add_note') ?? '';

if ($note) {
	$note_title = $note['services_hero_add_note_title'] ?? '';
	$note_image = $note['services_hero_add_note_image'] ?? '';
}
$list = get_field('services_hero_add_list') ?? [];


//services_hero_add_list_image
//services_hero_add_list_title
$btn_first = get_field('services_hero_add_btn_first') ?? '';
$btn_second = get_field('services_hero_add_btn_second') ?? '';
?>

<section class="hero-single-services hero-single-services-noform jarallax" id="hero-single-services">
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
			<?php if ($note): ?>
				<div class="hero-single-services__note hero-single-services-note dark-glass-card">
					<div class="hero-single-services-note__image">
						<?php echo wp_get_attachment_image(
							$note_image['ID'],
							'large',
							false,
							array(
								'class' => 'img',
								'alt' => $note_image['alt'] ?: ''
							)
						); ?>
					</div>
					<div class="hero-single-services-note__title title-3">
						<?php echo wp_kses_post($note_title) ?>
					</div>
				</div>
			<?php endif; ?>

		</div>
		<?php if ($list): ?>
			<ul class="hero-single-services__list grid">
				<?php foreach ($list as $item):
					$title = $item['services_hero_add_list_title'] ?? '';
					$image = $item['services_hero_add_list_image'] ?? '';
					?>
					<li class="hero-single-services__item hero-single-services-item">
						<div class="hero-single-services-item__image">
							<?php echo wp_get_attachment_image(
								$image['ID'],
								'large',
								false,
								array(
									'class' => 'img',
									'alt' => $image['alt'] ?: ''
								)
							); ?>
						</div>
						<h3 class="hero-single-services-item__title">
							<?php echo esc_html($title) ?>
						</h3>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<div class="hero-single-services__btn-box">
			<?php if ($btn_first): ?>
				<a class="hero-single-services__btn btn" href="<?= esc_attr($btn_first['url']) ?>">
					<?= esc_html($btn_first['title']) ?>
				</a>
			<?php endif; ?>
			<?php if ($btn_second): ?>
				<a class="hero-single-services__btn btn btn--white" href="<?= esc_attr($btn_second['url']) ?>">
					<?= esc_html($btn_second['title']) ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<div class="hero-single-services__image image-box jarallax-img" aria-hidden="true">
		<?php the_post_thumbnail() ?>
	</div>
</section>