				<div class="footer">
					<div class="copyright">
						<?php $copy_rights = cafelite_get_option( 'footer_copyright', 'cafelite' ); ?>
                        <?php if ($copy_rights==null) {?>
                        <?php echo esc_html('Copyright', 'cafelite');?>	
                        <?php echo esc_html('&copy;', 'cafelite');?>
                        <?php echo esc_html( date_i18n( __( 'Y', 'cafelite' ) ) ); ?> 
                        <?php echo esc_html( get_bloginfo( 'name' ) ); ?>

                        <?php } else {?>
                        <?php echo esc_html('Copyright', 'cafelite');?>
                    	<?php echo esc_html('&copy;', 'cafelite');?>
                        <?php echo esc_html( date_i18n( __( 'Y', 'cafelite' ) ) ); ?> 
                        <?php echo esc_attr( $copy_rights ); ?>
                        <?php }?>

                        <?php echo esc_html('- Theme by ', 'cafelite');?>
                        <a href="#"><?php echo esc_html('Themeskanon', 'cafelite');?></a> 
					</div>	
				</div>
			</div>	

		</div>

		<?php wp_footer(); ?>
	</div>	
	
	<!-- Don't forget analytics -->
	
</body>

</html>
