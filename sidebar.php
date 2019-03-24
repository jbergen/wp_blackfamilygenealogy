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

<?php if($bornLoc || $diedLoc): ?>
	<?php
		echo "<img class='side-map' src='http://maps.googleapis.com/maps/api/staticmap?size=300x300&maptype=roadmap&";
		if($bornLoc) echo "markers=color:green|label:B|". $bornLat .",". $bornLng ."&";
		if($diedLoc) echo "markers=color:red|label:D|". $diedLat .",". $diedLng ."&";
		if( $bornLoc && !$diedLoc || !$bornLoc && $diedLoc ) echo "zoom=6&";
		echo "sensor=false'>";
	?>
<?php endif ?>

<?php

	echo "<ul class='unstyled'>";

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
	echo "</ul>";

?>

<?php
	$gedLink = get_post_meta($post->ID, "ged_link_value", true);
	if($gedLink) echo "<a class='btn success large'  href='". $gedLink ."' target='blank' >See Family Detail</a>";
?>

<?php
	echo "</br></br>";
	$fsURL = get_post_meta($post->ID, "familysearch_url_value", true);
	if($fsURL) echo "<a class='btn success large'  href='". $fsURL ."' target='blank' >See FamilySearch Tree</a>";
?>

<?php
	$post_ID = get_the_ID(); 
	if ( $last_id = get_post_meta($post_ID, '_edit_last', true) )
	{
		echo "</br></br>";
		$last_user = get_userdata($last_id);
		printf(__('last edited by %1$s on %2$s'), wp_specialchars( $last_user->display_name ), mysql2date(get_option('date_format'), $post->post_modified), mysql2date(get_option('time_format'), $post->post_modified));
	};
?>
<br />
<br />
<?php edit_post_link('edit this record', '<p>', '</p>'); ?>
                                                                                                              