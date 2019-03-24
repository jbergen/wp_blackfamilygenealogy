<?php
/*
Template Name: Home
*/
?>

<?php get_header() ?>

	<div id="single-container">
		<div class="content">
		
			<?php the_post();$page_content = get_the_content() ?>
			
			<div id="featured-box" class='span16'>
			
				<?php
				//$post_images = make_timthumb_image_array();
					$image_names = array('0.jpg','1.jpg','2.jpg');
					shuffle($image_names);
				?>
				
				<?php rewind_posts(); ?>
			  
				<?php query_posts($query_string . '&cat=119'); ?>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					
					<div class="post-slide" style='background-image:url("<?php echo bloginfo('url') ?>/wp-content/timthumb/timthumb.php?h=400&w=940&zc=1&src=<?php echo bloginfo('template_directory') ?>/images/headers/<?php echo $image_names[0] ?>")'>
						<?php
							$temp = array_shift( $image_names );
							array_push($image_names,$temp);
						?>
						<a class='overlay-link' href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
								<div class='content'>
								<h2><?php the_title() ?></h2>
								<h5><?php the_excerpt() ?></h5>
								</div>
						</a>
				
					</div><!-- post-slide -->
			 		<?php endwhile; else: ?>
					<?php endif; ?>
				
				<!-- featured/sticky posts go in slideshow here -->
			</div>
			
			<div class='row'>
				<ul id="featured-nav" class='unstyled span16'></ul>
			</div>
			
				
				
				<!--
				<a href='#' class='left'>previous</a>
				<a href='#' class='right'>next</a>
				-->
				
		
			<div id='front-page-cols' class='row'>
				<div id="front-page-content" class='span-one-third'>
					<h3>Welcome!</h3>
					<?php echo $page_content ?>
					

				</div>
			
				<div class='span-one-third'>
					
					<h3>Updates</h3>
					<?php
						$args = array( 'post_type' => 'bfg-update', 'posts_per_page' => 1 );
						$loop = new WP_Query( $args );
						while ( $loop->have_posts() ) : $loop->the_post();
							echo '<h4><a href="'. get_permalink() .'">'. get_the_title() .'</a></h4>';
							echo '<div class="entry-content">'. the_content() .'</div>';
						endwhile;
					?>
					
				</div>
				
				<div class='span-one-third'>
					<div id='site-slideshow' class='clearfix'>
						<?php
							//get images from the 'slideshow' page which is hidden by default
							$ssimages = make_timthumb_image_array(1582);

							foreach($ssimages as $image) {
								echo "<img class='thumbnail' src='".$image->timthumb."' width='300'/>";
							}
							
						?>
					</div>
				</div>
			</div>
			
		</div><!-- content -->
				
		
<?php get_footer() ?>