<?php
$title = get_field('single_services_benefits_grid_title') ?? '';
$list = get_field('single_services_benefits_grid_list') ?? '';
?>
<?php if ($list): ?>
	<section class="section services-benefits-grid" id="services-benefits-grid">
		<div class="container services-benefits-grid__container">
			<h2 class="services-benefits-grid__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>

			<ul class="services-benefits-grid__list grid">
				<?php foreach ($list as $item): ?>
					<li class="services-showcase-slide services-benefits-grid__item">
						<div class="services-showcase-slide__wrapper">
							<div class="services-showcase-slide__image image-box" data-fancybox>
								<?php echo wp_get_attachment_image(
									$item['single_services_benefits_grid_list_image']['ID'],
									'large',
									false,
									array(
										'class' => 'img',
										'alt' => $item['single_services_benefits_grid_list_image']['alt'] ?: $item['single_services_benefits_grid_list_title']
									)
								); ?>
							</div>
							<h3 class="services-showcase-slide__title title-3">
								<?php echo esc_html($item['single_services_benefits_grid_list_title']) ?>
							</h3>
							<div class="services-showcase-slide__descr descr">
								<?php echo wp_kses_post($item['single_services_benefits_grid_list_descr']) ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>