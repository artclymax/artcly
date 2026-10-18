<?php
$page = 'options';

$title = get_field('about_team_title', $page) ?? '';
$descr = get_field('about_team_descr', $page) ?? '';
$image_1 = get_field('about_team_image_1', $page) ?? '';
$image_2 = get_field('about_team_image_2', $page) ?? '';
$image_big = get_field('about_team_image_big', $page) ?? '';
$bg = $args['bg'] ?? '';
?>
<section class="section about-team" id="about-team" style="--decor-bg: url('<?php echo esc_url($bg) ?>">
	<div class="container about-team__container">
		<h2 class="about-team__title title-1 descr mb-title title-mix">
			<?php echo wp_kses_post($title) ?>
		</h2>
		<div class="about-team__wrapper">
			<div class="about-team__descr descr">
				<?php echo wp_kses_post($descr) ?>
			</div>
			<div class="about-team__image image-box">
				<?php echo wp_get_attachment_image(
					$image_big['ID'],
					'large',
					false,
					array(
						'class' => 'img',
						'alt' => $image_big['alt'] ?: ''
					)
				); ?>
			</div>

			<div class="about-team__mini-gallery">
				<div class="about-team__mini-image image-box">
					<?php echo wp_get_attachment_image(
						$image_1['ID'],
						'large',
						false,
						array(
							'class' => 'img',
							'alt' => $image_1['alt'] ?: ''
						)
					); ?>
				</div>
				<div class="about-team__mini-image image-box">
					<?php echo wp_get_attachment_image(
						$image_2['ID'],
						'large',
						false,
						array(
							'class' => 'img',
							'alt' => $image_2['alt'] ?: ''
						)
					); ?>
				</div>
			</div>
		</div>
	</div>
</section>