<?php
if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) {
	$day = get_the_date( 'j' );
	$month = get_the_date( 'D' );
	$year = get_the_date( 'Y' );
	printf( '<div class="blog-image">
				<div class="timeline-date non-hover">
	                <div class="day">%3$s</div>
	                <div class="month">%4$s</div>
	                <div class="year">%5$s</div>
	            </div>
            	<a href="%1$s" class="link" >%2$s</a>
            </div>',
			esc_url(cosmos_get_link_url()),
			get_the_post_thumbnail( get_the_ID(), 'post-thumbnail', array('class' => 'img-responsive post-thumb-img') ),
			esc_html($day),
			esc_html($month),
			esc_html($year)
	);
}