<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the content div and all content after
 *
 * @author PIXArtThemes
 * @since 1.0
 */
?>
								</div>
								<!-- CONTENT-->
							</div>
							<!-- MAIN CONTENT-->
						</div>
						<!-- PAGE WRAPPER -->
					</div>
					<!-- WRAPPER CONTENT -->
			</div>
			<!-- PAGE-->
		</div>
		<!-- FOOTER-->
		<footer>
			<?php do_action('cosmos_show_footer');?>
			<?php if ( Cosmos::get_option('pix-backtotop') == '1') { ?>
			<div class="back-on-top"></div>
			<?php } ?>
		</footer>
		<!-- body wrapper -->
		<!-- End #page -->
		<?php wp_footer(); ?>
	</body>
</html>