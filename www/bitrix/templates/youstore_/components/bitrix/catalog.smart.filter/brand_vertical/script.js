function priceSliderInit($min, $max, $currMin, $currMax){
/* слайдер цен */
	$min = $min || 0;
	$max = $max || 10000;
	$currMin = $currMin || $min;
	$currMax = $currMax || $max;
	
	jQuery("#slider").slider({
		min: $min,
		max: $max,
		values: [$currMin, $currMax],
		range: true,
		stop: function(event, ui) {
			jQuery("input.minCost").val(jQuery("#slider").slider("values",0));
			jQuery("input.maxCost").val(jQuery("#slider").slider("values",1));
		},
		slide: function(event, ui){
			jQuery("input.minCost").val(jQuery("#slider").slider("values",0));
			jQuery("input.maxCost").val(jQuery("#slider").slider("values",1));
		}
	});
	jQuery("input.minCost").change(function(){
		var value1=jQuery("input.minCost").val();
		var value2=jQuery("input.maxCost").val();
		if(parseInt(value1) > parseInt(value2)){
			value1 = value2;
			jQuery("input.minCost").val(value1);
		}
		jQuery("#slider").slider("values",0,value1);
	});
	jQuery("input.maxCost").change(function(){
	var value1=jQuery("input.minCost").val();
		var value2=jQuery("input.maxCost").val();
		if (value2 > $max) { value2 = $max; jQuery("input.maxCost").val($max);}
		if(parseInt(value1) > parseInt(value2)){
			value2 = value1;
			jQuery("input.maxCost").val(value2);
		}
		jQuery("#slider").slider("values",1,value2);
	});

	// фильтрация ввода в поля
	jQuery('.filter-form input').keypress(function(event){
		var key, keyChar;
		if(!event) var event = window.event;
		if (event.keyCode) key = event.keyCode;
		else if(event.which) key = event.which;
		if(key==null || key==0 || key==8 || key==13 || key==9 || key==46 || key==37 || key==39 ) return true;
		keyChar=String.fromCharCode(key);
		if(!/\d/.test(keyChar)) return false;
	});
}

function JCSmartFilter(ajaxURL)
{
	this.ajaxURL = ajaxURL;
	this.form = null;
	this.timer = null;
}

JCSmartFilter.prototype.keyup = function(input)
{
	if(this.timer)
		clearTimeout(this.timer);
	this.timer = setTimeout(BX.delegate(function(){
		this.reload(input);
	}, this), 200);
}

JCSmartFilter.prototype.click = function(checkbox)
{
    console.log("checkbox click", checkbox);
	if(this.timer)
		clearTimeout(this.timer);
	this.timer = setTimeout(BX.delegate(function(){
		this.reload(checkbox);
	}, this), 200);
}

JCSmartFilter.prototype.reload = function(input)
{
	this.position = BX.pos(input, true);
	this.form = BX.findParent(input, {'tag':'form'});
	if(this.form)
	{
		/*var values = new Array;
		values[0] = {name: 'ajax', value: 'y'};
		this.gatherInputsValues(values, BX.findChildren(this.form, {'tag':'input'}, true));
		BX.ajax.loadJSON(
			this.ajaxURL,
			this.values2post(values),
			BX.delegate(this.postHandler, this)
		);*/
        var values = new Array;
        values[0] = {name: 'ajax', value: 'y'};
        this.gatherInputsValues(values, BX.findChildren(this.form, {'tag':'input'}, true));
        /*BX.ajax.loadJSON(
         this.ajaxURL,
         this.values2post(values),
         BX.delegate(this.postHandler, this)
         );*/


        console.log(window.location.pathname + $(this.form).serialize());

        $form_clone = $(this.form).clone();
        $form_clone.append("<input type='hidden' name='ajax_filter' value='y' />");
        $form_clone.append("<input type='hidden' name='set_filter' value='Y' />");

        var $form_container = $(this.form).parents('.filter-container');

        function __insertData(data){
            $form_container.html(data);
            $form_container.animate({opacity: 1});
            $('#sidebar input, #sidebar select').styler();
            // custom scroll
            jQuery(".brands-list").mCustomScrollbar({
                scrollInertia:300,
                autoDraggerLength:false,
                mouseWheel:false
            });
        }

        $form_container.animate({opacity: 0.5});
        jsAjaxUtil.LoadData(window.location.pathname + "?" + $form_clone.serialize(), __insertData);

    }
}

JCSmartFilter.prototype.postHandler = function (result)
{	
	if(result.ITEMS)
	{
		for(var PID in result.ITEMS)
		{
			var arItem = result.ITEMS[PID];
			if(arItem.PROPERTY_TYPE == 'N' || arItem.PRICE)
			{
			}
			else if(arItem.VALUES)
			{
				for(var i in arItem.VALUES)
				{
					var ar = arItem.VALUES[i];
					var control = BX(ar.CONTROL_ID);
			
					if(control)
					{
						control.disabled = ar.DISABLED ? true: false;
					}
				}
				
			}
		}
		
		jcf.customForms.refreshAll();
		/*var modef = BX('modef');
		var modef_num = BX('modef_num');
		if(modef && modef_num)
		{
			modef_num.innerHTML = result.ELEMENT_COUNT;
			var hrefFILTER = BX.findChildren(modef, {tag: 'A'}, true);

			if(result.FILTER_URL && hrefFILTER)
				hrefFILTER[0].href = BX.util.htmlspecialcharsback(result.FILTER_URL);

			if(result.FILTER_AJAX_URL && result.COMPONENT_CONTAINER_ID)
			{
				BX.bind(hrefFILTER[0], 'click', function(e)
				{
					var url = BX.util.htmlspecialcharsback(result.FILTER_AJAX_URL);
					BX.ajax.insertToNode(url, result.COMPONENT_CONTAINER_ID);
					return BX.PreventDefault(e);
				});
			}

			if (result.INSTANT_RELOAD && result.COMPONENT_CONTAINER_ID)
			{
				var url = BX.util.htmlspecialcharsback(result.FILTER_AJAX_URL);
				BX.ajax.insertToNode(url, result.COMPONENT_CONTAINER_ID);
			}
			else
			{
				if(modef.style.display == 'none')
					modef.style.display = 'block';
				modef.style.top = this.position.top + 'px';
			}
		}*/
	}
}

JCSmartFilter.prototype.gatherInputsValues = function (values, elements)
{
	if(elements)
	{
		for(var i = 0; i < elements.length; i++)
		{
			var el = elements[i];
			if (el.disabled || !el.type)
				continue;

			switch(el.type.toLowerCase())
			{
				case 'text':
				case 'textarea':
				case 'password':
				case 'hidden':
				case 'select-one':
					if(el.value.length)
						values[values.length] = {name : el.name, value : el.value};
					break;
				case 'radio':
				case 'checkbox':
					if(el.checked)
						values[values.length] = {name : el.name, value : el.value};
					break;
				case 'select-multiple':
					for (var j = 0; j < el.options.length; j++)
					{
						if (el.options[j].selected)
							values[values.length] = {name : el.name, value : el.options[j].value};
					}
					break;
				default:
					break;
			}
		}
	}
}

JCSmartFilter.prototype.values2post = function (values)
{
	var post = new Array;
	var current = post;
	var i = 0;
	while(i < values.length)
	{
		var p = values[i].name.indexOf('[');
		if(p == -1)
		{
			current[values[i].name] = values[i].value;
			current = post;
			i++;
		}
		else
		{
			var name = values[i].name.substring(0, p);
			var rest = values[i].name.substring(p+1);
			if(!current[name])
				current[name] = new Array;

			var pp = rest.indexOf(']');
			if(pp == -1)
			{
				//Error - not balanced brackets
				current = post;
				i++;
			}
			else if(pp == 0)
			{
				//No index specified - so take the next integer
				current = current[name];
				values[i].name = '' + current.length;
			}
			else
			{
				//Now index name becomes and name and we go deeper into the array
				current = current[name];
				values[i].name = rest.substring(0, pp) + rest.substring(pp+1);
			}
		}
	}
	return post;
}
