<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<?
    $strMainID = $this->GetEditAreaId($arResult['ID']);
    $arItemIDs = array(
        'ID' => $strMainID,
        'PICT' => $strMainID.'_pict',
        'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
        'STICKER_ID' => $strMainID.'_stricker',
        'BIG_SLIDER_ID' => $strMainID.'_big_slider',
        'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
        'SLIDER_LIST' => $strMainID.'_slider_list',
        'SLIDER_LEFT' => $strMainID.'_slider_left',
        'SLIDER_RIGHT' => $strMainID.'_slider_right',
        'OLD_PRICE' => $strMainID.'_old_price',
        'PRICE' => $strMainID.'_price',
        'DISCOUNT_PRICE' => $strMainID.'_price_discount',
        'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
        'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
        'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
        'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
        'QUANTITY' => $strMainID.'_quantity',
        'QUANTITY_DOWN' => $strMainID.'_quant_down',
        'QUANTITY_UP' => $strMainID.'_quant_up',
        'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
        'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
        'BUY_LINK' => $strMainID.'_buy_link',
        'QUICK_BUY_LINK' => $strMainID.'_quick_buy_link',
        'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
        'COMPARE_LINK' => $strMainID.'_compare_link',
        'PROP' => $strMainID.'_prop_',
        'PROP_DIV' => $strMainID.'_skudiv',
        'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
        'OFFER_GROUP' => $strMainID.'_set_group_',
        'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
        'ZOOM_DIV' => $strMainID.'_zoom_cont',
        'ZOOM_PICT' => $strMainID.'_zoom_pict',
        'AVAILABILITY_STATUS' => $strMainID.'_avail_status'
    );
    $strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

    $strTitle = (
        isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
        ? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
        : $arResult['NAME']
    );
    $strAlt = (
        isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
        ? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
        : $arResult['NAME']
    );

    if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])){
        foreach($arResult["OFFERS"] as &$offer){
            if($arResult["OFFERS"][$arResult['OFFERS_SELECTED']]["CATALOG_QUANTITY"] <= 0)
                $offer["CAN_BUY"] = false;
        }
    }else{
        if($arResult["CATALOG_QUANTITY"] <= 0)
            $arResult["CAN_BUY"] = false;
    }

    if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
    {
        $canBuy = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['CAN_BUY'];
    }
    else
    {
        $canBuy = $arResult['CAN_BUY'] && !empty($arResult["MIN_PRICE"]);
    }

    if ($canBuy)
    {
        $buyBtnMessage = ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
        $buyBtnClass = 'bx_big bx_bt_button bx_cart';
    }
    else
    {
        $buyBtnMessage = ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
        $buyBtnClass = 'bx_big bx_bt_button_type_2 bx_cart';
    }

?>
<link rel="stylesheet" href="<?=$templateFolder."/style.css?".time()?>" />

<div class="product-popup <?if(!$canBuy):?>unavailable<?endif?>" id="<? echo $arItemIDs['ID']; ?>">
    <div class="left">
		<div class="images-box">
            <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/photos.php")?>
		</div>
    </div>
    <div class="right">
        <div class="title-holder">
            <div class="include">
                <h2>
                    <? echo (
                            isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
                            ? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
                            : $arResult["NAME"]
                        ); ?>
                </h2>
            </div>
            <div class="marks">
                <?$APPLICATION->IncludeComponent(
                        "bitrix:iblock.vote",
                        "5-stars-cnt",
                        array(
                            "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                            "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                            "ELEMENT_ID" => $arResult['ID'],
                            "ELEMENT_CODE" => "",
                            "MAX_VOTE" => "5",
                            "VOTE_NAMES" => array("1", "2", "3", "4", "5"),
                            "SET_STATUS_404" => "N",
                            "DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
                            "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                            "CACHE_TIME" => $arParams['CACHE_TIME'],
                            "SHOW_VOTE_COUNT" => "Y",
                        ),
                        $component
                    );?>
                <span class="id"><?=GetMessage("PRODUCT_ARTIKUL_TITLE")?> <?=$arResult["ID"]?></span>
            </div>
        </div>
        <div class="info-box">
            <div class="price-box">
                <?
                    $boolDiscountShow = false;//(0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF']);
                ?>
                <div class="item_old_price hidden" id="<? echo $arItemIDs['OLD_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? $arResult['MIN_PRICE']['PRINT_VALUE'] : ''); ?></div>
                <div class="item_economy_price hidden" id="<? echo $arItemIDs['DISCOUNT_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arResult['MIN_PRICE']['PRINT_DISCOUNT_DIFF'])) : ''); ?></div>
                <strong class="price-item" id="<? echo $arItemIDs['PRICE']; ?>"><? echo floatval($arResult['MIN_PRICE']['DISCOUNT_VALUE']); ?> <sub><?=GetMessage("CURRENCY_".$arResult["MIN_PRICE"]["CURRENCY"]."_TITLE")?></sub></strong>
                <a href="#" class="link-delete">&nbsp;</a>
                <input class="number" id="<?=$arItemIDs['QUANTITY']?>" type="text" placeholder="1">
                <?if($canBuy):?>
                    <span class='status available' id="<?echo $arItemIDs['AVAILABILITY_STATUS']?>"><?=GetMessage("CT_BCE_CATALOG_AVAILABLE")?></span>
                    <?else:?>
                    <span class='status unavailable' id="<?echo $arItemIDs['AVAILABILITY_STATUS']?>"><?=GetMessage("CT_BCE_CATALOG_NOT_AVAILABLE")?></span>
                    <?endif?>
            </div>
            <?//if(.default($arResult['DETAIL_TEXT'])){$arResult["DETAIL_TEXT"] = $arResult["PREVIEW_TEXT"];}?>
            <?if(!empty($arResult["PREVIEW_TEXT"])):?>
                <div class="text">
                    <p>
                        <?=$arResult["PREVIEW_TEXT"]?>
                    </p>
                </div>
                <?endif?>

            <?/*выбор SKU*/?>
            <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/skuSelect.php");?>
            <?/*действия с товаров ( купить, купить в 1 клик и т.д.*/?>
            <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/cardActions.php");?>

			

<script type="text/javascript">(function(w,doc) {
if (!w.__utlWdgt ) {
    w.__utlWdgt = true;
    var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
}})(window,document);
</script>
<div data-background-alpha="0.0" data-buttons-color="#ffffff" data-counter-background-color="#ffffff" data-share-counter-size="12" data-top-button="false" data-share-counter-type="disable" data-share-style="6" data-mode="share" data-like-text-enable="false" data-mobile-view="true" data-icon-color="#ffffff" data-orientation="horizontal" data-text-color="#000000" data-share-shape="round" data-sn-ids="fb.vk.tw.ok.gp." data-share-size="30" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.gp." data-pid="1402866" data-counter-background-alpha="1.0" data-following-enable="false" data-exclude-show-more="true" data-selection-enable="true" class="uptolike-buttons" ></div>
	
	</div>		
    </div>
</div>
<div class="product-tabs">
    <ul class="product-tabs-list">
        <li><a class="active" href="#general"><?=GetMessage("PRODUCT_TAB_1")?></a></li>
        <li><a href="#desc"><?=GetMessage("PRODUCT_TAB_2")?></a></li>
        <li><a href="#features"><?=GetMessage("PRODUCT_TAB_3")?></a></li>
        <li><a href="#reviews"><?=GetMessage("PRODUCT_TAB_4")?></a></li>
    </ul>
    <div class="list-holder">
        <div id="general" class="tab">
            <div class="tab-cols">
                <div class="left">
                    <?
                        $APPLICATION->IncludeComponent(
                            "energosoft:energosoft.group_property", 
                            ".default", 
                            array(
                                "ES_IBLOCK_TYPE_GROUP" => $arParams["IBLOCK_TYPE"],
                                "ES_IBLOCK_GROUP" => $arParams['ES_IBLOCK_GROUP'],
                                "ES_IBLOCK_GROUP_SORT_FIELD" => "sort",
                                "ES_IBLOCK_GROUP_SORT_ORDER" => "asc",
                                "ES_IBLOCK_TYPE_CATALOG" => "catalog",
                                "ES_IBLOCK_CATALOG" => $arParams['IBLOCK_ID'],
                                "ES_ELEMENT" => $arResult["ID"],
                                "ES_SHOW_EMPTY" => "N",
                                "ES_SHOW_EMPTY_PROPERTY" => "N",
                                "ES_SHOW_GROUP_COUNT" => "0",
                                "ES_REMOVE_HREF" => "N",
                                "CACHE_TYPE" => "A",
                                "CACHE_TIME" => "3600",
                                "ES_GROUP_ALL" => array(
                                    0 => "MANUFACTURER",
                                ),
                                "ES_GROUP_INTERFACE" => array(
                                    0 => "WIRELESS_INTERFACES",
                                    1 => "DEVICE_COMPABILITY",
                                ),
                                "ES_SHOW_MAX_GROUP_COUNT" => "1",
                                "ES_GROUP_FACE" => array(
                                    0 => "PIXEL_DENSITY",
                                    1 => "TYPE_MATRIX",
                                ),
                                "ES_GROUP_PHYSICAL" => array(
                                    0 => "COLOR",
                                ),
                                "ES_GROUP_DISPLAY" => array(
                                    0 => "WEIGHT",
                                    1 => "MATERIAL",
                                    2 => "DIMENSIONS",
                                )
                            ),
                            false
                        );?>
                </div>
                <div class="right">
                    <?if(!empty($arResult["DETAIL_TEXT"])):?>
                        <div class="tab-box">
                            <h3 class="box-title icon6"><?=GetMessage("DETAIL_TEXT_TITLE")?></h3>
                            <div class="tab-text">
								<?/*if($arResult["DETAIL_TEXT_TYPE"]=='html'){
									echo $arResult["~DETAIL_TEXT"];
								}else{
									echo '<p>'.$arResult["DETAIL_TEXT"].'</p>';
								}*/?>
                                <p><?=substr(strip_tags($arResult["DETAIL_TEXT"], '<br><br/>'), 0, 650)."..."?></p>
                                <div class="link-holder">
									<script>
										function scrollToProductTabs(){
											var offsetTop = $('.product-tabs').offset().top - 69;
											$('body,html').animate({
												scrollTop: offsetTop
											}, 500);
										}
									</script>
                                    <a href="javascript:void(0)" onclick="$('[href=#desc]').click(); scrollToProductTabs();" class="link-details"><?=GetMessage('CATALOG_DETAIL')?></a>
                                </div>

                            </div>
                        </div>
                        <?endif?>
                    <?if(!empty($arResult["PROPERTIES"]["YOUTUBE_VIDEO"]["VALUE"]['TEXT'])):?>
                        <div class="tab-box">
                            <h3 class="box-title icon7"><?=GetMessage('CATALOG_VIDEO')?></h3>
                            <div class="tab-video">           
                                <?=$arResult["PROPERTIES"]["YOUTUBE_VIDEO"]["~VALUE"]['TEXT']?>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function(){
                                $('.tab-video iframe').attr('width','444');
                                $('.tab-video iframe').attr('height','271');
                            })
                        </script>
                        <?endif?>
                </div>
            </div>
            <?if(!empty($arResult["PROPERTIES"]["ACCESSORIES"]["VALUE"])):?>
                <div class="prod-similar">
                    <div class="tab-box">
                        <h3 class="box-title icon5"><?=GetMessage('CATALOG_ACCESSORIES')?>: <?=$arResult["NAME"]?></h3>
                        <div class="similars">
                            <?
                                global $accFilter;
                                $accFilter = array(
                                    "ID" => $arResult["PROPERTIES"]["ACCESSORIES"]["VALUE"]
                                );
                                $APPLICATION->IncludeComponent(
                                    "bitrix:catalog.section",
                                    "product-slider",
                                    array(
                                        "SHOW_EXPAND_OPTIONS" => "N",
                                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                        "SECTION_ID" => "",
                                        "SECTION_CODE" => "",
                                        "SECTION_USER_FIELDS" => array(
                                            0 => "",
                                            1 => "",
                                        ),
                                        "ELEMENT_SORT_FIELD" => "CATALOG_AVAILABLE",
                                        "ELEMENT_SORT_ORDER" => "DESC",
                                        "ELEMENT_SORT_FIELD2" => "RAND",
                                        "ELEMENT_SORT_ORDER2" => "asc",
                                        "FILTER_NAME" => "accFilter",
                                        "INCLUDE_SUBSECTIONS" => "Y",
                                        "SHOW_ALL_WO_SECTION" => "Y",
                                        "HIDE_NOT_AVAILABLE" => "N",
                                        "PAGE_ELEMENT_COUNT" => "20",
                                        "LINE_ELEMENT_COUNT" => "20",
                                        "PROPERTY_CODE" => array(
                                            0 => $arParams['ADD_PICT_PROP']
                                        ),
                                        "OFFERS_FIELD_CODE" => $arParams["DETAIL_OFFERS_FIELD_CODE"],
                                        "OFFERS_PROPERTY_CODE" => $arParams["DETAIL_OFFERS_PROPERTY_CODE"],
                                        "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                                        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                                        "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                                        "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                                        "OFFERS_LIMIT" => "0",
                                        "TEMPLATE_THEME" => "blue",
                                        "PRODUCT_DISPLAY_MODE" => "Y",
										'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
										"LABEL_PROP" => "-",
                                        'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                                        'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                                        "PRODUCT_SUBSCRIPTION" => "N",
                                        "SHOW_DISCOUNT_PERCENT" => "N",
                                        "SHOW_OLD_PRICE" => "Y",
                                        'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
                                        'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
                                        'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
                                        'MESS_BTN_COMPARE' => $arParams['MESS_BTN_COMPARE'],
                                        'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
                                        "SECTION_URL" => "",
                                        "DETAIL_URL" => "",
                                        "SECTION_ID_VARIABLE" => "SECTION_ID",
                                        "AJAX_MODE" => "N",
                                        "AJAX_OPTION_JUMP" => "Y",
                                        "AJAX_OPTION_STYLE" => "Y",
                                        "AJAX_OPTION_HISTORY" => "N",
                                        "CACHE_TYPE" => "A",
                                        "CACHE_TIME" => "36000000",
                                        "CACHE_GROUPS" => "Y",
                                        "SET_META_KEYWORDS" => "Y",
                                        "META_KEYWORDS" => "-",
                                        "SET_META_DESCRIPTION" => "Y",
                                        "META_DESCRIPTION" => "-",
                                        "BROWSER_TITLE" => "-",
                                        "ADD_SECTIONS_CHAIN" => "N",
                                        "DISPLAY_COMPARE" => "Y",
                                        "SET_TITLE" => "N",
                                        "SET_STATUS_404" => "N",
                                        "CACHE_FILTER" => "Y",
                                        "PRICE_CODE" => $arParams["PRICE_CODE"],
                                        "USE_PRICE_COUNT" => "N",
                                        "SHOW_PRICE_COUNT" => "1",
                                        "PRICE_VAT_INCLUDE" => "Y",
                                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                                        "BASKET_URL" => $arParams["BASKET_URL"],
                                        "ACTION_VARIABLE" => "action",
                                        "PRODUCT_ID_VARIABLE" => "id",
                                        "USE_PRODUCT_QUANTITY" => "N",
                                        "ADD_PROPERTIES_TO_BASKET" => "N",
                                        "PRODUCT_PROPS_VARIABLE" => "prop",
                                        "PARTIAL_PRODUCT_PROPERTIES" => "Y",
                                        "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
                                        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                                        "PAGER_TEMPLATE" => "",
                                        "DISPLAY_TOP_PAGER" => "N",
                                        "DISPLAY_BOTTOM_PAGER" => "N",
                                        "PAGER_TITLE" => "",
                                        "PAGER_SHOW_ALWAYS" => "N",
                                        "PAGER_DESC_NUMBERING" => "N",
                                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                        "PAGER_SHOW_ALL" => "N",
                                        "AJAX_OPTION_ADDITIONAL" => "",
                                        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                                        "PRODUCT_DISPLAY_MODE" => "Y",
                                        'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],

                                    ),
                                    false
                                );?>
                        </div>
                    </div>
                </div>
            <?endif?>
			<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.bigdata.products", 
	"product_detail", 
	array(
		"RCM_TYPE" => "bestsell",
		"ID" => $_REQUEST["PRODUCT_ID"],
		"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
		"IBLOCK_ID" => $arParams['IBLOCK_ID'],
		"SHOW_FROM_SECTION" => "N",
		"HIDE_NOT_AVAILABLE" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"PRODUCT_SUBSCRIPTION" => "N",
		"SHOW_NAME" => "Y",
		"SHOW_IMAGE" => "Y",
		"MESS_BTN_BUY" => GetMessage('BIGDATA_MESS_BTN_BUY'),//"Купить",
		"MESS_BTN_DETAIL" => GetMessage('BIGDATA_MESS_BTN_DETAIL'),//"Подробнее",
		"MESS_BTN_SUBSCRIBE" => GetMessage('BIGDATA_MESS_BTN_SUBSCRIBE'),//"Подписаться",
		"PAGE_ELEMENT_COUNT" => "6",
		"LINE_ELEMENT_COUNT" => "3",
		"TEMPLATE_THEME" => "blue",
		"DETAIL_URL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_GROUPS" => "N",
		"SHOW_OLD_PRICE" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CONVERT_CURRENCY" => "Y",
		"BASKET_URL" => SITE_DIR."personal/basket.php",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"USE_PRODUCT_QUANTITY" => "N",
		"SHOW_PRODUCTS_16" => "Y",
		"PROPERTY_CODE_16" => array(
			0 => "",
			1 => "",
		),
		"CART_PROPERTIES_16" => array(
			0 => "",
			1 => "",
		),
		"ADDITIONAL_PICT_PROP_16" => "MORE_PHOTO",
		"LABEL_PROP_16" => "LABEL",
		"PROPERTY_CODE_17" => array(
			0 => "SIZE",
			1 => "COLOR",
			2 => "",
		),
		"CART_PROPERTIES_17" => array(
			0 => "SIZE",
			1 => "COLOR",
			2 => "",
		),
		"ADDITIONAL_PICT_PROP_17" => "MORE_PHOTO",
		"OFFER_TREE_PROPS_17" => array(
			0 => "SIZE",
			1 => "COLOR",
		),
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_ELEMENT_ID" => "",
		"SECTION_ELEMENT_CODE" => "",
		"DEPTH" => "2",
		"CURRENCY_ID" => "RUB"
	),
	false
);?>
        </div>
        <div id="desc" class="tab" style="display:none">
            <div class="desc-article">
				<?if(!empty($arResult['PROPERTIES']['PHOTO_SLIDER']['VALUE'])){
					?>
					<div class="desc-gallery">
						<a href="#" class="link-prev">prev</a>
						<div class="mask">
							<ul class="items">
								<?foreach($arResult['PROPERTIES']['PHOTO_SLIDER']['VALUE'] as $key=>$pictId){
									$photo = CFile::ResizeImageGet($pictId, array("width" => 457, "height" => 370));
									?>
									<li>
										<a href="#">
											<img alt="image" src="<?=$photo['src'];?>" />
											<?if(strlen($arResult['PROPERTIES']['PHOTO_SLIDER']['DESCRIPTION'][$key])>0){?>
												<span class="slide-text"><?=$arResult['PROPERTIES']['PHOTO_SLIDER']['DESCRIPTION'][$key];?></span>
											<?}?>
										</a>
									</li><?
								}?>
							</ul>
						</div>
						<a href="#" class="link-next">next</a>
					</div>
					<?
				}?>

                <?=$arResult["DETAIL_TEXT"]?>
            </div>
        </div>
        <div id="features" class="tab" style="display:none">
            <?
                $APPLICATION->IncludeComponent(
                    "energosoft:energosoft.group_property", 
                    "two-cols", 
                    array(
                        "ES_IBLOCK_TYPE_GROUP" => $arParams["IBLOCK_TYPE"],
                                "ES_IBLOCK_GROUP" => $arParams['ES_IBLOCK_GROUP'],
                                 "ES_IBLOCK_GROUP_SORT_FIELD" => "sort",
                        "ES_IBLOCK_GROUP_SORT_ORDER" => "asc",
                        "ES_IBLOCK_TYPE_CATALOG" => "catalog",
                        "ES_IBLOCK_CATALOG" => $arParams['IBLOCK_ID'],
                        "ES_ELEMENT" => $arResult["ID"],
                        "ES_SHOW_EMPTY" => "N",
                        "ES_SHOW_EMPTY_PROPERTY" => "N",
                        "ES_SHOW_GROUP_COUNT" => "5",
                        "ES_REMOVE_HREF" => "N",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600",
                        "ES_GROUP_ALL" => array(
                            0 => "MANUFACTURER",
                        ),
                        "ES_GROUP_INTERFACE" => array(
                            0 => "THREEG",
                            1 => "BLUETOOTH",
                            2 => "WI_FI",
                            3 => "WIRELESS_INTERFACES",
                            4 => "DEVICE_COMPABILITY",
                        ),
                        "ES_SHOW_MAX_GROUP_COUNT" => "1",
                        "ES_GROUP_FACE" => array(
                            0 => "DIAGONAL",
                            1 => "TYPE_MATRIX",
                        ),
                        "ES_GROUP_PHYSICAL" => array(
                            0 => "MATERIAL",
                            1 => "COLOR",
                        ),
                        "ES_GROUP_DISPLAY" => array(
                            0 => "WEIGHT",
                            1 => "DIMENSIONS",
                        )
                    ),
                    false
                );?>

        </div>

<?
    if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
    {
        foreach ($arResult['JS_OFFERS'] as &$arOneJS)
        {
            $arOneJS["PRICE"]["CURRENCY_TITLE"] = GetMessage("CURRENCY_".$arOneJS["PRICE"]["CURRENCY"]."_TITLE");
            if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])
            {
                $arOneJS['PRICE']['PRINT_DISCOUNT_DIFF'] = GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arOneJS['PRICE']['PRINT_DISCOUNT_DIFF']));
                $arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
            }
            $strProps = '';
            if ($arResult['SHOW_OFFERS_PROPS'])
            {
                if (!empty($arOneJS['DISPLAY_PROPERTIES']))
                {
                    foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)
                    {
                        $strProps .= '<dt>'.$arOneProp['NAME'].'</dt><dd>'.(
                            is_array($arOneProp['VALUE'])
                            ? implode(' / ', $arOneProp['VALUE'])
                            : $arOneProp['VALUE']
                        ).'</dd>';
                    }
                }
            }
            $arOneJS['DISPLAY_PROPERTIES'] = $strProps;
        }
        if (isset($arOneJS))
            unset($arOneJS);
        $arJSParams = array(
            'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_ADD_BASKET_BTN' => true,
            'SHOW_BUY_BTN' => false,
            'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
            'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
            'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
            'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
            'OFFER_GROUP' => $arResult['OFFER_GROUP'],
            'VISUAL' => array(
                'ID' => $arItemIDs['ID'],
                'PICT_ID' => $arItemIDs['PICT'],
                'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
                'QUANTITY_LIMIT' => $arItemIDs['QUANTITY_LIMIT'],
                'PRICE_ID' => $arItemIDs['PRICE'],
                'OLD_PRICE_ID' => $arItemIDs['OLD_PRICE'],
                'DISCOUNT_VALUE_ID' => $arItemIDs['DISCOUNT_PRICE'],
                'DISCOUNT_PERC_ID' => $arItemIDs['DISCOUNT_PICT_ID'],
                'NAME_ID' => $arItemIDs['NAME'],
                'TREE_ID' => $arItemIDs['PROP_DIV'],
                'TREE_ITEM_ID' => $arItemIDs['PROP'],
                'SLIDER_CONT_OF_ID' => $arItemIDs['SLIDER_CONT_OF_ID'],
                'SLIDER_LIST_OF_ID' => $arItemIDs['SLIDER_LIST_OF_ID'],
                'SLIDER_LEFT_OF_ID' => $arItemIDs['SLIDER_LEFT_OF_ID'],
                'SLIDER_RIGHT_OF_ID' => $arItemIDs['SLIDER_RIGHT_OF_ID'],
                'BUY_ID' => $arItemIDs['BUY_LINK'],
                'QUICK_BUY_ID' => $arItemIDs['QUICK_BUY_LINK'],
                'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_LINK'],
                'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK'],
                'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
                'OFFER_GROUP' => $arItemIDs['OFFER_GROUP'],
                'ZOOM_DIV' => $arItemIDs['ZOOM_DIV'],
                'ZOOM_PICT' => $arItemIDs['ZOOM_PICT'],
                'AVAILABILITY_STATUS' => $arItemIDs['AVAILABILITY_STATUS']
            ),
            'DEFAULT_PICTURE' => array(
                'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
                'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
            ),
            'PRODUCT' => array(
                'ID' => $arResult['ID'],
                'NAME' => $arResult['~NAME']
            ),
            'BASKET' => array(
                'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                'BASKET_URL' => $arParams['BASKET_URL']
            ),
            'OFFERS' => $arResult['JS_OFFERS'],
            'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
            'TREE_PROPS' => $arSkuProps,
            'MESS' => array(
                'ECONOMY_INFO' => GetMessage('ECONOMY_INFO')
            )
        );
    }
    else
    {
        $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
        if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
        {
        ?>
        <div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
            <?
                if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
                {
                    foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
                    {
                    ?>
                    <input
                        type="hidden"
                        name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
                        value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>"
                        >
                    <?
                        if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
                            unset($arResult['PRODUCT_PROPERTIES'][$propID]);
                    }
                }
                $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
                if (!$emptyProductProperties)
                {
                ?>
                <table>
                    <?
                        foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo)
                        {
                        ?>
                        <tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
                            <td>
                                <?
                                    if(
                                        'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE']
                                        && 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']
                                    )
                                    {
                                        foreach($propInfo['VALUES'] as $valueID => $value)
                                        {
                                        ?><label><input
                                                type="radio"
                                                name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
                                                value="<? echo $valueID; ?>"
                                                <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>
                                            ><? echo $value; ?></label><br><?
                                        }
                                    }
                                    else
                                    {
                                    ?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
                                        foreach($propInfo['VALUES'] as $valueID => $value)
                                        {
                                        ?><option
                                            value="<? echo $valueID; ?>"
                                            <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>
                                            ><? echo $value; ?></option><?
                                        }
                                    ?></select><?
                                    }
                                ?>
                            </td></tr>
                        <?
                        }
                    ?>
                </table>
                <?
                }
            ?>
        </div>
        <?
        }
        $arJSParams = array(
            'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_ADD_BASKET_BTN' => false,
            'SHOW_BUY_BTN' => true,
            'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
            'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
            'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
            'VISUAL' => array(
                'ID' => $arItemIDs['ID'],
                'PICT_ID' => $arItemIDs['PICT'],
                'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                'PRICE_ID' => $arItemIDs['PRICE'],
                'OLD_PRICE_ID' => $arItemIDs['OLD_PRICE'],
                'DISCOUNT_VALUE_ID' => $arItemIDs['DISCOUNT_PRICE'],
                'DISCOUNT_PERC_ID' => $arItemIDs['DISCOUNT_PICT_ID'],
                'NAME_ID' => $arItemIDs['NAME'],
                'TREE_ID' => $arItemIDs['PROP_DIV'],
                'TREE_ITEM_ID' => $arItemIDs['PROP'],
                'SLIDER_CONT' => $arItemIDs['SLIDER_CONT_ID'],
                'SLIDER_LIST' => $arItemIDs['SLIDER_LIST'],
                'SLIDER_LEFT' => $arItemIDs['SLIDER_LEFT'],
                'SLIDER_RIGHT' => $arItemIDs['SLIDER_RIGHT'],
                'BUY_ID' => $arItemIDs['BUY_LINK'],
                'QUICK_BUY_ID' => $arItemIDs['QUICK_BUY_LINK'],
                'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_LINK'],
                'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK'],
                'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV']
            ),
            'PRODUCT' => array(
                'ID' => $arResult['ID'],
                'PICT' => $arFirstPhoto,
                'NAME' => $arResult['~NAME'],
                'SUBSCRIPTION' => true,
                'PRICE' => $arResult['MIN_PRICE'],
                'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
                'SLIDER' => $arResult['MORE_PHOTO'],
                'CAN_BUY' => $arResult['CAN_BUY'],
                'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
                'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
                'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
                'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
                'BUY_URL' => $arResult['~BUY_URL'],
            ),
            'BASKET' => array(
                'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
                'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                'EMPTY_PROPS' => $emptyProductProperties,
                'BASKET_URL' => $arParams['BASKET_URL']
            ),
            'MESS' => array()
        );
        unset($emptyProductProperties);
    }
?>
<script type="text/javascript">
    BX.message({
        MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCE_CATALOG_BUY')); ?>',
        MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCE_CATALOG_ADD')); ?>',
        MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE')); ?>',
        TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
        TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
        BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
        BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
        BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE') ?>',
        MESS_STATUS_AVAILABLE: '<?echo GetMessageJS("CT_BCE_CATALOG_AVAILABLE")?>',
        MESS_STATUS_NOT_AVAILABLE: '<?echo GetMessageJS("CT_BCE_CATALOG_NOT_AVAILABLE")?>'
    });
    var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
</script>
