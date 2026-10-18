<?php
$title = get_field('type_of_services_title') ?? '';
$list = get_field('type_of_services_list') ?? '';
$btn = get_field('type_of_services_btn') ?? '';

?>
<?php if ($list): ?>
	<section class="section type-of-services" id="type-of-services">
		<div class="container type-of-services__container">
			<h2 class="type-of-services__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<ul class="type-of-services__list grid">
				<?php foreach ($list as $item):
					$image = $item['type_of_services_list_image'];
					$link = $item['type_of_services_list_link'];
					$title = $item['type_of_services_list_title'];
					$descr = $item['type_of_services_list_descr'];
					?>
					<li class="type-of-services__item type-of-services-item">
						<a class="type-of-services-item__link dark-glass-card" href="<?= esc_attr($link['url']); ?>">
							<div class="type-of-services-item__image">
								<?php echo wp_get_attachment_image(
									$image['ID'],
									'large',
									false,
									array(
										'class' => 'img',
										'alt' => $image['alt'] ?: $title
									)
								); ?>
							</div>
							<div class="type-of-services-item__content">
								<h3 class="type-of-services-item__title title-3">
									<?php echo esc_html($title) ?>
								</h3>
								<div class="type-of-services-item__descr descr">
									<?php echo wp_kses_post($descr) ?>
								</div>
								<span class="type-of-services-item__btn btn">
									<?php echo esc_html($link['title']) ?>
								</span>
							</div>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php if ($btn): ?>
				<a class="type-of-services__btn btn" href="<?= esc_attr($btn['url']) ?>">
					<?php echo esc_html($btn['title'] ?? 'Подробнее') ?>
				</a>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>