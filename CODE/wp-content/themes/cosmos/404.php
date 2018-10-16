<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
$cosmos_404_title		= Cosmos::get_option('pix-404-title');
$cosmos_404_desc     	= Cosmos::get_option('pix-404-desc');
$cosmos_404_color     	= Cosmos::get_option('pix-text-404-color');

?>

<?php get_header(); ?>
<section class="row-builder section_page404 style-1" data-type="bg">
    <div class="container">
        <div class="wrap pd-t90 pd-b90">
            <div class="not-found">
                <span data-type="title"><?php echo esc_html__('Page Not Found !', 'cosmos'); ?></span>
            </div>
            <div class="error-404">
                <span data-type="title"><?php echo esc_html__('404', 'cosmos'); ?></span>
            </div>
            <?php if(!empty($cosmos_404_title)){?>
            <div class="sorry">
                <span data-type="title"><?php echo esc_attr($cosmos_404_title) ?></span>
            </div>
            <?php } if (!empty($cosmos_404_desc)) { ?>
            <div class="link-error">
                <span data-type="content"><?php echo esc_attr($cosmos_404_desc) ?></span>
            </div>
            <?php } ?>
            <div class="search">
                <?php get_search_form(true);?>
            </div>
        </div>
    </div>
</section>
<?php 
$cosmos_custom_css = '';
if(!empty($cosmos_404_color)){
	$cosmos_custom_css .= '.section_page404.style-1 .not-found {color:'.esc_attr($cosmos_404_color).'}';
	$cosmos_custom_css .= '.section_page404.style-1 .error-404 {color:'.esc_attr($cosmos_404_color).'}';

	do_action( 'cosmos_add_inline_style', $cosmos_custom_css );
}
get_footer(); ?>