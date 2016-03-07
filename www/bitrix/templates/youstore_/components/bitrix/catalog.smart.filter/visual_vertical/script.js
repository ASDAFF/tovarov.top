function roundPlus(x, n) {
    //x - число, n - количество знаков
    if (isNaN(x) || isNaN(n)) return false;
    var m = Math.pow(10, n);
    return Math.round(x * m) / m;
}


function priceSliderInit(num, $min, $max, $currMin, $currMax, step) {
    /* слайдер цен */

    step = step || 1;
    $min = $min / step || 0;
    $max = $max / step || 10000;
    $currMin = ($currMin / step || $min);
    $currMax = ($currMax / step || $max);
    jQuery("#slider_" + num).attr('step', step);
    jQuery("#slider_" + num).slider({
        min: $min,
        max: $max,
        values: [$currMin, $currMax],
        range: true,
        stop: function (event, ui) {
            var slider = jQuery("#slider_" + num);
            var min = jQuery("input.minCost_" + num);
            var max = jQuery("input.maxCost_" + num);
            min.val(roundPlus(parseFloat(slider.slider("values", 0)) * step, 1));
            max.val(roundPlus(parseFloat(slider.slider("values", 1)) * step, 1));
            if (slider.slider("values", 0) != slider.slider('option', 'min') || slider.slider("values", 1) != slider.slider('option', 'max')) {
                max.addClass('changed');
                min.addClass('changed');
            }
            else {
                max.removeClass('changed');
                min.removeClass('changed');
            }
            smartFilter.keyup(jQuery("input.maxCost_" + num)['0']);

        },
        slide: function (event, ui) {
            var slider = jQuery("#slider_" + num);
            jQuery("input.minCost_" + num).val(roundPlus(parseFloat(slider.slider("values", 0)) * step, 1));
            jQuery("input.maxCost_" + num).val(roundPlus(parseFloat(slider.slider("values", 1)) * step, 1));
        }
    });
    jQuery("input.minCost_" + num).change(function () {
        var value1 = jQuery("input.minCost_" + num).val();
        var value2 = jQuery("input.maxCost_" + num).val();
        if (parseFloat(value1) > parseFloat(value2)) {
            value1 = value2;
            jQuery("input.minCost_" + num).val(value1);
        }
        jQuery("#slider_" + num).slider("values", 0, value1);
    });
    jQuery("input.maxCost_" + num).change(function () {
        var value1 = jQuery("input.minCost_" + num).val();
        var value2 = jQuery("input.maxCost_" + num).val();
        if (value2 > $max) {
            value2 = $max;
            jQuery("input.maxCost_" + num).val($max);
        }
        if (parseFloat(value1) > parseFloat(value2)) {
            value2 = value1;
            jQuery("input.maxCost_" + num).val(value2);
        }
        jQuery("#slider_" + num).slider("values", 1, value2);
    });

    // фильтрация ввода в поля
    jQuery('.filter-form input').keypress(function (event) {
        var key, keyChar;
        if (!event) var event = window.event;
        if (event.keyCode) key = event.keyCode;
        else if (event.which) key = event.which;
        if (key == null || key == 0 || key == 8 || key == 13 || key == 9 || key == 46 || key == 37 || key == 39) return true;
        keyChar = String.fromCharCode(key);
        if (!/\d/.test(keyChar)) return false;
    });
}
function JCSmartFilter(ajaxURL, viewMode) {
    this.ajaxURL = ajaxURL;
    this.form = null;
    this.timer = null;
    this.cacheKey = '';
    this.cache = [];
    this.viewMode = viewMode;
}

JCSmartFilter.prototype.keyup = function (input) {
    if (!!this.timer) {
        clearTimeout(this.timer);
    }
    this.timer = setTimeout(BX.delegate(function () {
        this.reload(input);
    }, this), 500);
};

JCSmartFilter.prototype.click = function (checkbox) {
    if (!!this.timer) {
        clearTimeout(this.timer);
    }
    if($(checkbox).prop('checked')) {
        $(checkbox).addClass('changed');
    }
    else $(checkbox).removeClass('changed');

    this.timer = setTimeout(BX.delegate(function () {
        this.reload(checkbox);
    }, this), 500);
};

JCSmartFilter.prototype.reload = function (input) {

    if (this.cacheKey !== '') {
        //Postprone backend query
        if (!!this.timer) {
            clearTimeout(this.timer);
        }
        this.timer = setTimeout(BX.delegate(function () {
            this.reload(input);
        }, this), 1000);
        return;
    }
    this.cacheKey = '|';
    this.position = BX.pos(input, true);
    this.form = BX.findParent(input, {'tag': 'form'});
    if (this.form) {
        var values = [];
        values[0] = {name: 'ajax', value: 'y'};
        this.gatherInputsValues(values, BX.findChildren(this.form, {'tag': new RegExp('^(input|select)$', 'i'),'class':'changed'}, true));

        for (var i = 0; i < values.length; i++)
            this.cacheKey += values[i].name + ':' + values[i].value + '|';

        if (this.cache[this.cacheKey]) {
            this.curFilterinput = input;
            this.postHandler(this.cache[this.cacheKey], true);
        }
        else {
            this.curFilterinput = input;
            BX.ajax.loadJSON(
                this.ajaxURL,
                this.values2post(values),
                BX.delegate(this.postHandler, this)
            );
        }
    }
};

JCSmartFilter.prototype.updateItem = function (PID, arItem) {
    if (arItem.PROPERTY_TYPE === 'N' || arItem.PRICE) {
        var step = parseFloat(jQuery("#slider_" + PID).attr('step'));
        debugger;
        max=arItem['VALUES']['MAX']['FILTERED_VALUE']?arItem['VALUES']['MAX']['FILTERED_VALUE']:arItem['VALUES']['MAX']['VALUE'];
        min=arItem['VALUES']['MIN']['FILTERED_VALUE']?arItem['VALUES']['MIN']['FILTERED_VALUE']:arItem['VALUES']['MIN']['VALUE'];
        value_max=Math.min(
            parseFloat(arItem['VALUES']['MAX']['FILTERED_VALUE']?arItem['VALUES']['MAX']['FILTERED_VALUE']:arItem['VALUES']['MAX']['VALUE']),
            parseFloat(arItem['VALUES']['MAX']['VALUE']?arItem['VALUES']['MAX']['VALUE']:arItem['VALUES']['MAX']['VALUE']),
            parseFloat(arItem['VALUES']['MAX']['HTML_VALUE']?arItem['VALUES']['MAX']['HTML_VALUE']:arItem['VALUES']['MAX']['VALUE'])
        );
        value_min=Math.max(
            parseFloat(arItem['VALUES']['MIN']['FILTERED_VALUE']?arItem['VALUES']['MIN']['FILTERED_VALUE']:arItem['VALUES']['MIN']['VALUE']),
            parseFloat(arItem['VALUES']['MIN']['VALUE']?arItem['VALUES']['MIN']['VALUE']:arItem['VALUES']['MIN']['VALUE']),
            parseFloat(arItem['VALUES']['MIN']['HTML_VALUE']?arItem['VALUES']['MIN']['HTML_VALUE']:arItem['VALUES']['MIN']['VALUE'])
        );
        jQuery("#slider_" + PID).slider("option", "min", roundPlus(min / step, 1));
        jQuery("#slider_" + PID).slider("option", "max", roundPlus(max / step, 1));
        jQuery("#slider_" + PID).slider('values',0,roundPlus(value_min / step, 1));
        jQuery("#slider_" + PID).slider('values',1,roundPlus(value_max / step, 1));
        $('#' + arItem['VALUES']['MIN']['CONTROL_ID']).val(value_min);
        $('#' + arItem['VALUES']['MAX']['CONTROL_ID']).val(value_max);

    }
    else if (arItem.VALUES) {
        for (var i in arItem.VALUES) {
            if (arItem.VALUES.hasOwnProperty(i)) {
                var value = arItem.VALUES[i];
                var control = BX(value.CONTROL_ID);

                if (!!control) {
                    var label = document.querySelector('[data-role="label_' + value.CONTROL_ID + '"]');
                    if (value.DISABLED) {
                        if (label)
                            BX.addClass(label, 'disabled');
                        else
                            BX.addClass(control.parentNode, 'disabled');
                    }
                    else {
                        if (label)
                            BX.removeClass(label, 'disabled');
                        else
                            BX.removeClass(control.parentNode, 'disabled');
                    }

                    if (value.hasOwnProperty('ELEMENT_COUNT')) {
                        label = document.querySelector('[data-role="count_' + value.CONTROL_ID + '"]');
                        if (label)
                            label.innerHTML = value.ELEMENT_COUNT;
                    }
                }
            }
        }
    }
};
$('#set_filter, #del_filter').on('click',function(e){
    e.preventDefault();
    window.location=$(this).attr('action');
})
JCSmartFilter.prototype.postHandler = function (result, fromCache) {
    $("#set_filter").attr('action',result.SEF_SET_FILTER_URL);
    $("#del_filter").attr('action',result.SEF_DEL_FILTER_URL);
    this.ajaxURL = result.FORM_ACTION;
debugger;
    if (!!result && !!result.ITEMS) {
        for (var PID in result.ITEMS) {
            if (result.ITEMS.hasOwnProperty(PID)) {
                this.updateItem(PID, result.ITEMS[PID]);
            }
        }
    }
    if (!fromCache && this.cacheKey !== '') {
        this.cache[this.cacheKey] = result;
    }
    this.cacheKey = '';
};

JCSmartFilter.prototype.gatherInputsValues = function (values, elements) {
    if (elements) {
        for (var i = 0; i < elements.length; i++) {
            var el = elements[i];
            if (el.disabled || !el.type)
                continue;

            switch (el.type.toLowerCase()) {
                case 'text':
                case 'textarea':
                case 'password':
                case 'hidden':
                case 'select-one':
                    if (el.value.length)
                        values[values.length] = {name: el.name, value: el.value};
                    break;
                case 'radio':
                case 'checkbox':
                    if (el.checked)
                        values[values.length] = {name: el.name, value: el.value};
                    break;
                case 'select-multiple':
                    for (var j = 0; j < el.options.length; j++) {
                        if (el.options[j].selected)
                            values[values.length] = {name: el.name, value: el.options[j].value};
                    }
                    break;
                default:
                    break;
            }
        }
    }
};

JCSmartFilter.prototype.values2post = function (values) {
    var post = [];
    var current = post;
    var i = 0;

    while (i < values.length) {
        var p = values[i].name.indexOf('[');
        if (p == -1) {
            current[values[i].name] = values[i].value;
            current = post;
            i++;
        }
        else {
            var name = values[i].name.substring(0, p);
            var rest = values[i].name.substring(p + 1);
            if (!current[name])
                current[name] = [];

            var pp = rest.indexOf(']');
            if (pp == -1) {
                //Error - not balanced brackets
                current = post;
                i++;
            }
            else if (pp == 0) {
                //No index specified - so take the next integer
                current = current[name];
                values[i].name = '' + current.length;
            }
            else {
                //Now index name becomes and name and we go deeper into the array
                current = current[name];
                values[i].name = rest.substring(0, pp) + rest.substring(pp + 1);
            }
        }
    }
    return post;
};

JCSmartFilter.prototype.hideFilterProps = function (element) {
    var easing;
    var obj = element.parentNode;
    var filterBlock = BX.findChild(obj, {className: "bx_filter_block"}, true, false);

    if (BX.hasClass(obj, "active")) {
        easing = new BX.easing({
            duration: 300,
            start: {opacity: 1, height: filterBlock.offsetHeight},
            finish: {opacity: 0, height: 0},
            transition: BX.easing.transitions.quart,
            step: function (state) {
                filterBlock.style.opacity = state.opacity;
                filterBlock.style.height = state.height + "px";
            },
            complete: function () {
                filterBlock.setAttribute("style", "");
                BX.removeClass(obj, "active");
            }
        });
        easing.animate();
    }
    else {
        filterBlock.style.display = "block";
        filterBlock.style.opacity = 0;
        filterBlock.style.height = "auto";

        var obj_children_height = filterBlock.offsetHeight;
        filterBlock.style.height = 0;

        easing = new BX.easing({
            duration: 300,
            start: {opacity: 0, height: 0},
            finish: {opacity: 1, height: obj_children_height},
            transition: BX.easing.transitions.quart,
            step: function (state) {
                filterBlock.style.opacity = state.opacity;
                filterBlock.style.height = state.height + "px";
            },
            complete: function () {
            }
        });
        easing.animate();
        BX.addClass(obj, "active");
    }
};

JCSmartFilter.prototype.showDropDownPopup = function (element, popupId) {
    var contentNode = element.querySelector('[data-role="dropdownContent"]');
    BX.PopupWindowManager.create("smartFilterDropDown" + popupId, element, {
        autoHide: true,
        offsetLeft: 0,
        offsetTop: 3,
        overlay: false,
        draggable: {restrict: true},
        closeByEsc: true,
        content: contentNode
    }).show();
};

JCSmartFilter.prototype.selectDropDownItem = function (element, controlId) {
    this.keyup(BX(controlId));

    var wrapContainer = BX.findParent(BX(controlId), {className: "bx_filter_select_container"}, false);

    var currentOption = wrapContainer.querySelector('[data-role="currentOption"]');
    currentOption.innerHTML = element.innerHTML;
    BX.PopupWindowManager.getCurrentPopup().close();
};

BX.namespace("BX.Iblock.SmartFilter");
BX.Iblock.SmartFilter = (function () {
    var SmartFilter = function (arParams) {
        if (typeof arParams === 'object') {
            this.leftSlider = BX(arParams.leftSlider);
            this.rightSlider = BX(arParams.rightSlider);
            this.tracker = BX(arParams.tracker);
            this.trackerWrap = BX(arParams.trackerWrap);

            this.minInput = BX(arParams.minInputId);
            this.maxInput = BX(arParams.maxInputId);

            this.minPrice = parseFloat(arParams.minPrice);
            this.maxPrice = parseFloat(arParams.maxPrice);

            this.curMinPrice = parseFloat(arParams.curMinPrice);
            this.curMaxPrice = parseFloat(arParams.curMaxPrice);

            this.fltMinPrice = arParams.fltMinPrice ? parseFloat(arParams.fltMinPrice) : parseFloat(arParams.curMinPrice);
            this.fltMaxPrice = arParams.fltMaxPrice ? parseFloat(arParams.fltMaxPrice) : parseFloat(arParams.curMaxPrice);

            this.precision = arParams.precision || 0;

            this.priceDiff = this.maxPrice - this.minPrice;

            this.leftPercent = 0;
            this.rightPercent = 0;

            this.fltMinPercent = 0;
            this.fltMaxPercent = 0;

            this.colorUnavailableActive = BX(arParams.colorUnavailableActive);//gray
            this.colorAvailableActive = BX(arParams.colorAvailableActive);//blue
            this.colorAvailableInactive = BX(arParams.colorAvailableInactive);//light blue

            this.isTouch = false;

            this.init();

            if ('ontouchstart' in document.documentElement) {
                this.isTouch = true;

                BX.bind(this.leftSlider, "touchstart", BX.proxy(function (event) {
                    this.onMoveLeftSlider(event)
                }, this));

                BX.bind(this.rightSlider, "touchstart", BX.proxy(function (event) {
                    this.onMoveRightSlider(event)
                }, this));
            }
            else {
                BX.bind(this.leftSlider, "mousedown", BX.proxy(function (event) {
                    this.onMoveLeftSlider(event)
                }, this));

                BX.bind(this.rightSlider, "mousedown", BX.proxy(function (event) {
                    this.onMoveRightSlider(event)
                }, this));
            }

            BX.bind(this.minInput, "keyup", BX.proxy(function (event) {
                this.onInputChange();
            }, this));

            BX.bind(this.maxInput, "keyup", BX.proxy(function (event) {
                this.onInputChange();
            }, this));
        }
    };

    SmartFilter.prototype.init = function () {
        var priceDiff;

        if (this.curMinPrice > this.minPrice) {
            priceDiff = this.curMinPrice - this.minPrice;
            this.leftPercent = (priceDiff * 100) / this.priceDiff;

            this.leftSlider.style.left = this.leftPercent + "%";
            this.colorUnavailableActive.style.left = this.leftPercent + "%";
        }

        this.setMinFilteredValue(this.fltMinPrice);

        if (this.curMaxPrice < this.maxPrice) {
            priceDiff = this.maxPrice - this.curMaxPrice;
            this.rightPercent = (priceDiff * 100) / this.priceDiff;

            this.rightSlider.style.right = this.rightPercent + "%";
            this.colorUnavailableActive.style.right = this.rightPercent + "%";
        }

        this.setMaxFilteredValue(this.fltMaxPrice);
    };

    SmartFilter.prototype.setMinFilteredValue = function (fltMinPrice) {
        this.fltMinPrice = parseFloat(fltMinPrice);
        if (this.fltMinPrice >= this.minPrice) {
            var priceDiff = this.fltMinPrice - this.minPrice;
            this.fltMinPercent = (priceDiff * 100) / this.priceDiff;

            if (this.leftPercent > this.fltMinPercent)
                this.colorAvailableActive.style.left = this.leftPercent + "%";
            else
                this.colorAvailableActive.style.left = this.fltMinPercent + "%";

            this.colorAvailableInactive.style.left = this.fltMinPercent + "%";
        }
        else {
            this.colorAvailableActive.style.left = "0%";
            this.colorAvailableInactive.style.left = "0%";
        }
    };

    SmartFilter.prototype.setMaxFilteredValue = function (fltMaxPrice) {
        this.fltMaxPrice = parseFloat(fltMaxPrice);
        if (this.fltMaxPrice <= this.maxPrice) {
            var priceDiff = this.maxPrice - this.fltMaxPrice;
            this.fltMaxPercent = (priceDiff * 100) / this.priceDiff;

            if (this.rightPercent > this.fltMaxPercent)
                this.colorAvailableActive.style.right = this.rightPercent + "%";
            else
                this.colorAvailableActive.style.right = this.fltMaxPercent + "%";

            this.colorAvailableInactive.style.right = this.fltMaxPercent + "%";
        }
        else {
            this.colorAvailableActive.style.right = "0%";
            this.colorAvailableInactive.style.right = "0%";
        }
    };

    SmartFilter.prototype.getXCoord = function (elem) {
        var box = elem.getBoundingClientRect();
        var body = document.body;
        var docElem = document.documentElement;

        var scrollLeft = window.pageXOffset || docElem.scrollLeft || body.scrollLeft;
        var clientLeft = docElem.clientLeft || body.clientLeft || 0;
        var left = box.left + scrollLeft - clientLeft;

        return Math.round(left);
    };

    SmartFilter.prototype.getPageX = function (e) {
        e = e || window.event;
        var pageX = null;

        if (this.isTouch && event.targetTouches[0] != null) {
            pageX = e.targetTouches[0].pageX;
        }
        else if (e.pageX != null) {
            pageX = e.pageX;
        }
        else if (e.clientX != null) {
            var html = document.documentElement;
            var body = document.body;

            pageX = e.clientX + (html.scrollLeft || body && body.scrollLeft || 0);
            pageX -= html.clientLeft || 0;
        }

        return pageX;
    };

    SmartFilter.prototype.recountMinPrice = function () {
        var newMinPrice = (this.priceDiff * this.leftPercent) / 100;
        newMinPrice = (this.minPrice + newMinPrice).toFixed(this.precision);

        if (newMinPrice != this.minPrice)
            this.minInput.value = newMinPrice;
        else
            this.minInput.value = "";
        smartFilter.keyup(this.minInput);
    };

    SmartFilter.prototype.recountMaxPrice = function () {
        var newMaxPrice = (this.priceDiff * this.rightPercent) / 100;
        newMaxPrice = (this.maxPrice - newMaxPrice).toFixed(this.precision);

        if (newMaxPrice != this.maxPrice)
            this.maxInput.value = newMaxPrice;
        else
            this.maxInput.value = "";
        smartFilter.keyup(this.maxInput);
    };

    SmartFilter.prototype.onInputChange = function () {
        var priceDiff;
        if (this.minInput.value) {
            var leftInputValue = this.minInput.value;
            if (leftInputValue < this.minPrice)
                leftInputValue = this.minPrice;

            if (leftInputValue > this.maxPrice)
                leftInputValue = this.maxPrice;

            priceDiff = leftInputValue - this.minPrice;
            this.leftPercent = (priceDiff * 100) / this.priceDiff;

            this.makeLeftSliderMove(false);
        }

        if (this.maxInput.value) {
            var rightInputValue = this.maxInput.value;
            if (rightInputValue < this.minPrice)
                rightInputValue = this.minPrice;

            if (rightInputValue > this.maxPrice)
                rightInputValue = this.maxPrice;

            priceDiff = this.maxPrice - rightInputValue;
            this.rightPercent = (priceDiff * 100) / this.priceDiff;

            this.makeRightSliderMove(false);
        }
    };

    SmartFilter.prototype.makeLeftSliderMove = function (recountPrice) {
        recountPrice = (recountPrice === false) ? false : true;

        this.leftSlider.style.left = this.leftPercent + "%";
        this.colorUnavailableActive.style.left = this.leftPercent + "%";

        var areBothSlidersMoving = false;
        if (this.leftPercent + this.rightPercent >= 100) {
            areBothSlidersMoving = true;
            this.rightPercent = 100 - this.leftPercent;
            this.rightSlider.style.right = this.rightPercent + "%";
            this.colorUnavailableActive.style.right = this.rightPercent + "%";
        }

        if (this.leftPercent >= this.fltMinPercent && this.leftPercent <= (100 - this.fltMaxPercent)) {
            this.colorAvailableActive.style.left = this.leftPercent + "%";
            if (areBothSlidersMoving) {
                this.colorAvailableActive.style.right = 100 - this.leftPercent + "%";
            }
        }
        else if (this.leftPercent <= this.fltMinPercent) {
            this.colorAvailableActive.style.left = this.fltMinPercent + "%";
            if (areBothSlidersMoving) {
                this.colorAvailableActive.style.right = 100 - this.fltMinPercent + "%";
            }
        }
        else if (this.leftPercent >= this.fltMaxPercent) {
            this.colorAvailableActive.style.left = 100 - this.fltMaxPercent + "%";
            if (areBothSlidersMoving) {
                this.colorAvailableActive.style.right = this.fltMaxPercent + "%";
            }
        }

        if (recountPrice) {
            this.recountMinPrice();
            if (areBothSlidersMoving)
                this.recountMaxPrice();
        }
    };

    SmartFilter.prototype.countNewLeft = function (event) {
        var pageX = this.getPageX(event);

        var trackerXCoord = this.getXCoord(this.trackerWrap);
        var rightEdge = this.trackerWrap.offsetWidth;

        var newLeft = pageX - trackerXCoord;

        if (newLeft < 0)
            newLeft = 0;
        else if (newLeft > rightEdge)
            newLeft = rightEdge;

        return newLeft;
    };

    SmartFilter.prototype.onMoveLeftSlider = function (e) {
        if (!this.isTouch) {
            this.leftSlider.ondragstart = function () {
                return false;
            };
        }

        if (!this.isTouch) {
            document.onmousemove = BX.proxy(function (event) {
                this.leftPercent = ((this.countNewLeft(event) * 100) / this.trackerWrap.offsetWidth);
                this.makeLeftSliderMove();
            }, this);

            document.onmouseup = function () {
                document.onmousemove = document.onmouseup = null;
            };
        }
        else {
            document.ontouchmove = BX.proxy(function (event) {
                this.leftPercent = ((this.countNewLeft(event) * 100) / this.trackerWrap.offsetWidth);
                this.makeLeftSliderMove();
            }, this);

            document.ontouchend = function () {
                document.ontouchmove = document.touchend = null;
            };
        }

        return false;
    };

    SmartFilter.prototype.makeRightSliderMove = function (recountPrice) {
        recountPrice = (recountPrice === false) ? false : true;

        this.rightSlider.style.right = this.rightPercent + "%";
        this.colorUnavailableActive.style.right = this.rightPercent + "%";

        var areBothSlidersMoving = false;
        if (this.leftPercent + this.rightPercent >= 100) {
            areBothSlidersMoving = true;
            this.leftPercent = 100 - this.rightPercent;
            this.leftSlider.style.left = this.leftPercent + "%";
            this.colorUnavailableActive.style.left = this.leftPercent + "%";
        }

        if ((100 - this.rightPercent) >= this.fltMinPercent && this.rightPercent >= this.fltMaxPercent) {
            this.colorAvailableActive.style.right = this.rightPercent + "%";
            if (areBothSlidersMoving) {
                this.colorAvailableActive.style.left = 100 - this.rightPercent + "%";
            }
        }
        else if (this.rightPercent <= this.fltMaxPercent) {
            this.colorAvailableActive.style.right = this.fltMaxPercent + "%";
            if (areBothSlidersMoving) {
                this.colorAvailableActive.style.left = 100 - this.fltMaxPercent + "%";
            }
        }
        else if ((100 - this.rightPercent) <= this.fltMinPercent) {
            this.colorAvailableActive.style.right = 100 - this.fltMinPercent + "%";
            if (areBothSlidersMoving) {
                this.colorAvailableActive.style.left = this.fltMinPercent + "%";
            }
        }

        if (recountPrice) {
            this.recountMaxPrice();
            if (areBothSlidersMoving)
                this.recountMinPrice();
        }
    };

    SmartFilter.prototype.onMoveRightSlider = function (e) {
        if (!this.isTouch) {
            this.rightSlider.ondragstart = function () {
                return false;
            };
        }

        if (!this.isTouch) {
            document.onmousemove = BX.proxy(function (event) {
                this.rightPercent = 100 - (((this.countNewLeft(event)) * 100) / (this.trackerWrap.offsetWidth));
                this.makeRightSliderMove();
            }, this);

            document.onmouseup = function () {
                document.onmousemove = document.onmouseup = null;
            };
        }
        else {
            document.ontouchmove = BX.proxy(function (event) {
                this.rightPercent = 100 - (((this.countNewLeft(event)) * 100) / (this.trackerWrap.offsetWidth));
                this.makeRightSliderMove();
            }, this);

            document.ontouchend = function () {
                document.ontouchmove = document.ontouchend = null;
            };
        }

        return false;
    };

    return SmartFilter;
})();