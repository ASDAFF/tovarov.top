;(function(window){

	if(window.brWishlist){
		return;
	}
	brWishlist = function(params){
		this.ID = params.ID;
		this.EXISTS = params.EXISTS;
		this.PARENT_TYPE = params.PARENT_TYPE;
		this.PARENT_ID = params.PARENT_ID;
		this.ELEMENT_ID = params.ELEMENT_ID;
		this.WISHLIST_ELEMENT_ID = params.WISHLIST_ELEMENT_ID;
		this.AJAX_URL = params.AJAX_URL;
		this.self = BX(this.ID);
		this.DELAY_LOAD = params.DELAY_LOAD;
		//console.log(this);
	}
	
	brWishlist.prototype.onClick = function(){
		//
		if(this.EXISTS) this.removeElement();
		else this.addElement();
	}
	
	brWishlist.prototype.addElement = function(){
		//console.log('wl add');
		//BX.ajax.post(this.AJAX_URL, "ACTION=ADD&PARAM1="+this.PARENT_TYPE+"&PARAM2="+this.PARENT_ID+"&PARAM3="+this.ELEMENT_ID, this.addHandler);
		BX.ajax({
			timeout:   30,
			method:   'POST',
			dataType: 'json',
			url:       this.AJAX_URL,
			data:      "ACTION=ADD&PARAM1="+this.PARENT_TYPE+"&PARAM2="+this.PARENT_ID+"&PARAM3="+this.ELEMENT_ID,
			onsuccess: BX.delegate(this.addHandler, this)
		});
	}
	
	brWishlist.prototype.addHandler = function(result){
		//console.log("add Handler");
		
		if(result.result){
			//
			this.WISHLIST_ELEMENT_ID = result.WID;
			this.EXISTS = true;
			
			BX.addClass(this.self, "exists");
		}else{
			this.handleError(result);
		}
		
		//console.log(this);
	}
	
	brWishlist.prototype.removeElement = function(){
		console.log('wl remove');
		//BX.ajax.post(this.AJAX_URL, "ACTION=DELETE&WID="+this.WISHLIST_ELEMENT_ID, this.removeHandler);
		BX.ajax({
			timeout:   30,
			method:   'POST',
			dataType: 'json',
			url:       this.AJAX_URL,
			data:      "ACTION=DELETE&WID="+this.WISHLIST_ELEMENT_ID,
			onsuccess: BX.delegate(this.removeHandler, this)
		});
	}
	
	brWishlist.prototype.removeHandler = function(result){
		//console.log("remove Handler");
		
		if(result.result){
			//
			
			this.WISHLIST_ELEMENT_ID = 0;
			this.EXISTS = false;
			
			BX.removeClass(this.self, "exists");
		}else{
			this.handleError(result);
		}
		
		console.log(this);
	}
	
	brWishlist.prototype.bindEvents = function(){
		console.log('wl bind', this.self);
		BX.bind(this.self, 'click', BX.proxy(this.onClick, this));
		
		if(this.DELAY_LOAD){
			BX.ajax({
				timeout:   30,
				method:   'POST',
				dataType: 'json',
				url:       this.AJAX_URL,
				data:      "ACTION=CHECK&PARAM1="+this.PARENT_TYPE+"&PARAM2="+this.PARENT_ID+"&PARAM3="+this.ELEMENT_ID,
				onsuccess: BX.delegate(this.checkHandler, this)
			});
		}
	}
	
	brWishlist.prototype.checkHandler = function(result){
		if(result.result){
			this.WISHLIST_ELEMENT_ID = result.WID;
			this.EXISTS = true;
			BX.addClass(this.self, "exists");
		}else{
			this.WISHLIST_ELEMENT_ID = 0;
			this.EXISTS = false;
			BX.removeClass("exists");
		}
	}
	
	brWishlist.prototype.handleError = function(result){
		if(!result["result"]){
			console.log(result["err_code"]);
		}else{

		}
	}
	
})(window);