<?php
$title = get_field('services_features_title') ?? '';
$list = get_field('services_features_list') ?? '';

?>
<?php if ($list): ?>
	<section class="section services-features" id="services-features">
		<div class="container services-features__container">
			<h2 class="services-features__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<ul class="services-features__list grid">
				<?php foreach ($list as $item): ?>
					<li class="services-features__item services-features-item">
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