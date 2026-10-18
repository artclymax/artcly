<?php
$page = 'options';

$title = get_field('specialties_title', $page) ?? '';
$list = get_field('specialties_list', $page) ?? [];
$bg = $args['bg'] ?? '';
$list = array_merge($list, $list);
?>
<?php if ($list): ?>
	<section class="section specialties" id="specialties" style="--decor-bg: url('<?php echo esc_url($bg) ?>">
		<div class="container specialties__container">
			<h2 class="specialties__title title-1 title-mix mb-title descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
		</div>
		<div class="specialties__wrapper">
			<div class="specialties__running-line running-line" data-running-line data-running-line-paused>
				<ul class="running-line__list specialties__running-line-list" data-running-line-list>
					<?php foreach ($list as $item): ?>
						<li class="running-line__item specialties__running-line-item">
							<?php echo esc_html($item['specialties_list_text']) ?>
						</li>
					<?php endforeach; ?>
			</div>
			<div class="specialties__running-line running-line" data-running-line="right" data-running-line-paused>
				<ul class="running-line__list specialties__running-line-list" data-running-line-list>
					<?php foreach ($list as $item): ?>
						<li class="running-line__item specialties__running-line-item">
							<?php echo esc_html($item['specialties_list_text']) ?>
						</li>
					<?php endforeach; ?>
			</div>
			<div class="specialties__running-line running-line" data-running-line data-running-line-paused data-running-line-reverse>
				<ul class="running-line__list specialties__running-line-list" data-running-line-list>
					<?php foreach ($list as $item): ?>
						<li class="running-line__item specialties__running-line-item">
							<?php echo esc_html($item['specialties_list_text']) ?>
						</li>
					<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>