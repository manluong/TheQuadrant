<?php if($posttags):?>
<div class="tags tags-session">
	<div class="title-tags"><?php esc_html_e('Tags:', 'cosmos')?></div><?php
	$links = array();
	foreach($posttags as $tag) {
		$tag_link = get_tag_link($tag->term_id);
		$links[] = sprintf( '<a href="%1$s" class="name" rel="tag">%2$s</a>', esc_url( $tag_link ), esc_html( $tag->name ) );
	}// endforeach
	if( $links ) {
		echo '<ul class="list-inline list-tag">';
		echo '<li>'.implode('</li><li>', $links) .'</li>';
		echo '</ul>';
	}?>
</div><?php
endif;?>