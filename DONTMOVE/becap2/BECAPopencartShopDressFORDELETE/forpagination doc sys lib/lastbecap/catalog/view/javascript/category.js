$(document).ready(function($){
	$(".buttonFilters").click(function () {
		var filterId = $(this).attr("filter-id");
		if(!$("#"+filterId).hasClass("activeFilter")) {
			$(".activeFilter").removeClass("activeFilter");
			$("#"+filterId).addClass("activeFilter")
		} else
			$(".activeFilter").removeClass("activeFilter");
	});

	/*$( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 500,
      values: [ 100, 300 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( ui.values[ 0 ] + " руб. - " + ui.values[ 1 ] + " руб.");
      }
    });*/

  	
});