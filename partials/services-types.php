<?php
$title = get_field('single_services_types_title') ?? '';
$descr = get_field('single_services_types_descr') ?? '';
$list = get_field('single_services_types_list') ?? '';
$column = get_field('single_services_types_column') ?: 3;
$image = get_field('single_services_types_image') ?? '';

?>
<?php if ($list): ?>
	<section class="section services-types" id="services-types">
		<div class="container services-types__container">
			<h2 class="services-types__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<?php if ($descr): ?>
				<div class="services-types__descr descr">
					<?php echo wp_kses_post($descr) ?>
				</div>
			<?php endif; ?>
			<ul class="services-types__list grid" style="--cols: <?= esc_attr($column) ?>;">
				<?php foreach ($list as $item): ?>
					<li
						class="services-types__item dark-glass-card services-types-item col-<?php echo esc_attr($item['single_services_types_list_column']) ?>">
						<div class="services-types-item__image">
							<?php echo wp_get_attachment_image(
								$item['single_services_types_list_image']['ID'],
								'large',
								false,
								array(
									'class' => 'img',
									'alt' => $item['single_services_types_list_image']['alt'] ?: $item['single_services_types_list_title']
								)
							); ?>
						</div>
						<h3 class="services-types-item__title title-3">
							<?php echo esc_html($item['single_services_types_list_title']) ?>
						</h3>
						<div class="services-types-item__descr descr">
							<?php echo wp_kses_post($item['single_services_types_list_descr']) ?>
						</div>
						<?php if ($item['single_services_types_list_btn']): ?>
							<a class="services-types-item__btn btn"
								href="<?php echo esc_attr($item['single_services_types_list_btn']['url']) ?>">
								<?php echo esc_html($item['single_services_types_list_btn']['title']) ?>
							</a>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
				<?php if ($image): ?>
					<li class="services-types__item dark-glass-card services-types-item-image image-box" aria-hidden="true">
						<?php echo wp_get_attachment_image(
							$image['ID'],
							'large',
							false,
							array(
								'class' => 'img',
								'alt' => $image['alt'] ?: ''
							)
						); ?>
					</li>
				<?php endif; ?>
			</ul>
			
		</div>
	</section>
<?php endif; ?>