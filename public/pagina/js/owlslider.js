jQuery(document).ready(function($) {

	var owl = $("#owl-demo-2");
  owl.owlCarousel({
      items : 4, 
      itemsDesktop : [992,4],
      itemsDesktopSmall : [768,2], 
      itemsTablet: [480,2], 
      itemsMobile : [320,1]
  });
  $(".next").click(function(){ owl.trigger('owl.next'); });
  $(".prev").click(function(){ owl.trigger('owl.prev'); });

$('.latest-blog-posts .thumbnail.item').matchHeight();
	
});