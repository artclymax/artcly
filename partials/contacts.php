<?php
$page = 'options';

$phones_title = get_field('contacts_phones_title', $page) ?? '';
$phones = get_field('contacts_phones', $page) ?? '';

$email_title = get_field('contacts_email_title', $page) ?? '';
$email = get_field('contacts_email', $page) ?? '';

$address_title = get_field('contacts_address_title', $page) ?? '';
$address = get_field('contacts_address', $page) ?? '';
$time = get_field('contacts_time', $page) ?? '';

$payment_title = get_field('contacts_payment_title', $page) ?? '';
$payment = get_field('contacts_payment', $page) ?? '';

$map = get_field('contacts_map', $page) ?? '';

$bg = $args['bg'] ?? '';
?>
<section class="section contacts pt-0" id="contacts" style="--decor-bg: url('<?php echo esc_url($bg) ?>');">
	<div class="container contacts__container">
		<ul class="contacts__list">
			<?php if ($phones): ?>
				<li class="contacts__item contacts-item">
					<h3 class="contacts-item__title title-2">
						<?php echo esc_html($phones_title) ?>
					</h3>
					<ul class="contacts-item__list contacts-phones">
						<?php foreach ($phones as $item): ?>
							<li class="contacts-phones__item">
								<p class="contacts-phones__text">
									<?php echo esc_html($item['title']) ?>
								</p>
								<?php if ($item['list']): ?>
									<ul class="contacts-phones__list">
										<?php foreach ($item['list'] as $phone): ?>
											<li class="contacts-phones__item contacts-phones-item">
												<a class="contacts-phones-item__link link"
													href="tel:+<?php echo esc_attr(correct_phone($phone['phone'])) ?>">
													<?php echo esc_html($phone['phone']) ?>
												</a>
												<?php if ($phone['messengers']): ?>
													<div class="contacts-phones-item__messangers">
														<?php foreach ($phone['messengers'] as $msg): ?>
															<?php if ($msg == 'Вайбер'): ?>
																<a class="contacts-phones-item__icon-link"
																	href="viber://chat?number=<?php echo esc_attr(correct_phone($phone['phone'])); ?>"
																	aria-label="Вайбер">
																	<img
																		src="<?php echo esc_attr(get_template_directory_uri() . '/assets/images/icons/vb.svg') ?>"
																		alt="Вайбер">
																</a>
															<?php endif; ?>
															<?php if ($msg == 'Телеграм'): ?>
																<a class="contacts-phones-item__icon-link"
																	href="https://t.me/+<?php echo esc_attr(correct_phone($phone['phone'])); ?>"
																	aria-label="Телеграм">
																	<img
																		src="<?php echo esc_attr(get_template_directory_uri() . '/assets/images/icons/tg.svg') ?>"
																		alt="Телеграм">
																</a>
															<?php endif; ?>
															<?php if ($msg == 'Ватсап'): ?>
																<a class="contacts-phones-item__icon-link"
																	href="https://wa.me/<?php echo esc_attr(correct_phone($phone['phone'])); ?>"
																	aria-label="Ватсап">
																	<img
																		src="<?php echo esc_attr(get_template_directory_uri() . '/assets/images/icons/wh.svg') ?>"
																		alt="Ватсап">
																</a>
															<?php endif; ?>
														<?php endforeach; ?>
													</div>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</li>
			<?php endif; ?>
			<?php if ($email): ?>
				<li class="contacts__item contacts-item">
					<h3 class="contacts-item__title title-2">
						<?php echo esc_html($email_title) ?>
					</h3>
					<ul class="contacts-item__list contacts-email">
						<?php foreach ($email as $item): ?>
							<li class="contacts-email__item">
								<a class="contacts-email__link link" href="mailto:<?php echo esc_attr($item['link']) ?>">
									<span><?php echo esc_html($item['text']) ?></span>
									<span><?php echo esc_html($item['link']) ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</li>
			<?php endif; ?>
			<?php if ($address): ?>
				<li class="contacts__item contacts-item">
					<h3 class="contacts-item__title title-2">
						<?php echo esc_html($address_title) ?>
					</h3>
					<address class="contacts-item__address descr">
						<?php echo wp_kses_post($address) ?>
					</address>
					<div class="contacts-item__time descr">
						<?php echo wp_kses_post($time) ?>
					</div>
				</li>
			<?php endif; ?>
			<?php if ($payment): ?>
				<li class="contacts__item contacts-item contacts-item--big">
					<h3 class="contacts-item__title title-2">
						<?php echo esc_html($payment_title) ?>
					</h3>
					<div class="contacts-item__descr descr">
						<?php echo wp_kses_post($payment) ?>
					</div>
				</li>
			<?php endif; ?>
		</ul>
		<?php if ($map): ?>
			<div class="contacts__map">
				<?php echo wp_kses($map, [
					'iframe' => [
						'src' => true,
						'width' => true,
						'height' => true,
						'style' => true,
						'allowfullscreen' => true,
						'loading' => true,
					],
				]) ?>
			</div>
		<?php endif; ?>
	</div>
</section>