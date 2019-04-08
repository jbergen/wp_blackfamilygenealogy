<?php get_header() ?>
<?php the_post() ?>

<div class='container single-content'>
	<h1><?php the_title(); ?></h1>
	<div class='row'>
		
		<div class="col-sm-9 readable">
			<?php the_content() ?>
		</div>

		<div class="col-sm-3 sidebar">
			<?php get_sidebar() ?>
		</div>
		
	</div>
</div><!-- .row -->

<?php get_footer() ?>
