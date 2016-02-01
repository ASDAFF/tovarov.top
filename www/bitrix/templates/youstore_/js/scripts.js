$(document).ready(function(e) {
	$('a.fb_video').fancybox({
			'padding'		: 0,
			'autoScale'		: false,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'title'			: this.title,
			'width'			: 800,
			'height'		: 515,
			'href'			: this.href,
			'type'			: 'swf',
			'swf'			: {
				'wmode'				: 'transparent',
				'allowfullscreen'	: 'true'
			},
			helpers: {
				overlay: {
					locked: false
				}
			}			
	});

	if(!$(".bigdata-main-tab-div .tab-items .product-item").length){
		if($("#main_bigdata_li").length){
			$("#main_bigdata_li").hide();
		}
	}
	
	setTimeout(function () {
		if($(".aside .widget .advice-box").length){
			if($(".aside .widget .advice-box .items .item").length==1){
				$(".aside .widget .advice-box .link-prev").css('opacity','0');
				$(".aside .widget .advice-box .link-next").css('opacity','0');
			}
		}
		
	}, 1000); // время в мс

});