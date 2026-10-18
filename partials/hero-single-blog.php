<?php
$bg = $args['bg'] ?? '';
?>

<section class="hero-single-blog" id="hero-single-blog" style="--decor-bg: url('<?php echo esc_url($bg) ?>">
	<div class="container hero-single-blog__container">
		<div class="hero-single-blog__breadcrumbs breadcrumbs">
			<?php if (function_exists('bcn_display')) {
				bcn_display();
			} ?>
		</div>
		<h1 class="hero-single-blog__title title-first">
			<?php the_title() ?>
		</h1>
		<time class="hero-single-blog__time" datetime="<?php echo get_the_date('Y-m-d') ?>">
			<?php echo get_the_date() ?>
		</time>
		<div class="hero-single-blog__image image-box">
			<?php the_post_thumbnail() ?>
		</div>
	</div>
</section>