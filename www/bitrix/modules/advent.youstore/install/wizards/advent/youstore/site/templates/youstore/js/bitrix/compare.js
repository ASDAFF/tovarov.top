$(function(){
	$('body').on('click', '.link-compare', function(e){
		e.preventDefault();
		var callback = false;
		$.get($(this).attr('href'), '', function(data){
			if(data.length > 0){
				showMessagePopup("#compare-success");

			}else{

			}
		});
		
		return false;
	});
});