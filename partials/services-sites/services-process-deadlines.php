<?php
$title = get_field('services_process_deadlines_title') ?? '';
$descr = get_field('services_process_deadlines_descr') ?? '';
$list = get_field('services_process_deadlines_list') ?? '';
$note = get_field('services_process_deadlines_note') ?? '';
$btn = get_field('services_process_deadlines_btn') ?? '';

if ($note) {
	$note_title = $note['services_process_deadlines_note_title'] ?? '';
	$note_image = $note['services_process_deadlines_note_image'] ?? '';
	$note_text = $note['services_process_deadlines_note_text'] ?? '';
}

?>
<?php if ($list): ?>
	<section class="section services-process-deadlines" id="services-process-deadlines">
		<div class="container services-process-deadlines__container">
			<div class="services-process-deadlines__header">
				<h2 class="services-process-deadlines__title title-1 title-mix descr">
					<?php echo wp_kses_post($title) ?>
				</h2>
				<?php if ($descr): ?>
					<div class="services-process-deadlines__descr descr">
						<?php echo wp_kses_post($descr) ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="services-process-deadlines__wrapper">
				<ul class="services-process-deadlines__list">
					<?php foreach ($list as $index => $item): ?>
						<li class="services-process-deadlines__item services-process-deadlines-item">
							<div class="services-process-deadlines-item__num title-2">
								/<?php echo esc_html($index > 9 ? $index + 1 : '0' . ($index + 1)) ?>
							</div>
							<p class="services-process-deadlines-item__text">
								<?php echo esc_html($item['services_process_deadlines_list_text']) ?>
							</p>
						</li>
					<?php endforeach; ?>
				</ul>
				<?php if ($note): ?>
					<div class="services-process-deadlines__note dark-glass-card">
						<h3 class="services-process-deadlines__note-title title-2">
							<?php echo esc_html($note_title) ?>
						</h3>
						<div class="services-process-deadlines__note-wrapper">
							<div class="services-process-deadlines__note-image">
								<?php echo wp_get_attachment_image(
									$note_image['ID'],
									'large',
									false,
									array(
										'class' => 'img',
										'alt' => $note_image['alt'] ?: $note_title
									)
								); ?>
							</div>
							<p class="services-process-deadlines__note-text">
								<?php echo esc_html($note_text) ?>
							</p>
						</div>
					</div>
				<?php endif; ?>

			</div>
			<?php if ($btn): ?>
				<a class="services-process-deadlines__btn btn" href="<?php echo esc_html($btn['url']) ?>">
					<?php echo esc_html($btn['title']) ?>
				</a>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>