<?php
$contacts_phones = get_field('contacts_phones', 'options') ?? [];
$class = $args['class'] ?? '';
?>
<?php if (!empty($contacts_phones)): ?>
	<ul class="phones-box <?php echo ' ' . $class; ?>">
		<?php foreach ($contacts_phones as $item): ?>
			<li class="phones-box__item">
				<h3 class="phones-box__title">
					<?php echo esc_html($item['title']) ?>
				</h3>
				<?php if ($item['list']): ?>
					<ul class="phones-box__list">
						<?php foreach ($item['list'] as $item): ?>
							<li class="phones-item phones-item">
								<a class="phones-item__link" href="tel:+<?php echo esc_attr(correct_phone($item['phone'])); ?>">
									<?php echo esc_html($item['phone']) ?>
								</a>
								<?php if ($item['messengers']): ?>
									<div class="phones-item__messengers">
										<?php foreach ($item['messengers'] as $msg): ?>
											<?php if ($msg == 'Вайбер'): ?>
												<a class="phones-item__link-icon"
													href="viber://chat?number=<?php echo esc_attr(correct_phone($item['phone'])); ?>" aria-label="Вайбер">
													<img src="<?php echo esc_attr(get_template_directory_uri() . '/assets/images/icons/vb.svg') ?>"
														alt="Вайбер">
												</a>
											<?php endif; ?>
											<?php if ($msg == 'Телеграм'): ?>
												<a class="phones-item__link-icon"
													href="https://t.me/+<?php echo esc_attr(correct_phone($item['phone'])); ?>" aria-label="Телеграм">
													<img src="<?php echo esc_attr(get_template_directory_uri() . '/assets/images/icons/tg.svg') ?>"
														alt="Телеграм">
												</a>
											<?php endif; ?>
											<?php if ($msg == 'Ватсап'): ?>
												<a class="phones-item__link-icon"
													href="https://wa.me/<?php echo esc_attr(correct_phone($item['phone'])); ?>" aria-label="Ватсап">
													<img src="<?php echo esc_attr(get_template_directory_uri() . '/assets/images/icons/wh.svg') ?>"
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
<?php endif; ?>