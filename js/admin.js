var defaultLat = 42.376;
var defaultLng = -71.1135;

jQuery(document).ready(function(){	
	
	var dateOptions = {
		changeMonth: true,
		changeYear: true,
		yearRange: "1000:2020",
		dateFormat: 'yy-mm-dd'
	};
	
	jQuery( "#date_born" ).datepicker( dateOptions );
	jQuery( "#date_died" ).datepicker( dateOptions );
	
	jQuery(".clear-map").click(function(){
		var id = jQuery(this).parent().attr('id');
		resetMap(id);
		return false;
	});
	    
	
	//movable markers map

	jQuery(".geocode-input").focusout(function(){
		codeAddress(this);
	});
	
	//don't load the map if there's nowhere to put it!
	//if( jQuery('#location_born_map').length > 0) initializeMap();
	jQuery('.map-canvas').each(function(){
		initializeMap(this);
	})

});

var maps = {};

function initializeMap(mapDom)
{
	var mapName = jQuery(mapDom).parent().attr('id');
	console.log(mapName)
	//var existingLocation = jQuery("#location").val();
	var lat = jQuery("#lat_"+mapName).val();
	var lng = jQuery("#lng_"+mapName).val();
	
	console.log(lat+':'+lng)
	
	var zoomWindow = 12;

	var temp = parseInt( jQuery("#zoom").attr("value")) ;
	if(temp > 0) zoomWindow = temp;

	//console.log(zoomWindow);
	if(lat == "" || lng == ""||lat == undefined || lng == undefined)
	{
		lat = defaultLat;
		lng = defaultLng;
	}

	var latLng = new google.maps.LatLng(lat, lng);
  
	//var map = new google.maps.Map(document.getElementById('map_canvas'), {
	var map = new google.maps.Map(mapDom, {
		zoom: zoomWindow,
		center: latLng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	var marker = new google.maps.Marker({
		position: latLng,
		title: 'your point',
		map: map,
		draggable: true
	});
	
	google.maps.event.addListener(map, 'zoom_changed', function() {
		onZoomChanged( mapName );
	    geocodePosition(marker.getPosition() , mapName);
		updateMarkerPosition(marker.getPosition(), mapName);
	});


	google.maps.event.addListener(marker, 'dragend', function() {
	    geocodePosition(marker.getPosition(), mapName);
		updateMarkerPosition(marker.getPosition(), mapName);
	});
	
	var mapObject = {
		'map':map,
		'marker':marker
	}
	
	maps[mapName] = mapObject;
	
}

function codeAddress(input)
{
    var address = jQuery(input).val();

	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK)
		{
			var id = jQuery(input).parent().attr('id');
			maps[id].map.setCenter(results[0].geometry.location);

			maps[id].marker.position = results[0].geometry.location;

			updateMarkerPosition(results[0].geometry.location , id);
			geocodePosition(results[0].geometry.location, id);


			geocodePosition(results[0].geometry.location , id);
			updateMarkerPosition(results[0].geometry.location , id);

		} else {
			alert("Geocode was not successful for the following reason: " + status);
		}
	});
}

function onZoomChanged( id )
{
	jQuery("#zoom_"+id).attr("value",maps[id].map.getZoom());
}

var geocoder = new google.maps.Geocoder();

function geocodePosition( pos , id )
{
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
	
		//buckets to determine how precise you want to look up the place
		//responses[n] n=1-7 specific-general
		//map.getZoom() 18-0 specific-general
		var zoom = maps[id].map.getZoom();
		//console.log(zoom);
		var r = 1;
		if(zoom < 16 && zoom >= 14) r = 2;
		else if(zoom <= 13 && zoom >= 11) r = 3;
		else if(zoom <= 10) r = 4;
		
      updateMarkerAddress(responses[r].formatted_address, id);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}


function updateMarkerPosition(latLng, id)
{
	jQuery("#lat_"+id).val( [ Math.round(latLng.lat()*10000)/10000 ]);
	jQuery("#lng_"+id).val( [ Math.round(latLng.lng()*10000)/10000 ]);
}

function updateMarkerAddress(str,id)
{
	console.log(str+':'+id);
	jQuery("#"+id).find('.geocode-input').val( str );
}

function resetMap(id)
{
	jQuery('#'+id).find('.geocode-input').val('');
	var latlng = new google.maps.LatLng(defaultLat, defaultLng);
	console.log(latlng)
	console.log(maps)
	maps[id].map.setCenter(latlng);
	maps[id].marker.position = latlng;
	
	
	//jQuery("#lat_"+id).val( );
	//jQuery("#lng_"+id).val( );
}
