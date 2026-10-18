<?php
$title = get_field('services_features_title') ?? '';
$descr = get_field('services_features_descr') ?? '';
$list = get_field('services_features_list') ?? '';

?>
<?php if ($list): ?>
	<section class="section services-features services-features-second" id="services-features">
		<div class="container services-features__container">
			<div class="services-features__header">
				<h2 class="services-features__title title-1 title-mix descr">
					<?php echo wp_kses_post($title) ?>
				</h2>
				<?php if ($descr): ?>
					<div class="services-features__descr descr">
						<?php echo wp_kses_post($descr) ?>
					</div>
				<?php endif; ?>
			</div>
			<ul class="services-features__list grid">
				<?php foreach ($list as $item): ?>
					<li class="services-features__item services-features-item ">
						<div class="services-features-item__header">
							<div class="services-features-item__image">
								<?php echo wp_get_attachment_image(
									$item['services_features_list_image']['ID'],
									'large',
									false,
									array(
										'class' => 'img',
										'alt' => $item['services_features_list_image']['alt'] ?: $item['services_features_list_title']
									)
								); ?>
							</div>
						</div>
						<?php if ($item['services_features_list_title']): ?>
							<h3 class="services-features-item__title title-3">
								<?php echo esc_html($item['services_features_list_title']) ?>
							</h3>
						<?php endif; ?>
						<div class="services-features-item__descr descr">
							<?php echo wp_kses_post($item['services_features_list_descr']) ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>