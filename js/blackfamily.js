$(document).ready(function(){
	
	if( $('#featured-box').length )
	{
		$('#featured-box').cycle({ 
			fx:     'scrollHorz', 
			prev:   '.left', 
			next:   '.right', 
			timeout: 10000,
			pause:true,
		 	pager: '#featured-nav',
			pagerAnchorBuilder: function(idx,slide){
				return '<li><a href="#">&bull;</a></li>'
			}
		});
	}
	
	if( $('#site-slideshow').length )
	{
		$('#site-slideshow').cycle({  
		    timeout: 5000,
			pause:true
		});
	}

	$('.post-select').change(function(){
		window.location = $(this).val();
	});
	
	
	
	
	
});