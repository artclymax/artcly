<?php
$slug = get_query_var('post_type');
$page = get_page_by_path($slug);

$title = '';
$descr = '';

if (is_singular()) {

	$title = get_field('hero_title') ?: get_the_title();
	$descr = get_field('hero_descr') ?: apply_filters(
		'the_content',
		get_post_field('post_content', get_the_ID())
	);

} elseif (is_tax('projects_category')) {

	$current_term = get_queried_object();

	// Получаем объект пост-типа, к которому привязана таксономия
	$post_type = get_post_type_object('projects');

	$post_type_label = $post_type->labels->name ?? '';
	$term_name = $current_term->name ?? '';

	$title = $post_type_label . ' — ' . $term_name;

	$descr = term_description($current_term->term_id, 'projects_category');
} elseif ($page) {

	$title = get_field('hero_title', $page) ?: $page->post_title;
	$descr = get_field('hero_descr', $page) ?: apply_filters(
		'the_content',
		$page->post_content
	);

}

$bg = $args['bg'] ?? '';
?>

<section class="hero-page" id="hero-page" style="--decor-bg: url('<?php echo esc_url($bg) ?>">
	<div class="container hero-page__container">
		<div class="hero-page__breadcrumbs breadcrumbs">
			<?php if (function_exists('bcn_display')) {
				bcn_display();
			} ?>
		</div>
		<h1 class="hero-page__title title-first">
			<?php echo esc_html($title) ?>
		</h1>
		<?php if ($descr): ?>
			<div class="descr hero-page__descr">
				<?php echo wp_kses_post($descr) ?>
			</div>
		<?php endif; ?>
	</div>
</section>