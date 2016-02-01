$(function(){
	$('body').on('click', '.registry-popup-link', function(e){
		var url = $(this).attr('href');
		var x = ($(window).width() - 935) / 2, y = 80;
		e.preventDefault();
		$('.ajax-tmp').bPopup().close();
		$('.popup .btn-close').click();
		$('.ajax-tmp').empty();  // clear the previous contents of the popup
		
		$('.ajax-tmp').bPopup({
			closeClass: 'btn-close',
			modalColor: '#FFFFFF',
            loadUrl: url //Uses jQuery.load()
        });
		return false;
	});
	
	$('body').on('click', '.btn-click.callback', function(e){
		var url = $(this).attr('href');
		var x = ($(window).width() - 935) / 2, y = 80;
		e.preventDefault();
		$('.ajax-tmp').bPopup().close();
		$('.popup .btn-close').click();
        
		$('.ajax-tmp').empty();  // clear the previous contents of the popup
		
		$('.ajax-tmp').bPopup({
			closeClass: 'btn-close',
			modalColor: '#FFFFFF',
            loadUrl: url //Uses jQuery.load()
        });
		return false;
	});
	
	$('body').on('click', '.callback-popup-link', function(e){
		var url = $(this).attr('href');
		var x = ($(window).width() - 935) / 2, y = 80;
		e.preventDefault();
		$('.ajax-tmp').bPopup().close();
		$('.popup .btn-close').click();
        
		$('.ajax-tmp').empty();  // clear the previous contents of the popup
		
		$('.ajax-tmp').bPopup({
			closeClass: 'btn-close',
			modalColor: '#FFFFFF',
            loadUrl: url //Uses jQuery.load()
        });
		return false;
	});
	$('body').on('click', '.quick-view', function(e){
		var url = $(this).attr('href');
		var x = ($(window).width() - 935) / 2, y = 80;
		e.preventDefault();
		$('.ajax-tmp').bPopup().close();
        
		$('.ajax-tmp').empty();  // clear the previous contents of the popup
		
		$('.ajax-tmp').bPopup({
			closeClass: 'btn-close',
			modalColor: '#FFFFFF',
            loadUrl: url //Uses jQuery.load()
        });
		return false;
	});
	$('body').on('click', '.remove-basket-btn, #basket_form .close-a', function(){
		var url = $(this).attr('href');
		$.post(url, "", function(data){
			reloadBasketHTML();
            if($('#basket_form').length > 0){
                fullBasketReload();
            }
			showMessagePopup('#remove-basket-success');
		});
		return false;
	});
    $('body').on('click', '.buy-quick', function(e){
        e.preventDefault();
        var that = $(this), url = that.attr('href');

        $('.ajax-tmp').bPopup().close();
        $('.ajax-tmp').empty();  // clear the previous contents of the popup

        $('.ajax-tmp').bPopup({
            closeClass: 'btn-close',
            modalColor: '#FFFFFF',
            loadUrl: url //Uses jQuery.load()
        });
    });

    $(document).on('click', '.select', function(event){
        if($(this).find('ul').is(":visible")){
            $(this).find('ul').hide();
            return;
        }

        $('.select ul').hide();
        if(event.target.nodeName == "LI" || event.target.nodeName == "A") return;
        $(this).find('ul').show();
        //$(this).find('input[type="text"]').focus();
        event.stopPropagation();
    });

    $(document).click( function(event){
        if( $(event.target).closest('.select').length && !event.target)
            return;
        $('.select ul').stop().hide();
        event.stopPropagation();
    });

    $(document).on('click', '.select ul li', function(event){
        $('.select ul').hide();
        $a = $(this).find('a').clone();
        $trigger = $(this).parents('.select').find('.__trigger');
        $trigger.html($a);
    });
});

function setAttr(prmName,val){
	var res = '';
	var d = location.href.split("#")[0].split("?");  
	var base = d[0];
	var query = d[1];
	if(query) {
		var params = query.split("&");  
		for(var i = 0; i < params.length; i++) {  
			var keyval = params[i].split("=");  
			if(keyval[0] != prmName) {  
				res += params[i] + '&';
			}
		}
	}
	res += prmName + '=' + val;
	window.location.href = base + '?' + res;
	return false;
} 

function showMessagePopup(selector){
	$('.popup .btn-close').click();
	$(selector).bPopup({
		closeClass: 'btn-close',
		modalColor: '#FFFFFF'
	});
}

function reloadBasketHTML(){
    $url = sd+"ajax/basket.php"
    var basket = $('.mini-cart-holder');
    $.post($url, "", function(html){
        basket.html(html);
    });
}

function reloadWishlistHTML(){
	$url = sd+"ajax/wishlist_sect.php"
	var basket = $('.account-frames.wishlist .products-content');
	$.post($url, "", function(html){
		basket.html(html);
	});
}

function reloadBasket(){
	reloadBasketHTML();
	showMessagePopup('#basket-success');
}

function basketFail(){
	showMessagePopup('#basket-fail');
}

var updateAjaxData = {
	__cont_id : "",
	__url : "",
	__callback : function(){},
	__showLoading : true,
	__append: false,
	
	run: function(url, cont_id, showLoading, callback, append){
		__url = url;
		__cont_id = cont_id;
		__callback = callback || function(){};
		__append = append || false;
		
		$("#"+__cont_id).fadeTo(300, 0.5);
		jsAjaxUtil.LoadData(url, this.__insertData);
	},
	
	__insertData: function(data){
		var obContainer = document.getElementById(__cont_id);
		var $data = $(data);
		
		if(this.__append){
			$(obContainer).append($data);
		}else{
			$(obContainer).html(' ');
			$(obContainer).append($data);
		}
		
		$("#"+__cont_id).fadeTo(300, 1);
		
		if(typeof(this.__callback) == "function")
			this.__callback.call(this, $data);
	}
};