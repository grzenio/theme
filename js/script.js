/* Author: Grzenio

*/

Modernizr.load([
	{
    // Let's see if we need to load selectivizr
    test : Modernizr.borderradius,
    // Modernizr.load loads selectivizr and Respond.js for IE6-8
    nope : ['libs/selectivizr-min.js'],
	nope : ['libs/respond-min.js']
	}
]);


$(document).ready( function() {


    $(function() {
      if ($.browser.msie && $.browser.version.substr(0,1)<7)
      {
        $('li').has('ul').mouseover(function(){
            $(this).children('ul').css('visibility','visible');
            }).mouseout(function(){
            $(this).children('ul').css('visibility','hidden');
            })
      }
    });  
	
	
	if($('.flexslider').length) {
		//$('.flexslider').flexslider();
			$('.flexslider').flexslider({
				animation: "slide",
				//controlsContainer: ".flex-container"
			});
		}
	
});

