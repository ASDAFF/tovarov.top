;(function (window) {

	if (!!window.brWishlistRemove)
	{
		return;
	}
	
	brWishlistRemove = function(params){
		this.ID = params.ID;
		
		this.PARENT_TYPE = params.PARENT_TYPE;
		this.PARENT_ID = params.PARENT_ID;
		this.ELEMENT_ID = params.ELEMENT_ID;
		
		this.AJAX_URL = params.AJAX_URL;
		
		this.self = BX(this.ID);
		
		this.OBJ_ID = params.OBJ_ID;
		this.obj = BX(this.OBJ_ID);
	}
	
	brWishlistRemove.prototype.onClick = function(){
		this.removeElement();
	}
	
	brWishlistRemove.prototype.removeElement = function(){
		BX.ajax({
			timeout:   30,
			method:   'POST',
			dataType: 'json',
			url:       this.AJAX_URL,
			data:      "ACTION=DELETE&PID="+this.ELEMENT_ID+"&IID="+this.PARENT_ID,
			onsuccess: BX.delegate(this.removeHandler, this)
		});
	}
	
	brWishlistRemove.prototype.removeHandler = function(result){
		if(result.result){
			BX.remove(this.obj);
		}else{
			this.handleError(result);
		}
	}
	
	brWishlistRemove.prototype.bindEvents = function(){
		BX.bind(this.self, 'click', BX.proxy(this.onClick, this));
	}
	
	brWishlistRemove.prototype.handleError = function(result){
		if(!result["result"]){
			console.log(result["err_code"]);
		}else{
		}
	}
})(window);
