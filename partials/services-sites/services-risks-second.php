<?php
$title = get_field('risks_second_title') ?? '';
$descr = get_field('risks_second_descr') ?? '';
$image = get_field('risks_second_image') ?? '';
$list = get_field('risks_second_list') ?? '';
$bad = get_field('risks_second_bad') ?? '';
$good = get_field('risks_second_good') ?? '';
$btn = get_field('risks_second_btn') ?? '';

?>
<?php if ($list): ?>
	<section class="section services-risks services-risks-second" id="services-risks">
		<div class="container services-risks__container">
			<h2 class="services-risks__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<?php if ($descr): ?>
				<div class="services-risks__descr descr">
					<?php echo wp_kses_post($descr) ?>
				</div>
			<?php endif; ?>
			<div class="services-risks__wrapper">
				<div class="services-risks__content">
					<ul class="services-risks__list grid">
						<?php foreach ($list as $item): ?>
							<li class="services-risks__item services-risk-item">
								<div class="services-risk-item__content">
									<h3 class="services-risk-item__title">
										<?php echo esc_html($item['risks_list_title']) ?>
									</h3>
									<p class="services-risk-item__text">
										<?php echo esc_html($item['risks_list_text']) ?>
									</p>
								</div>
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
			<div class="services-risks__workflow services-risks-workflow">
				<?php if ($bad): ?>
					<div class="services-risks-workflow__item services-risks-workflow__item--bad">
						<h3 class="services-risks-workflow__title title-3">
							Неправильный путь
						</h3>
						<div class="services-risks-workflow__wrapper">
							<ul class="services-risks-workflow__list services-risks-workflow-list services-risks-workflow-list--bad">
								<?php foreach ($bad as $item): ?>
									<li class="light-glass-card services-risks-workflow-list__item">
										<?php echo esc_html($item['risks_bad_list_text']) ?>
									</li>
								<?php endforeach; ?>
								<li class="light-glass-card services-risks-workflow-list__last-item">
									<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M7 7L25 25M7 25L25 7" stroke="#F85356" stroke-width="2.5" stroke-linecap="round" />
									</svg>
								</li>
							</ul>
						</div>
					</div>
				<?php endif; ?>
				<?php if ($good): ?>
					<div class="services-risks-workflow__item services-risks-workflow__item--good">
						<h3 class="services-risks-workflow__title title-3">
							Правильный путь
						</h3>
						<div class="services-risks-workflow__wrapper">
							<ul
								class="services-risks-workflow__list services-risks-workflow-list services-risks-workflow-list--good">
								<?php foreach ($good as $item): ?>
									<li class="light-glass-card services-risks-workflow-list__item">
										<?php echo esc_html($item['risks_good_list_text']) ?>
									</li>
								<?php endforeach; ?>
								<li class="light-glass-card services-risks-workflow-list__last-item">
									<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path
											d="M26.0846 8.36904L26.4892 8.77361C26.7034 8.98793 26.8238 9.27856 26.8238 9.58161C26.8238 9.88465 26.7034 10.1753 26.4892 10.3896L13.3806 23.4982C13.1663 23.7124 12.8757 23.8328 12.5726 23.8328C12.2696 23.8328 11.9789 23.7124 11.7646 23.4982L6.08461 17.8182C5.87036 17.6039 5.75 17.3132 5.75 17.0102C5.75 16.7071 5.87036 16.4165 6.08461 16.2022L6.48918 15.7976C6.7035 15.5834 6.99414 15.463 7.29718 15.463C7.60023 15.463 7.89087 15.5834 8.10518 15.7976L11.7646 19.457C11.9789 19.6713 12.2696 19.7917 12.5726 19.7917C12.8757 19.7917 13.1663 19.6713 13.3806 19.457L24.4686 8.36904C24.6829 8.15478 24.9736 8.03442 25.2766 8.03442C25.5797 8.03442 25.8703 8.15478 26.0846 8.36904Z"
											fill="#6274FF" />
									</svg>
								</li>
							</ul>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<?php if ($btn): ?>
				<a class="services-risks__btn btn" href="<?php echo esc_attr($btn['url']) ?>">
					<?php echo esc_html($btn['title']) ?>
				</a>
			<?php endif; ?>
		</div>

	</section>
<?php endif; ?>