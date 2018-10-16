<?php
/**
 * The template for displaying archive pages.
 * 
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
if( cosmos_is_custom_post_type_archive() == 3 && has_action('cosmos_show_team_archive') ) {
	do_action('cosmos_show_team_archive');
} else {
	do_action('cosmos_show_index');
}