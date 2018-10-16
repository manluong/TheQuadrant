<?php if($postcats): ?>
<div class="categories-meta">
	<div class="title-tags"><?php echo esc_html_e('Categories:', 'cosmos')?></div>
	<?php
	$links = array();
	foreach($postcats as $cat) {
		$cat_link = get_category_link($cat->term_id);
		$links[] = sprintf( '<a class="topic" href="%1$s">%2$s</a>', esc_url( $cat_link ), esc_html( $cat->name ) );
	}
	if( $links ) {
		echo '<ul class="list-inline list-tag">';
		echo '<li>'.implode('</li><li>', $links) .'</li>';
		echo '</ul>';
	}?>
</div>
<?php endif; ?>