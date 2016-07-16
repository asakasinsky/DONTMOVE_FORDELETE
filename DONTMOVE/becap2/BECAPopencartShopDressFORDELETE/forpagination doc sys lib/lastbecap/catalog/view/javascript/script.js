var countFeeds, timeId, productCounts, activeImage, totalLikes, countProductModal, leftPxTotal;
function showFeedback(id) {
	$(".imagesPoints .active").removeClass("active");
	$(".feedback .activeFeed").removeClass("activeFeed");
	$("#point"+id).addClass("active");
	$("#f"+id).addClass("activeFeed");
}
function next() {
	var active = parseInt($(".imagesPoints .active").attr("id").substr(5));

	if(active < countFeeds)
		showFeedback(active+1);
	else
		showFeedback(1);
}
function prev() {
	var active = parseInt($(".imagesPoints .active").attr("id").substr(5));
	if(active <= countFeeds && active > 1)
		showFeedback(active-1);
	else
		showFeedback(countFeeds);
}
function showSlideProduct(orderProduct, activeImage) {
	$("div[order-product="+orderProduct+"] .imagesProduct .activeImageProduct").removeClass("activeImageProduct");
	$("div[order-product="+orderProduct+"] .imagesProduct [order-image="+activeImage+"]").addClass("activeImageProduct");
}
function nextProduct() {
	var activeProduct = parseInt($(".product.activeProduct").attr("order-product"));
	var activeImage = parseInt($(".product.activeProduct .imagesProduct .activeImageProduct").attr("order-image"));
	var countImages = parseInt($(".product.activeProduct .imagesProduct img").length);

	if(activeImage < countImages)
		showSlideProduct(activeProduct, activeImage+1);
	else
		showSlideProduct(activeProduct, 1);
}
function prevProduct() {
	var activeProduct = parseInt($(".product.activeProduct").attr("order-product"));
	var activeImage = parseInt($(".product.activeProduct .imagesProduct .activeImageProduct").attr("order-image"));
	var countImages = parseInt($(".product.activeProduct .imagesProduct img").length);

	if(activeImage <= countImages && activeImage > 1)
		showSlideProduct(activeProduct, activeImage-1);
	else
		showSlideProduct(activeProduct, countImages);
}
function closeModal(){
    $("html").removeClass("htmlModal");
    $(".activeFilter").removeClass("activeFilter");
    $(".modalWindow, .backgroundModal").addClass("hide");
}
function modalWindow(orderProd){
    $(".answerServer").html("");
    $("html").addClass("htmlModal");
    $(".backgroundModal, .modalWindow").removeClass("hide");
    var left = ($(window).width() - widthModal)/2+"px";
    var top = ($(window).height() - heightModal)/2+"px";
    $(".modalWindow").css({
        "top":top,
        "left":left
    });

    $(window).resize(function () {
    	var left = ($(window).width() - widthModal)/2+"px";
	    var top = ($(window).height() - heightModal)/2+"px";
	    $(".modalWindow").css({
	        "top":top,
	        "left":left
	    });
    });
    
    $(window).keydown(function(btn){
        if(btn.keyCode == 27) closeModal();
    });
}
function addToCart(orderProd) {
	var countBasket = parseInt($(".countBasket").html()) + 1;
	var newPrice = parseInt($(".product[order-product='"+orderProd+"'] .price price").html()) + parseInt($("#price > span").html());
	var imgSrc = $(".product[order-product='"+orderProd+"'] .imagesProduct img:nth-child(1)").attr("src");
	var priceProd = $(".product[order-product='"+orderProd+"'] .price").html();
	var titleProd = $(".product[order-product='"+orderProd+"'] .titleProduct").html();
	//var descProduct = $(".product[order-product='"+orderProd+"'] .descProduct").html();
	var sizeProd = $(".product[order-product='"+orderProd+"'] .sizesProduct .activeSize").html();
	$(".countBasket").html(countBasket);
	/*$("#price span").html(newPrice);*/
	$(".modalWindow img.imageBuyModal").attr("src", imgSrc);
	$(".priceModal p").html(priceProd);
        $(".priceModal").show();
        $(".titleModal").text("ТОВАР ДОБАВЛЕН В КОРЗИНУ");
	$(".titleProdModal span").html(titleProd);
	//$(".descProductModal").html(descProduct);
	if (sizeProd) $(".sizeProd").html("<span>Размер:</span> <size>" + sizeProd + "</size>");
	else $(".sizeProd").html("");
        
	modalWindow(orderProd);
}
function addToCartNoselect(orderProd, input) {
	var newPrice = parseInt($(".product[order-product='"+orderProd+"'] .price price").html());
	var imgSrc = $(".product[order-product='"+orderProd+"'] .imagesProduct img:nth-child(1)").attr("src");
	//var priceProd = $(".product[order-product='"+orderProd+"'] .price").html();
	var titleProd = $(".product[order-product='"+orderProd+"'] .titleProduct").html();
	//var descProduct = $(".product[order-product='"+orderProd+"'] .descProduct").html();
	var sizesProd = $(".product[order-product='"+orderProd+"'] .option").html();
	/*$("#price span").html(newPrice);*/
	$(".modalWindow img.imageBuyModal").attr("src", imgSrc);
	$(".priceModal").hide();
        $(".titleModal").text("ВЫ НЕ ВЫБРАЛИ РАЗМЕР");
	$(".titleProdModal span").html(titleProd);
	//$(".descProductModal").html(descProduct);
	if (sizesProd) {
            $(".sizeProd").html(sizesProd);
            $(".sizeProd").find("label").each(function(){
                $(this).attr("onclick", "selectAndAdd(" + orderProd + ", this);");
                //$(this).attr("onclick", "cart.addToCartOptions('" + orderProd + "', 1, getButton(" + orderProd + "));");
                var price = newPrice + parseInt($(this).data("addprice"));
                $(this).text($(this).text() + " - " + price + " руб.").after("<br/>").css("font-size", "20px");
            });
        }
	else $(".sizeProd").html("");
        
	modalWindow(orderProd);
}
function addToCartInproduct(orderProd) {
        var countBasket = parseInt($(".countBasket").html()) + 1;
        var newPrice = $("[order-product='"+orderProd+"'] .nowPrice").html();
	var imgSrc = $("[order-product='"+orderProd+"'] .activeImageGallery").attr("src");
	var titleProd = $("[order-product='"+orderProd+"'] h1").html();
	/*var descProduct = $("[order-product='"+orderProd+"'] [order-text=1]").html();*/
        var priceProd = $(".product[order-product='"+orderProd+"'] .price").html();
	var sizeProd = $(".product[order-product='"+orderProd+"'] .sizesProduct .activeSize").html();
	$(".countBasket").html(countBasket);
	$(".modalWindow img.imageBuyModal").attr("src", imgSrc);
	$(".priceModal p").html(newPrice);
        $(".priceModal").show();
        $(".titleModal").text("ТОВАР ДОБАВЛЕН В КОРЗИНУ");
	$(".titleProdModal span").html(titleProd);
	/*$(".descProductModal").html(descProduct);*/
	if (sizeProd) $(".sizeProd").html("<span>Размер:</span> <size>" + sizeProd + "</size>");
	else $(".sizeProd").html("");
        
	modalWindow(orderProd);
}
function addToCartNoselectInproduct(orderProd) {
	var newPrice = parseInt($("[order-product='"+orderProd+"'] .nowPrice").html());
	var imgSrc = $("[order-product='"+orderProd+"'] .activeImageGallery").attr("src");
	var titleProd = $("[order-product='"+orderProd+"'] h1").html();
	//var descProduct = $("[order-product='"+orderProd+"'] [order-text=1]").html();
	var sizesProd = $("[order-product='"+orderProd+"'] .option .required").html();
	/*$("#price span").html(newPrice);*/
	$(".modalWindow img.imageBuyModal").attr("src", imgSrc);
	$(".priceModal").hide();
        $(".titleModal").text("ВЫ НЕ ВЫБРАЛИ РАЗМЕР");
	$(".titleProdModal span").html(titleProd);
	//$(".descProductModal").html(descProduct);
	if (sizesProd) {
            $(".sizeProd").html(sizesProd);
            $(".sizeProd").find("label").each(function(){
                $(this).attr("onclick", "selectAndAdd(" + orderProd + ", this);");
                var price = newPrice + parseInt($(this).data("addprice"));
                $(this).text($(this).text() + " - " + price + " руб.").after("<br/>");
            });
        }
	else $(".sizeProd").html("");
        
	modalWindow(orderProd);
}
/*function getButton(orderProd) {
    return $(".product[order-product='"+orderProd+"'] button");
}*/
function selectAndAdd(orderProd, input) {
    var prod = $("[order-product='"+orderProd+"']");
    prod.find("[for=" + $(input).attr("for") + "]").click();
    prod.find("button").click();
}
function nextModal() {
	var leftPx = $(".prevModal").attr("left-px");
	var leftPx = leftPx - 192.5;
	var newL = leftPx-770;
	newL = Math.abs(newL);
		
	$(".nextModal, .prevModal").show(0);
	$(".slideModal").css({
		"left":leftPx+"px"
	});
	$(".prevModal").attr("left-px", leftPx);
	if(newL >= leftPxTotal)
		$(".nextModal").hide(0);
}
function prevModal() {
	var leftPx = $(".prevModal").attr("left-px");
	leftPx = parseFloat(leftPx) + 192.5;

	$(".prevModal, .nextModal").show(0);
	if(leftPx >= 0)
		$(".prevModal").hide(0);
	
	$(".slideModal").css({
		"left":leftPx+"px"
	});
	$(".prevModal").attr("left-px", leftPx);
}
$(document).ready(function($){



	$('.phoneNav').text($('#phoneNav').text());
	
	$(document).scroll(function () {
		var topPx = $(window).scrollTop();
		if(topPx >= 45) {
			$(".wrappHeader").addClass("fixedHeader");
			$(".wrappMenu").addClass("fixedMenu");
		}else {
			$(".wrappHeader").removeClass("fixedHeader");
			$(".wrappMenu").removeClass("fixedMenu");
		}
	});

	$(".parentCat").hover(
		function () {
			$(this).children(".wrappSubMenu").show(0);
		},
		function () {
			$(this).children(".wrappSubMenu").hide(0);
		}
	);

	$(".product").hover(
		function () {
			$(".activeProduct").removeClass("activeProduct");
			$(this).addClass("activeProduct");
			var product = $(this);
			$(window).bind("keyup", product, function(event){
				if (event.keyCode == 37) {
					product.find("#prevProduct").click();
				}
				if (event.keyCode == 39) {
					product.find("#nextProduct").click();
				}
			});
		},
		function () {
			$(this).removeClass("activeProduct");
			$(window).unbind("keyup");
		}
	);

	countFeeds = $(".slideEx").length;
	productCounts = $(".product").length;
	countProductModal = $(".productModal").length;
	leftPxTotal = countProductModal * 192.5;
	$("#next").click(next);
	$("#prev").click(prev);
	$(".nextProduct").click(nextProduct);
	$(".prevProduct").click(prevProduct);
	$(".nextModal").click(nextModal);
	$(".prevModal").click(prevModal);

	$(".sizesProduct span, .sizesProduct label").click(function () {
		//$(".activeSize").removeClass("activeSize");
		$(this).parent().find(".activeSize").removeClass("activeSize");
		$(this).addClass("activeSize");
	});

	$(".likeProduct, .linkeProduct").click(function () {
		var totalLikes = parseInt($(".likes").html());
		if(isNaN(totalLikes))
			totalLikes = 0;
		if($(this).hasClass("likes_active")) {
			$(this).removeClass("likes_active");
			totalLikes = totalLikes - 1;
			if(totalLikes == 0)
				$(".likes").html("").removeClass("likes_active");
			else
				$(".likes").html(totalLikes).addClass("likes_active");
		}else {
			$(this).addClass("likes_active");
			totalLikes = totalLikes + 1;
			$(".likes").addClass("likes_active").html(totalLikes);
		}
	});

	/*$(".addToCartProduct").click(function () {
		var orderProduct = parseInt($(this).parent().attr("order-product"));
		addToCart(orderProduct);
	});*/
	widthModal = 830;
	heightModal = 615;
});