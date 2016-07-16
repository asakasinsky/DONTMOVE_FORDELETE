function modalImage(){
    $(".answerServer").html("");
    $("html").addClass("htmlModal");
    $(".backgroundModal, .modalImage").removeClass("hide");
    var left = ($(window).width() - widthModal)/2+"px";
    var top = ($(window).height() - heightModal)/2+"px";
    $(".modalImage").css({
        "top":top,
        "left":left
    });

    $(window).resize(function () {
    	var left = ($(window).width() - widthModal)/2+"px";
	    var top = ($(window).height() - heightModal)/2+"px";
	    $(".modalImage").css({
	        "top":top,
	        "left":left
	    });
    });
    
}
function showImage(orderImage) {
	$(".activeImage420").removeClass("activeImage420");
	$(".modalImage img[order-image='"+orderImage+"']").addClass("activeImage420");
}
function nextImage() {
	var active = parseInt($(".modalImage img.activeImage420").attr("order-image"));

	if(active < countModalImg)
		showImage(active+1);
	else
		showImage(1);
}
function prevImage() {
	var active = parseInt($(".modalImage img.activeImage420").attr("order-image"));
	if(active <= countModalImg && active > 1)
		showImage(active-1);
	else
		showImage(countModalImg);
}
$(document).ready(function($){
	$(".tabs span").click(function () {
		var orderTab = $(this).attr("order-tab");
		$(".selectedTab").removeClass("selectedTab");
		$(this).addClass("selectedTab");
		$(".activeText").removeClass("activeText");
		$(".textProduct[order-text='"+orderTab+"']").addClass("activeText");
	});

	$(".leftFotos60 img").click(function () {
		var nameImage = $(this).attr("name-image");
		$(".activeImage60").removeClass("activeImage60");
		$(this).addClass("activeImage60");
		$(".activeImageGallery").attr("src", nameImage).attr("name-image", nameImage);
	});

        $(".leftFotos60 img").mouseenter(function () {
		var nameImage = $(this).attr("name-image");
		$(".activeImage60").removeClass("activeImage60");
		$(this).addClass("activeImage60");
		$(".activeImageGallery").attr("src", nameImage).attr("name-image", nameImage);
	});

	$(".activeImageGallery").click(function () {
		$(".activeImage420").removeClass("activeImage420");
		var nameImage = $(this).attr("name-image");
		$(".modalImage img[name-image='"+nameImage+"']").addClass("activeImage420");
		modalImage();
	});
        
        $(window).keydown(function(btn){
            if(btn.keyCode == 27) closeModal();
            else if (btn.keyCode == 37) {
                    prevImage();
            }
            else if (btn.keyCode == 39) {
                    nextImage();
            }
        });

        countModalImg = $(".modalImage img").length;
	$(".rightImage").click(nextImage);
	$(".leftImage").click(prevImage);
});