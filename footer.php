	</div><!-- #container  -->

		<?php wp_footer(); //keep this for plugins ?>
		<div id="footer-wrapper">
			<div class='container'>
				
				<div class='row'>
					<div class='span-one-third'>
						
						<h4>Recently Updated</h4>
						<?php hh_recently_updated_posts() ?>
							
						<h4>Admin</h4>
						<?php if (is_user_logged_in()):?>
							<a href="<?php bloginfo('home') ?>/wp-admin/">dashboard</a> / <a href="<?php echo wp_logout_url(); ?>" title="logout">logout</a>
					    <?php else: ?>
							<a href="<?php echo wp_login_url(); ?>" title="Login">login</a>
						<?php endif ?>
						
					</div>

					<div class='span-one-third'>
						<h3>tags</h3>
						<ul class='unstyled'>
						<?php
						//see: http://codex.wordpress.org/Function_Reference/wp_tag_cloud
						$args = array(
						    'smallest'                  => 12, 
						    'largest'                   => 12,
						    'unit'                      => 'pt', 
						    'number'                    => 0,  
						    'format'                    => 'flat',
						    'orderby'                   => 'name', 
						    'order'                     => 'ASC',
						    'exclude'                   => null, 
						    'include'                   => null, 
						    'topic_count_text_callback' => default_topic_count_text,
						    'link'                      => 'view', 
						    'taxonomy'                  => 'post_tag', 
						    'echo'                      => true ); 
						wp_tag_cloud( $args ); 
						?> 
						</ul>
					</div>

					<div class='span-one-third'>



						<h4>Ancestral Families</h4>
						<ul class=''>
							<?php wp_list_categories('child_of=124&title_li='); ?>
						</ul>
						<h4>Nobility Lines</h4>
						<ul class=''>
							<?php wp_list_categories('child_of=123&title_li='); ?>
						</ul>
						<h4>William Y Black Family</h4>
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
						
					</div>
				</div>
				
				
				Theme created by <a href="http://www.josephbergen.com" target="blank">Joseph Bergen</a>
			</div>
		</div><!-- #footer -->

	</body>
</html>