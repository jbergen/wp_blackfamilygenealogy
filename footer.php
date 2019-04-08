	</div><!-- #container  -->

		<?php wp_footer(); //keep this for plugins ?>
		<div id="footer-wrapper">
			<div class='container'>
				
				<div class='row'>
					<div class='col-sm'>
						<?php if ( is_active_sidebar( 'footer-left' ) ) : ?>
							<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
								<?php dynamic_sidebar( 'footer-left' ); ?>
							</div><!-- #primary-sidebar -->
						<?php endif; ?>
					</div>

					<div class='col-sm'>
						<?php if ( is_active_sidebar( 'footer-center' ) ) : ?>
							<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
								<?php dynamic_sidebar( 'footer-center' ); ?>
							</div><!-- #primary-sidebar -->
						<?php endif; ?>
					</div>

					<div class='col-sm'>
						<h2 class="footer-title">Ancestral Families</h2>
						<ul class=''>
							<?php wp_list_categories('child_of=124&title_li='); ?>
						</ul>
						<h2 class="footer-title">Nobility Lines</h2>
						<ul class=''>
							<?php wp_list_categories('child_of=123&title_li='); ?>
						</ul>
						<h2 class="footer-title">William Y Black Family</h2>
						<ul class=''>
							<?php wp_list_categories('child_of=125&title_li='); ?>
						</ul>
						
						
						<select class='post-select'>
							<option value='0'>Family Member</option>
							<?php rewind_posts(); ?>

							<?php

								// The Query
								$args = array(
									'cat' => '-126',
									'orderby' => 'meta_value title',
									'order' => 'ASC',
									'meta_key' => 'surname_value',
									'nopaging' => 'true'
								);
								
								$the_query = new WP_Query( $args );
								// The Loop
								while ( $the_query->have_posts() ) : $the_query->the_post();
								
									$surname = get_post_meta($post->ID, 'surname_value', true);
									$givenname = get_post_meta($post->ID, 'given_name_value', true);
									
									echo '<option value="'. get_permalink() .'">'. $surname .', '. $givenname . '</option>';
								endwhile;

								// Reset Post Data
								wp_reset_postdata();

							?>

							<?php rewind_posts(); ?>
						</select>
						
						<?php if ( is_active_sidebar( 'footer-right' ) ) : ?>
							<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
								<?php dynamic_sidebar( 'footer-right' ); ?>
							</div><!-- #primary-sidebar -->
						<?php endif; ?>
					</div>
				</div>
				
				
				Theme created by <a href="https://www.josephbergen.com" target="blank">Joseph Bergen</a>
			</div>
		</div><!-- #footer -->

	</body>
</html>