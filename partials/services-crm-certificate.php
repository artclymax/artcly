<?php
$title = get_field('services_crm_certificate_title') ?? '';
$descr = get_field('services_crm_certificate_descr') ?? '';
$image = get_field('services_crm_certificate_image') ?? '';

?>
<section class="section services-crm-certificate" id="services-crm-certificate">
	<div class="container services-crm-certificate__container">
		<div class="services-crm-certificate__content">
			<h2 class="services-crm-certificate__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<div class="services-crm-certificate__descr descr">
				<?php echo wp_kses_post($descr) ?>
			</div>
		</div>
		<?php if ($image): ?>
			<a class="services-crm-certificate__image image-box" data-fancybox href="<?= esc_attr($image['url']) ?>">
				<?php echo wp_get_attachment_image(
					$image['ID'],
					'large',
					false,
					array(
						'class' => 'img',
						'alt' => $image['alt'] ?: ''
					)
				); ?>
			</a>
		<?php endif; ?>
	</div>
</section>