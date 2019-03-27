<?php get_header() ?>	
<?php the_post() ?>

<div class='span16'>
	<h1><?php the_title(); ?></h1>
	<div class='row'>
		<div class="col-8">
			<?php the_content() ?>
		</div><!--.entry-content-->
	
		<div class="col-4">
			<?php get_sidebar() ?>
		</div>
		
	</div> <!-- .row -->
	
</div>

<?php get_footer() ?>