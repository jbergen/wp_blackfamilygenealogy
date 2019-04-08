<?php 
	$bornDate = get_post_meta($post->ID, "date_born_value", true);
	$diedDate = get_post_meta($post->ID, "date_died_value", true);
	$bornLoc = get_post_meta($post->ID, "born_value", true);
	$diedLoc = get_post_meta($post->ID, "died_value", true);
	if ($bornLoc) {
		$bornLat = get_post_meta($post->ID, "lat_born_value", true);
		$bornLng = get_post_meta($post->ID, "lng_born_value", true);
	}
	if ($diedLoc) {
		$diedLat = get_post_meta($post->ID, "lat_died_value", true);
		$diedLng = get_post_meta($post->ID, "lng_died_value", true);
	}
	
?>

<div class="sidebar-entry">
	<ul class='list-unstyled'>
		<?php
			if($bornDate) {
				$born_date = DateTime::createFromFormat('Y-m-d', $bornDate);
				$born_wiki_year = '<a target="blank" title="'. $born_date->format('Y') .' on Wikipedia" href="http://en.wikipedia.org/wiki/'. $born_date->format('Y') .'">'. $born_date->format('Y') .'</a>';
				$born_wiki_day = '<a target="blank" title="'. $born_date->format('j F') .' on Wikipedia" href="http://en.wikipedia.org/wiki/'. $born_date->format('j_F') .'">'. $born_date->format('j M') .'</a>';
			}
			if($diedDate) {
				$died_date = DateTime::createFromFormat('Y-m-d', $diedDate);
				$died_wiki_year = '<a target="blank" title="'. $died_date->format('Y') .' on Wikipedia" href="http://en.wikipedia.org/wiki/'. $died_date->format('Y') .'">'. $died_date->format('Y') .'</a>';
				$died_wiki_day = '<a target="blank" title="'. $died_date->format('j F') .' on Wikipedia" href="http://en.wikipedia.org/wiki/'. $died_date->format('j_F') .'">'. $died_date->format('j M') .'</a>';
			}

			$mapToken = 'pk.eyJ1IjoiamJlcmdlbiIsImEiOiJjanRxb3d1NWgwaHBuM3lvMzJ3emtyNWY4In0.xCCZGVjZrBAKn5C_O6q8CA';
			if ($bornLoc) {
				$bornMapURL = 'https://api.mapbox.com/v4/mapbox.emerald/pin-l-b+008f00(' . $bornLng . ',' . $bornLat . ')/' . $bornLng . ',' . $bornLat . ',12/300x200@2x.png?access_token=' . $mapToken;
				echo '<img src="' . $bornMapURL . '" height="200" width="300"/>';
			}
			if ( $bornDate || $bornLoc ) {
				echo "<li><span class='badge badge-success'>born</span> ". $bornLoc ." ". $born_wiki_day ." ". $born_wiki_year ."</li>"; 
				echo "</br>";
			}

			if ($diedLoc) {
				$diedMapURL = 'https://api.mapbox.com/v4/mapbox.emerald/pin-l-d+dc3545(' . $diedLng . ',' . $diedLat . ')/' . $diedLng . ',' . $diedLat . ',12/300x200@2x.png?access_token=' . $mapToken;
				echo '<img src="' . $diedMapURL . '" height="200" width="300"/>';
			}
			if ( $diedDate || $diedLoc ) {
				echo "<li><span class='badge badge-danger'>died</span> ". $diedLoc ." ". $died_wiki_day ." ". $died_wiki_year ."</li>"; 
			}
		?>
	</ul>
</div>

<?php
	$gedLink = get_post_meta($post->ID, "ged_link_value", true);
	if($gedLink) {
		echo "<div class='sidebar-entry'>";
		echo "<a class='btn btn-success btn-lg' href='". $gedLink ."' target='blank' >See Family Detail</a>";
		echo "</div>";
	}
?>

<?php
	$fsURL = get_post_meta($post->ID, "familysearch_url_value", true);
	if($fsURL) {
		echo "<div class='sidebar-entry'>";
		echo "<a class='btn btn-success btn-lg' href='". $fsURL ."' target='blank' >See FamilySearch Tree</a>";
		echo "</div>";
	}
?>

<?php
	$post_ID = get_the_ID(); 
	if ( $last_id = get_post_meta($post_ID, '_edit_last', true) ) {
		echo '<div class="sidebar-entry">';
		$last_user = get_userdata($last_id);
		printf(__('last edited by %1$s on %2$s'), wp_specialchars( $last_user->display_name ), mysql2date(get_option('date_format'), $post->post_modified), mysql2date(get_option('time_format'), $post->post_modified));
		echo "</div>";
	};
?>

<div class="sidebar-entry">
	<?php edit_post_link('edit this record', '<p>', '</p>'); ?>
</div>
