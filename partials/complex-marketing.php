<?php
$page = 'options';

$title = get_field('complex_marketing_title', $page) ?? '';
$list = get_field('complex_marketing_list', $page) ?? '';

?>
<?php if ($list): ?>
	<section class="section complex-marketing pt-section-05" id="complex-marketing" style="background-image: url('<?php echo esc_attr(get_template_directory_uri() . '/assets/images/complex-marketing/bg.png') ?>')">
		<div class="container complex-marketing__container">
			<h2 class="complex-marketing__title title-1 title-mix mb-title descr">
				<?php echo wp_kses_post($title)?>
			</h2>
			<ul class="complex-marketing__list grid">
				<?php foreach ($list as $item): ?>
					<li class="complex-marketing__item complex-marketing-item">
						<div class="complex-marketing-item__icon">
							<?php echo wp_get_attachment_image(
								$item['image']['ID'],
								'large',
								false,
								array(
									'class' => 'img',
									'alt' => $item['image']['alt'] ?: $item['title']
								)
							); ?>
						</div>
						<h3 class="complex-marketing-item__title title-2">
							<?php echo esc_html($item['title'])?>
						</h3>
						<div class="descr complex-marketing-item__descr">
							<?php echo wp_kses_post($item['descr'])?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>