
var rrPartnerId = "5615a3401e9947326ca18492";
var rrApi = {};
var rrApiOnReady = rrApiOnReady || [];
rrApi.addToBasket = rrApi.order = rrApi.categoryView = rrApi.view =
rrApi.recomMouseDown = rrApi.recomAddToCart = function() {};
(function(d) {
var ref = d.getElementsByTagName('script')[0];
var apiJs, apiJsId = 'rrApi-jssdk';
if (d.getElementById(apiJsId)) return;
apiJs = d.createElement('script');
apiJs.id = apiJsId;
apiJs.async = true;
apiJs.src = "//cdn.retailrocket.ru/content/javascript/api.js";
ref.parentNode.insertBefore(apiJs, ref);
}(document));

function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}

$(document).ready(function() {
	//// Adding the clear Fix
	//cols1 = $('#column-right, #column-left').length;
	//
	//if (cols1 == 2) {
	//	$('#content .product-layout:nth-child(2n+2)').after('<div class="clearfix visible-md visible-sm"></div>');
	//} else if (cols1 == 1) {
	//	$('#content .product-layout:nth-child(3n+3)').after('<div class="clearfix visible-lg"></div>');
	//} else {
	//	$('#content .product-layout:nth-child(4n+4)').after('<div class="clearfix"></div>');
	//}
	
	// Highlight any found errors
	$('.text-danger').each(function() {
		var element = $(this).parent().parent();
		
		if (element.hasClass('form-group')) {
			element.addClass('has-error');
		}
	});
		
	//// Currency
	//$('#currency .currency-select').on('click', function(e) {
	//	e.preventDefault();
    //
	//	$('#currency input[name=\'code\']').attr('value', $(this).attr('name'));
    //
	//	$('#currency').submit();
	//});
    //
	//// Language
	//$('#language a').on('click', function(e) {
	//	e.preventDefault();
    //
	//	$('#language input[name=\'code\']').attr('value', $(this).attr('href'));
    //
	//	$('#language').submit();
	//});

	/* Search */
	$('.imgSearch').on('click', function(e) {
		e.preventDefault();
		var url = $('base').attr('href') + 'search';

		var value = $(this).parent().find('input[name=search]').val();

		if (value) {
			url += '&search=' + encodeURIComponent(value);
			//url += '/' + encodeURIComponent(value);
		}

		location = url;
	});

	$('input[name=\'search\']').on('keydown', function(e) {
		if (e.keyCode == 13) {
			$(this).parent().find('.imgSearch').trigger('click');
		}
	});

	//// Menu
	//$('#menu .dropdown-menu').each(function() {
	//	var menu = $('#menu').offset();
	//	var dropdown = $(this).parent().offset();
    //
	//	var i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());
    //
	//	if (i > 0) {
	//		$(this).css('margin-left', '-' + (i + 5) + 'px');
	//	}
	//});

	//// Product List
	//$('#list-view').click(function() {
	//	$('#content .product-layout > .clearfix').remove();
    //
	//	$('#content .product-layout').attr('class', 'product-layout product-list col-xs-12');
    //
	//	localStorage.setItem('display', 'list');
	//});
    //
	//// Product Grid
	//$('#grid-view').click(function() {
	//	$('#content .product-layout > .clearfix').remove();
    //
	//	// What a shame bootstrap does not take into account dynamically loaded columns
	//	cols = $('#column-right, #column-left').length;
    //
	//	if (cols == 2) {
	//		$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');
	//	} else if (cols == 1) {
	//		$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');
	//	} else {
	//		$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12');
	//	}
    //
	//	 localStorage.setItem('display', 'grid');
	//});
    //
	//if (localStorage.getItem('display') == 'list') {
	//	$('#list-view').trigger('click');
	//} else {
	//	$('#grid-view').trigger('click');
	//}

	// tooltips on hover
	//$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});

	// Makes tooltips work on ajax generated content
	/*$(document).ajaxStop(function() {
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	});*/
});

// Cart add remove functions
var cart = {
	'add': function(product_id, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			success: function(json) {
				$('.alert, .text-danger').remove();

				$('#cart > button').button('reset');

				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {
					rrApi.addToBasket(product_id);
					$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

					$('#cart-total').html(json['total']);

					$('html, body').animate({ scrollTop: 0 }, 'slow');

					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	},
	'addToCartOptions': function(product_id, quantity, input) {
		rrApi.addToBasket(product_id);
                var orderProduct = parseInt($(input).closest('.tovar_number_1').attr("order-product"));
		prod_options = $(input).closest('.tovar_number_1').find('[name^=option]');
		prod_options_checked = $(input).closest('.tovar_number_1').find('.selected-option').prev("input");
		selected_options = false;
		if (prod_options.length != 0) {
			if(prod_options_checked.length != 0) selected_options = true;
			if (selected_options == false) {
                            addToCartNoselect(orderProduct, input);
                            $('#alert-prod').html($(input).data("name"));
                            
                            return false;
                        }
		}

		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + quantity + '&' + $(prod_options_checked).attr("name") + '=' + $(prod_options_checked).val(),
			dataType: 'json',
			success: function(json) {
				$('.success, .warning, .attention, .information, .error').remove();
				
				if (json['success']) {
					//$('#alert-product').html(json['success']);					
                                        $(".modalOptions .options").html(text_added2cart);
                                        $(".backgroundModal2").fadeIn(300);
                                        resizeFadeModal();
                                        
					//addToCart(orderProduct);
                                        //$(".alsobought-container").load("index.php?route=module/alsobought/getindex&product_id=" + product_id);
					$('#price').html("<span>" + json['sum'] + "</span>");
				}
                                else alert(json['error']);
			}
		});
	},
        'addToCartOptionsProduct': function(product_id, quantity, input, block_options) {
        	rrApi.addToBasket(product_id);
		prod_options = input.find('.options-popup').find('[name^=option]');
                if (prod_options.length == 1) prod_options[0].click();
		prod_options_checked = input.find('.selected-option').prev("input");
		selected_options = false;
                
		if (prod_options.length != 0) {
			if(prod_options_checked.length != 0) selected_options = true;
                        
			if (selected_options == false) {
                            //addToCartNoselectInproduct(product_id, input);
                            //$('#alert-prod').html($(input).data("name"));
                            var sizesProd = input.find(".razmeri").html();
                            $(" .options").html(sizesProd);
                            /*$(block_options + ' .option-popup').on('click', function(){
                                $(this).closest(' .options').html(text_added2cart);
                            });*/
                            if (block_options == '.modalOptions') {
                                $(".backgroundModal2").fadeIn(300);
                                $(".backgroundModal").fadeIn(300);
                                resizeFadeModal();
                            }
                            else $(block_options).show();
                            
                            $(block_options + " .option-popup").each(function(){
                                $(this).attr("onclick", "selectAndAdd(" + product_id + ", this);");
                            });
                            return false;
                        }
		}
                /*else {
                    $(block_options + " .options").html(text_added2cart);
                    $(".backgroundModal2").fadeIn(300);
                    if (block_options == '.modalOptions') resizeFadeModal();           
                }*/

		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + quantity + '&' + $(prod_options_checked).attr("name") + '=' + $(prod_options_checked).val(),
			dataType: 'json',
			success: function(json) {
				$('.success, .warning, .attention, .information, .error').remove();
				
				if (json['success']) {
					//$('#alert-product').html(json['success']);
                                        
					$(' .options').html(text_added2cart);
                                        if (block_options == '.modalOptions') {
                                            $(".backgroundModal2").fadeIn(300);
                                            $(".backgroundModal").fadeIn(300);
                                            resizeFadeModal();
                                        }
                                        else $(block_options).show();
					//addToCartInproduct(product_id);
                                        //$(".alsobought-container").load("index.php?route=module/alsobought/getindex&product_id=" + product_id);
					$('#price').html("<span>" + json['sum'] + "</span>");
				}
                                else alert(json['error']);
			}
		});
	},
	'update': function(key, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/edit',
			type: 'post',
			data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			success: function(json) {
				$('#cart > button').button('reset');

				$('#cart-total').html(json['total']);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			success: function(json) {
				$('#cart > button').button('reset');

				$('#cart-total').html(json['total']);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	}
}

var voucher = {
	'add': function() {

	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				$('#cart-total').html(json['total']);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	}
}

var wishlist = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=account/wishlist/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				$('.alert').remove();

				if (json['success']) {
					$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				if (json['info']) {
					$('#content').parent().before('<div class="alert alert-info"><i class="fa fa-info-circle"></i> ' + json['info'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				if(typeof(json['total_likes']) != 'undefined') {
					$('.product-liked-info span').text(json['total_likes']).parent().show();
				}

				$('#wishlist-total').html(json['total']);

				/*$('html, body').animate({ scrollTop: 0 }, 'slow');*/
			}
		});
	},
	'remove': function() {

	}
}

var compare = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=product/compare/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				$('.alert').remove();

				if (json['success']) {
					$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

					$('#compare-total').html(json['total']);

					$('html, body').animate({ scrollTop: 0 }, 'slow');
				}
			}
		});
	},
	'remove': function() {

	}
}

/* Agree to Terms */
$(document).delegate('.agree', 'click', function(e) {
	e.preventDefault();

	$('#modal-agree').remove();

	var element = this;

	$.ajax({
		url: $(element).attr('href'),
		type: 'get',
		dataType: 'html',
		success: function(data) {
			html  = '<div id="modal-agree" class="modal">';
			html += '  <div class="modal-dialog">';
			html += '    <div class="modal-content">';
			html += '      <div class="modal-header">';
			html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
			html += '        <h4 class="modal-title">' + $(element).text() + '</h4>';
			html += '      </div>';
			html += '      <div class="modal-body">' + data + '</div>';
			html += '    </div';
			html += '  </div>';
			html += '</div>';

			$('body').append(html);

			$('#modal-agree').modal('show');
		}
	});
});

// Autocomplete */
(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {
			this.timer = null;
			this.items = new Array();
	
			$.extend(this, option);
	
			$(this).attr('autocomplete', 'off');
			
			// Focus
			$(this).on('focus', function() {
				this.request();
			});
			
			// Blur
			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);				
			});
			
			// Keydown
			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}				
			});
			
			// Click
			this.click = function(event) {
				event.preventDefault();
	
				value = $(event.target).parent().attr('data-value');
	
				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}
			
			// Show
			this.show = function() {
				var pos = $(this).position();
	
				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});
	
				$(this).siblings('ul.dropdown-menu').show();
			}
			
			// Hide
			this.hide = function() {
				$(this).siblings('ul.dropdown-menu').hide();
				$(document).find('ul.dropdown-menu').hide();
			}		
			
			// Request
			this.request = function() {
				clearTimeout(this.timer);
		
				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}
			
			// Response
			this.response = function(json) {
				html = '';
	
				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}
	
					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						}
					}
	
					// Get all the ones with a categories
					var category = new Array();
	
					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}
	
							category[json[i]['category']]['item'].push(json[i]);
						}
					}
	
					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';
	
						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}
	
				if (html) {
					this.show();
				} else {
					this.hide();
				}
	
				$(this).siblings('ul.dropdown-menu').html(html);
			}
			
			/*$(this).after('<ul class="dropdown-menu"></ul>');*/
			$('.wrappMenu').after('<ul class="dropdown-menu"></ul>');
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));	
			
		});
	}
})(window.jQuery);

function calc_price_catalog(label) {
    /*if ($(label).data("addprice") != "")*/{
        var price0 = parseFloat($(label).closest('.tovar_number_1').find('.price0').val());
        $(label).closest('.tovar_number_1').find('price').text(parseFloat($(label).data("addprice")) + price0 + " руб.");
        
        var oldprice = $(label).closest('.tovar_number_1').find('.priceold0');
        if (oldprice != undefined) {
            oldprice = parseFloat(oldprice.val());
            $(label).closest('.tovar_number_1').find('.priceOld').text(parseFloat($(label).data("addprice")) + oldprice + " руб.");
        }
    }
}

function calc_price(label) {
    //if ($(label).data("addprice") != "")
    $('.nowPrice').text(parseFloat($(label).data("addprice")) + parseFloat($('#price0').val()) + " руб.");

    var oldprice = $(label).closest('.descriptionProduct').find('.priceold0');
    if (oldprice != undefined) {
        oldprice = parseFloat(oldprice.val());
        $(label).closest('.descriptionProduct').find('.oldPrice').text(parseFloat($(label).data("addprice")) + oldprice + " руб.");
    }
}

function resizeFadeModal() {
            var obj = $(".modalOptions");
            var miliseconds = 700;

            obj.fadeIn(miliseconds);

            var left = ($(window).width() - obj.width())/2+"px";
            var top = ($(window).height() - obj.height())/2+"px";

            obj.css({
                "top":top,
                "left":left
            }); 
            $(window).resize(function () {
                var left = ($(window).width() - obj.width())/2+"px";
                var top = ($(window).height() - obj.height())/2+"px";
                obj.css({
                    "top":top,
                    "left":left
                });
            });  
}

function addToCartOptions(product_id, quantity, input) {
        var orderProduct = parseInt($(input).closest('.tovar_number_1').attr("order-product"));
        prod_options = $(input).closest('.bottomProduct').find('.selected-option');
        if (prod_options.length == 1) prod_options[0].click();
        //prod_options_checked = $(input).closest('.product').find('[type=radio]:checked');

        selected_options = false;
        if (prod_options.length == 0) {
                    addToCartNoselect(orderProduct, input);

                    return false;
        }
        else {
            $(".modalOptions .options").html('<p>Товар добавлен в корзину</p><<a href="/qcheckout">Перейти в корзину</a><a href="#" onclick="closeModal()">Продолжить покупки</a>');
            $(".backgroundModal2").fadeIn(300);
            resizeFadeModal();          
        }
}

function addToCartOptionsInProduct(product_id, quantity, input) {
        //var orderProduct = parseInt($(input).parent().attr("order-product"));
        prod_options = $(input).closest('.inform_kart').find('.selected-option');
        if (prod_options.length == 1) prod_options[0].click();
        //prod_options_checked = $(input).closest('.product').find('[type=radio]:checked');

        selected_options = false;
        if (prod_options.length == 0) {
                    addToCartNoselect(product_id, input);

                    return false;
        }
        else {
            $(".modalOptions .options").html(text_added2cart);
            $(".backgroundModal2").fadeIn(300);
            resizeFadeModal();
        }
}

function addToCartNoselect(orderProd, input) {
	//var sizesProd = $(".product[order-product='"+orderProd+"'] .option").html();
	var sizesProd = $(input).closest('.tovar_number_1').find(".option").html();
	if (sizesProd) {
            $(".modalOptions .options").html(sizesProd);
            $('.modalOptions .option-popup').on('click', function(){
                $(this).closest('.modalOptions .options').html(text_added2cart);
            });
            $(".backgroundModal2").fadeIn(300);
            $(".backgroundModal").fadeIn(300);
            resizeFadeModal();
            $(".modalOptions .option").find("span").each(function(){
                $(this).attr("onclick", "selectAndAdd(" + orderProd + ", this);");
                //var price = newPrice + parseInt($(this).data("addprice"));
                //$(this).text($(this).text() + " - " + price + " руб.").after("<br/>").css("font-size", "20px");
            });
        }
	//else $(".sizeProd").html("");
}

function selectAndAdd(orderProd, input) {
    var prod = $("[order-product='"+orderProd+"']");
    prod.find("[for=" + $(input).attr("for") + "]").click();
    prod.find(".button4click").click();
    $('.button_corzina_click .add_to_basket').click();
}