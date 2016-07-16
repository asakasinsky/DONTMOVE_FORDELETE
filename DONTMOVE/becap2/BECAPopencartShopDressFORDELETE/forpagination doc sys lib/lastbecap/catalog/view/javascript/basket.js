$(document).ready(function($){
	$(".controlCount").on("click", function () {
		var thisId = $(this).attr("id");
		if(thisId == "addCountBasket") {
			var countProdBasket = $(this).parent();
			var thisCount = parseInt(countProdBasket.children("#countProdBasket").html());
			countProdBasket.children("#countProdBasket").html(thisCount+1);
                        countProdBasket.children(".hidden-quantity").html(thisCount+1);
			var thisPrice = parseInt(countProdBasket.parent().children(".finalPriceProductBasket").html());
			var priceUnit = parseInt(countProdBasket.parent().children(".priceProductBasket").children("span").html());
			countProdBasket.parent().children(".finalPriceProductBasket").html(thisPrice+priceUnit);
			var totalPrice = parseInt($(".totalPrice span").html());
			$(".totalPrice span").html(totalPrice+priceUnit);
		}else if(thisId == "removeCountBasket") {
			var countProdBasket = $(this).parent();
			var thisCount = parseInt(countProdBasket.children("#countProdBasket").html());
			if(thisCount >= 2) {
				countProdBasket.children("#countProdBasket").html(thisCount-1);
                                countProdBasket.children(".hidden-quantity").html(thisCount-1);
				var thisPrice = parseInt(countProdBasket.parent().children(".finalPriceProductBasket").html());
				var priceUnit = parseInt(countProdBasket.parent().children(".priceProductBasket").children("span").html());
				countProdBasket.parent().children(".finalPriceProductBasket").html(thisPrice-priceUnit);
				var totalPrice = parseInt($(".totalPrice span").html());
				$(".totalPrice span").html(totalPrice-priceUnit);
			}
		}
	});
});