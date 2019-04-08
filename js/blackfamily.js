$(document).ready(function(){
	$('.post-select').change(function(){
		window.location = $(this).val();
	});
});


document.addEventListener('DOMContentLoaded', function() {
	var featuredBox = document.getElementById("featured-box");
	if (featuredBox) {
		var flkty = new Flickity('#featured-box', {
			autoPlay: 5000,
			pauseAutoPlayOnHover: true,
			wrapAround: true,
		});
	}

	var siteSlideshow = document.getElementById("site-slideshow");
	if (siteSlideshow) {
		var smallSlides = new Flickity('#site-slideshow', {
			autoPlay: 2500,
			pauseAutoPlayOnHover: false,
			wrapAround: true,
			pageDots: false,
		});
	}
}, false);
