<?php
/*
filename: 404.php
description: Displayed when an invalid url is accessed
*/
?>

<?php get_header() ?>
<div class='span16 readable'>
	<h1>Not Found :(</h1>
	
	<div class="alert-message error">
		<strong>Apologies, but we were unable to find what you were looking for.</strong>
	</div>
	<a href='<?php bloginfo('url') ?>'>
		<img class='span-one-third' src='http://blog.blackfamilygenealogy.org/wp-content/uploads/2010/12/Top-11-669x1024.jpg'>
	</a>
</div><!-- .row -->

<?php get_footer() ?>