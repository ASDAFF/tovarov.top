<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
    <div id="sidebar">
        <?
            $arElements = $APPLICATION->IncludeComponent(
                "bitrix:search.page",
                ".default",
                Array(
                    "RESTART" => $arParams["RESTART"],
                    "NO_WORD_LOGIC" => $arParams["NO_WORD_LOGIC"],
                    "USE_LANGUAGE_GUESS" => $arParams["USE_LANGUAGE_GUESS"],
                    "CHECK_DATES" => $arParams["CHECK_DATES"],
                    "arrFILTER" => array("iblock_".$arParams["IBLOCK_TYPE"]),
                    "arrFILTER_iblock_".$arParams["IBLOCK_TYPE"] => array($arParams["IBLOCK_ID"]),
                    "USE_TITLE_RANK" => "N",
                    "DEFAULT_SORT" => "rank",
                    "FILTER_NAME" => "",
                    "SHOW_WHERE" => "N",
                    "arrWHERE" => array(),
                    "SHOW_WHEN" => "N",
                    "PAGE_RESULT_COUNT" => 999,
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => "N",
                ),
                $component
            );
			
			global $searchFilter;
			$searchFilter["=ID"] = $arElements;
			/*$APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter",
				"visual_vertical",
				Array(
					"IBLOCK_TYPE" => "catalog",
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => $_REQUEST["SECTION_ID"],
					"FILTER_NAME" => "searchFilter",
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"CACHE_TYPE" => "N",
					"CACHE_TIME" => 0,
					"CACHE_GROUPS" => "N",
					"SAVE_IN_SESSION" => "N",
					"XML_EXPORT" => "N",
					"SECTION_TITLE" => "NAME",
					"SECTION_DESCRIPTION" => "DESCRIPTION",
					'HIDE_NOT_AVAILABLE' => "Y"
				),
				array('HIDE_ICONS' => 'Y')
			);*/
        ?>
    </div>
    <div id="content">
        <div class="top-panel">
            <?foreach($_GET as $key => $val):?>
                <?if($key == "sort" || $key == "size") continue;?>
                <input type="hidden" name="<?=$key?>" value="<?=$val?>" />
            <?endforeach;?>
            <?/*<div class="names">
                <h2><?=$arCurSection["NAME"]?></h2>
                <p>Всего <?$APPLICATION->ShowProperty("products-count", 0)?> товаров</p>
            </div>*/?>
            <form class="view-form">
				<?foreach($_GET as $k => $v){
					if(!in_array($k, array('sort', 'show', 'size'))) echo "<input type='hidden' name='$k' value='$v' />";
				}?>
                <div class="cell">
                    <label><?=GetMessage('SECTION_SHOW')?></label>
                    <?
                    $arSizes = array(
                        "20", "40", "60"
                    );
                    $pageSize = min(max(reset($arSizes), intval($_REQUEST["size"])), end($arSizes));
                    ?>
                    <select class="sort-number" name="size" onchange="$('.view-form').submit()">
                        <?foreach($arSizes as $size):?>
                            <option <?if($pageSize == $size):?>selected="selected"<?endif?> value="<?=$size?>"><?=$size?></option>
                        <?endforeach;?>
                    </select>
                </div>
                <div class="cell">
                    <label><?=GetMessage('SECTION_SORT')?></label>
                    <?
                    $arSortes = array(
                        "name" => array("NAME", "ASC"),
                        "price_asc" => array("CATALOG_PRICE_1", "ASC"),
                        "price_desc" => array("CATALOG_PRICE_1", "DESC"),
                    );

                    $arSortesName = array(
                        "name" => GetMessage('SECTION_SORT_NAME'),
                        "price_asc" => GetMessage('SECTION_SORT_PRICE_ASC'),
                        "price_desc" => GetMessage('SECTION_SORT_PRICE_DESC')
                    );

                    $sort = $arSortes[$_REQUEST["sort"]][0]?:"NAME";
                    $order = $arSortes[$_REQUEST["sort"]][1]?:"ASC";
                    ?>
                    <select class="sort-type" name="sort" onchange="$('.view-form').submit()">
                        <?foreach($arSortesName as $key => $arSort):?>
                            <option <?if($_REQUEST["sort"] == $key):?>selected="selected"<?endif?> value="<?=$key?>"><?=$arSort?></option>
                        <?endforeach;?>
                    </select>
                </div>
                <?
                $show = $_REQUEST["show"];
                ?>
                <script>
					$(function(){
                        $('.views a').click(function(){
                            $('[name=show]').val($(this).data("value"));
                            $('.view-form').submit();
                        });
                    });
				</script>
                <ul class="views">
                    <li><a href="javascript:void(0)" data-value="" class="icons <?if(empty($show)):?>active<?endif?>">icons</a></li>
                    <li><a href="javascript:void(0)" data-value="list" class="icons-pic-list <?if(!empty($show) && $show== "list"):?>active<?endif?>">icons-pic-list</a></li>
                    <li><a href="javascript:void(0)" data-value="table" class="icons-list <?if(!empty($show) && $show == "table"):?>active<?endif?>">table-list</a></li>
                </ul>
                <input type="hidden" name="show" value="" />
            </form>
        </div>

        <?
            if (!empty($arElements) && is_array($arElements))
            {
                global $searchFilter;
				
                //$searchFilter["ID"] => $arElements;
                ?>

                <div class="products-content">
                    <div class="<?=($show == ""?"items-cells":(($show == "table")?"products-items-listview":"products-items-list"))?>">
                        <?
                        $intSectionID = 0;
                        $intSectionID = $APPLICATION->IncludeComponent(
                            "bitrix:catalog.section",
                            $show,
                            array(
                                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                                "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                                "ELEMENT_SORT_FIELD2" => $sort,//$arParams["ELEMENT_SORT_FIELD"],
                                "ELEMENT_SORT_ORDER2" => $order,//$arParams["ELEMENT_SORT_ORDER"],
                                "PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
                                "META_KEYWORDS" => "-",
                                "META_DESCRIPTION" => "-",
                                "BROWSER_TITLE" => "-",
                                "INCLUDE_SUBSECTIONS" => "Y",//$arParams["INCLUDE_SUBSECTIONS"],
                                "BASKET_URL" => $arParams["BASKET_URL"],
                                "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                                "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                                "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                                "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                                "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                                "FILTER_NAME" => "searchFilter",//$arParams["FILTER_NAME"],
                                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                "CACHE_TIME" => $arParams["CACHE_TIME"],
                                "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                "SET_TITLE" => $arParams["SET_TITLE"],
                                "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                                "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                                "PAGE_ELEMENT_COUNT" => $pageSize,//$arParams["PAGE_ELEMENT_COUNT"],
                                "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                                "PRICE_CODE" => $arParams["PRICE_CODE"],
                                "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                                "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                                "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                                "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                                "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                                "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                                "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

                                "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                                "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                                "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                                "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                                "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                                "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                                "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                                "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

                                "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                                "OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
                                "OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
                                "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                                "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                                "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                                "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                                "OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],

                                "SECTION_ID" => $_REQUEST["SECTION_ID"],
                                "SECTION_CODE" => "",
                                "SECTION_URL" => $arParams["SECTION_URL"],
                                "DETAIL_URL" => $arParams["DETAIL_URL"],
                                "BASKET_URL" => $arParams["BASKET_URL"],
                                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                                'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

                                'LABEL_PROP' => $arParams['LABEL_PROP'],
                                'ADD_PICT_PROP' => "MORE_PHOTO",//$arParams['ADD_PICT_PROP'],
                                'PRODUCT_DISPLAY_MODE' => "Y",//$arParams['PRODUCT_DISPLAY_MODE'],

                                'OFFER_ADD_PICT_PROP' => "MORE_PHOTO",//$arParams['OFFER_ADD_PICT_PROP'],
                                'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                                'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                                'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                                'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                                'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
                                'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
                                'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
                                'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
                                'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

                                "SHOW_ALL_WO_SECTION" => "Y"
                            ),
                            $arResult["THEME_COMPONENT"]
                        );
                        ?>
                    </div>
                </div>
            <?
            }
            else
            {
                echo GetMessage("CT_BCSE_NOT_FOUND");
                echo "<br/><br/>";
            }
        ?>
    </div>