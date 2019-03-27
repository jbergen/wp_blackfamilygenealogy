<?php get_header() ?>
<?php the_post() ?>

<div class='span16 single-content'>
	<h1><?php the_title(); ?></h1>
	<div class='row'>
		
		<div class="col-8 readable">
			<?php the_content() ?>
		</div>

		<div class="col-4 sidebar">
			<?php get_sidebar() ?>
		</div>
		
	</div>
</div><!-- .row -->

<?php get_footer() ?>
