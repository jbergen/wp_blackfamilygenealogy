<?php
/*
Template Name: Map
*/
?>
	
<?php get_header() ?>

<div id='loading-bar' class="alert-message warning" style='position:absolute;width:908px;z-index:1000;opacity:0.95'>
	<strong>loading…</strong>
</div>

<div id='map-wrap'>
<div id="big-map">
</div>
</div>

<script type="text/javascript" language="Javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDmBSTthgVOcDGME2lS3Bjm4Fk5ItecKuQ&sensor=false"></script>
<script type="text/javascript" language="Javascript" src="<?php bloginfo('template_directory') ?>/js/underscore.js"></script>
<script type="text/javascript" language="Javascript" >

var posts = [];
var page = 0;

	$(document).ready(function(){
		
		
		var zoomWindow = 4;
		
		var latLng = new google.maps.LatLng(39.828, -98.5795);

		var map = new google.maps.Map(document.getElementById('big-map'), {
			zoom: zoomWindow,
			center: latLng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		
		loadPages( map );

	});
	
	function loadPages( map )
	{
		console.log('loading page: '+page)
		$.ajax({
			url:'../?json=get_recents_posts&custom_fields=lat_born_value,lng_born_value,lat_died_value,lng_died_value&count=1000',
			success:function(data)
			{
				console.log('loaded page: '+ page);
				$('#loading-bar').fadeOut();
				
				posts = getPostsWithGeoData(data.posts);
				addMarkers(posts, map);
				if( page+1 < data.pages )
				{
					page++;
					loadPages( map );
				}
			}
		})
	}
	
	function addMarkers( posts, map )
	{
		_.each(posts, function(post){
			if(post.custom_fields.lat_born_value)
			{
				var bll = new google.maps.LatLng(post.custom_fields.lat_born_value[0], post.custom_fields.lng_born_value[0]);
				var b = new google.maps.Marker({
					position: bll,
					title: 'your point',
					map: map,
					draggable: false
				});
				
				var bornInfo = new google.maps.InfoWindow({
				    content: '<a href="'+ post.url +'">'+ post.title +' born</a>'
				});
				
				google.maps.event.addListener(b, 'click', function() {
					bornInfo.open(map,b);
				});
				
			}
			if(post.custom_fields.lat_died_value)
			{
				var dll = new google.maps.LatLng(post.custom_fields.lat_died_value[0], post.custom_fields.lng_died_value[0]);
				var d = new google.maps.Marker({
					position: dll,
					title: 'your point',
					map: map,
					draggable: false
				});
				var diedInfo = new google.maps.InfoWindow({
				    content: '<a href="'+ post.url +'">'+ post.title +' died</a>'
				});
				
				google.maps.event.addListener(d, 'click', function() {
					diedInfo.open(map,d);
				});
			}
		})
	}
	
	function getPostsWithGeoData( posts )
	{
		var filtered = _.filter(posts, function(post){
			if( !_.isEmpty(post.custom_fields) ) return post;
		})
		return filtered;
	}

</script>
		
<?php get_footer() ?>