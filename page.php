<?php get_header() ?>	
<?php the_post() ?>

<div class='span16'>
	<h1><?php the_title(); ?></h1>

	<div class='row'>

		<div class="span-two-thirds">
			<?php the_content() ?>
		</div><!--.entry-content-->
	
		<div class="span-one-third">
			<?php get_sidebar() ?>
		</div>
		
	</div> <!-- .row -->
	
</div>

<?php get_footer() ?>