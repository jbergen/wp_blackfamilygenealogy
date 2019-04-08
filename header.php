<?php

/*
filename: header.php
description: This partial is called by <?php get_header(); ?>
Contains all the header information and any part of the website that you 
want to remain constant at the top of the page.
*/
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ) ?></title>
		<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
		
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory') ?>/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory') ?>/css/flickity.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" />
		
	<?php wp_head() // For plugins ?>
		<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="Latest Posts" />
		<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="<?php bloginfo('home') ?>/" title="<?php echo wp_specialchars( get_bloginfo('name'), 1 ) ?>" rel="home"><?php bloginfo('name') ?></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<?php if (function_exists(clean_custom_menus())) clean_custom_menus(); ?>
				<form class='form-inline my-2 my-lg-0 ml-auto' method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
					<input class="form-control mr-sm-2" type="text" placeholder='search' name="s" id="search-box" />
					<input class="btn btn-outline-success my-2 my-sm-0" type="submit" id="searchsubmit" value="Go"/>
				</form>
			</div>
		</nav>

		<div class="container">		
			