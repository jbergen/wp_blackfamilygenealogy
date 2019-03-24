<?php get_header() ?>
<?php

	if(is_search()){
		echo '<div id="page-title">';
		echo '<h2>Search: '.get_search_query().'</h2>';
		echo '</div>';
	}elseif(is_category()){
		echo '<div id="page-title">';
		echo '<h2>Category: '.single_cat_title( '', false ).'</h2>';
		echo '</div>';
	}elseif(is_tag()){
		echo '<div id="page-title">';
		echo '<h2>Tag: '.single_tag_title( '', false ).'</h2>';
		echo '</div>';
	}elseif(is_year()){
		ob_start(); // enable collecting into buffer
		the_date_xml(); // call the function and catch output into buffer
		$year = ob_get_cleans(); // read buffer
		ob_end_clean(); // end collecting into buffer and flush the buffer content
		$year = preg_replace('/-(.)*/','',$year);
		echo '<h2>Year: '. $year .'</h2>';
	}
?>

<div class="row">
	
	<div class='span16'>
		
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="post">
			
			<?php
				$bornDate = get_post_meta($post->ID, "date_born_value", true);
				$diedDate = get_post_meta($post->ID, "date_died_value", true);
				$bornLoc = get_post_meta($post->ID, "born_value", true);
				$diedLoc = get_post_meta($post->ID, "died_value", true);
				if( $bornLoc )
				{
					$bornLat = get_post_meta($post->ID, "lat_born_value", true);
					$bornLng = get_post_meta($post->ID, "lng_born_value", true);
				}
				if( $diedLoc )
				{
					$diedLat = get_post_meta($post->ID, "lat_died_value", true);
					$diedLng = get_post_meta($post->ID, "lng_died_value", true);
				}

			?>
						
			<h3><a href="<?php the_permalink(); ?>"></li><?php the_title();?></a></h3>
			<div>
				<div class="post-meta">
					posted on <?php echo get_the_date(); ?> by <?php the_author();?>
				</div>
				
				<div class="row">
					<div class="span-one-third">
						<blockquote><?php the_excerpt() ?></blockquote>
					</div>
					<div class="span-one-third">
						<?php if($bornLoc || $diedLoc): ?>
							<?php
								echo "<img class='side-map' src='http://maps.googleapis.com/maps/api/staticmap?size=300x150&maptype=roadmap&";
								if($bornLoc) echo "markers=color:green|label:B|". $bornLat .",". $bornLng ."&";
								if($diedLoc) echo "markers=color:red|label:D|". $diedLat .",". $diedLng ."&";
								if( ($bornLoc && !$diedLoc) || (!$bornLoc && $diedLoc) ) echo "zoom=6&";
								echo "sensor=false'>";
							?>
						<?php endif ?>

					</div>
					<div class="span-one-third">
						<ul class='unstyled'>
						<?php
							if($bornDate)
							{

								$born_date = DateTime::createFromFormat('Y-m-d', $bornDate);
								$born_wiki_year = '<a target="blank" title="'. $born_date->format('Y') .' on Wikipedia" href="http://en.wikipedia.org/wiki/'. $born_date->format('Y') .'">'. $born_date->format('Y') .'</a>';
								$born_wiki_day = '<a target="blank" title="'. $born_date->format('j F') .' on Wikipedia" href="http://en.wikipedia.org/wiki/'. $born_date->format('j_F') .'">'. $born_date->format('j M') .'</a>';
							}
							if($diedDate)
							{
								$died_date = DateTime::createFromFormat('Y-m-d', $diedDate);
								$died_wiki_year = '<a target="blank" title="'. $died_date->format('Y') .' on Wikipedia" href="http://en.wikipedia.org/wiki/'. $died_date->format('Y') .'">'. $died_date->format('Y') .'</a>';
								$died_wiki_day = '<a target="blank" title="'. $died_date->format('j F') .' on Wikipedia" href="http://en.wikipedia.org/wiki/'. $died_date->format('j_F') .'">'. $died_date->format('j M') .'</a>';
							}

							if( $bornDate || $bornLoc ) echo "<li><span class='label success'>born</span> ". $bornLoc ." ". $born_wiki_day ." ". $born_wiki_year ."</li>"; 
							if( $diedDate || $diedLoc ) echo "<li><span class='label important'>died</span> ". $diedLoc ." ". $died_wiki_day ." ". $died_wiki_year ."</li>";
						?>
						</ul>
					</div>
					
				</div>
				
				
			</div>
		</div><!-- .post -->

	<?php endwhile; endif; ?>
	
	</div><!-- .span-two-thirds -->
	<!--
	<div class="span-one-third">
		<?php get_sidebar() ?>
	</div>
	-->
</div><!-- .row -->
<?php get_footer() ?>