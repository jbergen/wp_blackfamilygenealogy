<?php get_header() ?>
<?php the_post() ?>

<div class='span16 single-content'>
	<h1><?php the_title(); ?></h1>
	<div class='row'>
		
		<div class="span-two-thirds readable">
			<?php the_content() ?>
		</div>

		<div class="sidebar span-one-third">
			<?php get_sidebar() ?>
		</div>
		
	</div>
</div><!-- .row -->

<?php get_footer() ?>
