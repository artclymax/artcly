<?php
$title = get_field('risks_title') ?? '';
$descr = get_field('risk_descr') ?? '';
$image = get_field('risks_image') ?? '';
$list = get_field('risks_list') ?? '';
$type = get_field('risks_type') ?? '';

?>
<?php if ($list): ?>
	<section class="section services-risks <?= $type == 'center' ? 'services-risks--center' : '' ?>" id="services-risks">
		<div class="container services-risks__container">
			<?php if ($type == 'center'): ?>
				<h2 class="services-risks__title title-1 title-mix descr">
					<?php echo wp_kses_post($title) ?>
				</h2>
				<?php if ($descr): ?>
					<div class="services-risks__descr descr title-3">
						<?php echo wp_kses_post($descr) ?>
					</div>
				<?php endif; ?>
				<div class="services-risks__wrapper">
					<ul class="services-risks__list services-risks__list--left">
						<?php foreach ($list as $index => $item): ?>
							<?php if ($index % 2 == 0): ?>
								<li class="services-risks__item services-risk-item">
									<?php echo esc_html($item['risks_list_text']) ?>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
					<div class="services-risks__image image-box" aria-hidden="true">
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
					<ul class="services-risks__list services-risks__list--right">
						<?php foreach ($list as $index => $item): ?>
							<?php if ($index % 2 != 0): ?>
								<li class="services-risks__item services-risk-item">
									<?php echo esc_html($item['risks_list_text']) ?>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php else: ?>
				<div class="services-risks__wrapper">
					<div class="services-risks__content">
						<h2 class="services-risks__title title-1 title-mix descr">
							<?php echo wp_kses_post($title) ?>
						</h2>
						<?php if ($descr): ?>
							<div class="services-risks__descr descr title-3">
								<?php echo wp_kses_post($descr) ?>
							</div>
						<?php endif; ?>
						<ul class="services-risks__list">
							<?php foreach ($list as $item): ?>
								<li class="services-risks__item services-risk-item">
									<?php echo esc_html($item['risks_list_text']) ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div class="services-risks__image image-box" aria-hidden="true">
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
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>