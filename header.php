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
		<title><?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ) ?></title>
		<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
		
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory') ?>/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" />
		
	<?php wp_head() // For plugins ?>
		<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="Latest Posts" />
		<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
		

	</head>
	<body>
		<div class="container">


			<div class="topbar-wrapper">
				<div class="topbar">
					<div class="topbar-inner">
						<div class="container">
							
							<h3>
								<a href="<?php bloginfo('home') ?>/" title="<?php echo wp_specialchars( get_bloginfo('name'), 1 ) ?>" rel="home"><?php bloginfo('name') ?></a>
							</h3>
							
							<ul id='nav'>
								<?php wp_list_pages('exclude=914,1582&title_li=&sort_column=menu_order' ) ?>
							</ul>
						
							<form class='pull-right' method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
								<input type="text" size="14" placeholder='search' name="s" id="search-box" />
								<input type="submit" id="searchsubmit" value="Go" class="btn primary small" />
							</form>
						
						</div>

					</div>
				</div>

			</div>

	
			
			
			
			