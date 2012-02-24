/* Author: Grzenio

*/




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

