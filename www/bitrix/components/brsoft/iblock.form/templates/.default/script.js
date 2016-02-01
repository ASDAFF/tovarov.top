;(function(window){
	if(window.brAddField){
		return;
	}
	brAddField = function(params){
		this.parentBox = params.parentBox;
		this.fieldsArray = [];
		this.inputType = params.inputType;
		this.self = params.self;
		this.name = params.name;
		this.className = params.className;
	}
	brAddField.prototype.addField = function(){
		switch(this.inputType){
			case 'text': 
				var element = BX.create('input', {'props': {'type': 'text','name': this.name,'className': this.className}});
				this.parentBox.insertBefore(element, this.self);
				element.setAttribute('form', 'brsoft-form');
				if(this.className == 'brsoft-date-input'){
					var image = BX.create('img',{'props':{'src': '/bitrix/js/main/core/images/calendar-icon.gif','className':'brsoft-calendar-icon'}});
					this.parentBox.insertBefore(image, this.self);
					BX.bind(element,
						'click',
						function(){
							BX.calendar({node: this, field: this, form: 'brsoft-form', bTime: 'true', currentTime: '<?=(time()+date("Z")+CTimeZone::GetOffset())?>', bHideTime: 'true'})
						}
					)
				}
				this.fieldsArray.push(element);
			break;
			case 'textarea':
				var element = BX.create('textarea', {'props': {'name': this.name,'className': this.className}});
				this.parentBox.insertBefore(element, this.self);
				element.setAttribute('form', 'brsoft-form');
				this.fieldsArray.push(element);
			break;
			case 'file':
				var element = BX.create('input', {'props': {'type': 'file','name': this.name,'className': this.className}});
				this.parentBox.insertBefore(element, this.self);
				element.setAttribute('form', 'brsoft-form');
				this.fieldsArray.push(element);
			break;
		}
	}
	
	brAddField.prototype.onClick = function(){
		this.addField();
	}
	
	brAddField.prototype.bindEvents = function(){
		BX.bind(this.self, 'click', BX.proxy(this.onClick, this));
	}
})(window);