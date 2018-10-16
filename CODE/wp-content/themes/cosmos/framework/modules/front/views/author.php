<?php
if(empty($author_id)) {
	$author_id = get_query_var('author');
}
$author_url = get_author_posts_url( $author_id );
$author_desc = get_the_author_meta( 'description', $author_id );
$param_social = Cosmos_Params::author_social_links();
if ( !empty($author_desc) ) {
?>
<div class="wrapper-author">
    <div class="blog-author media">
        <div class="media-left">
            <a href="<?php echo esc_url( $author_url )?>" class="author"><?php echo get_the_author_meta('display_name', $author_id); ?>
            </a>
            <p class="description"><?php echo nl2br( esc_textarea( $author_desc ) ) ?></p>
        </div>
        <div class="media-right">
            <a href="<?php echo esc_url( $author_url )?>" class="media-image"><?php echo get_avatar($author_id, 100); ?>
            </a>
            <?php if ( !empty($param_social) && is_array($param_social) ) {?>
            <div class="icons-social">
                <?php 
                foreach ($param_social as $key => $social) { 
                    $author_social = get_the_author_meta( $key, $author_id );
                    if ( !empty($author_social) ) {
                        printf('<a href="%2$s" title="%3$s"><i class="fa fa-%1$s social-icon" aria-hidden="true"></i> </a>', esc_attr($key), esc_url($author_social), esc_attr($social) );
                    }
                } ?>
            </div>
            <?php } ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<?php 
}
?>