<?php
$page = 'options';

$title = get_field('about_steps_title', $page) ?? '';
$list = get_field('about_steps_list', $page) ?? '';
$bg = $args['bg'] ?? '';

?>
<?php if ($list): ?>
	<section class="section about-steps" id="about-steps" style="--decor-bg: url('<?php echo esc_url($bg) ?>">
		<div class="container about-steps__container">
			<h2 class="about-steps__title title-1 title-mix descr mb-title">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<ul class="about-steps__list grid">
				<?php foreach ($list as $item): ?>
					<li class="about-steps__item about-steps-item">
						<p class="about-steps-item__text text-2">
							<?php echo esc_html($item['about_steps_list_text']) ?>
						</p>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>