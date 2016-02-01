<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?><?
    if (0 < $arResult["SECTIONS_COUNT"])
    {
    ?>

    <?
        foreach ($arResult['SECTIONS'] as &$arSection)
        {
            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

            if (false === $arSection['PICTURE'])
                $arSection['PICTURE'] = array(
                    'SRC' => $arCurView['EMPTY_IMG'],
                    'ALT' => (
                        '' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
                        ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
                        : $arSection["NAME"]
                    ),
                    'TITLE' => (
                        '' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
                        ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
                        : $arSection["NAME"]
                    )
                );
			if(intval($arSection["UF_SECTION_ICON"])>0){
				$photo = CFile::ResizeImageGet($arSection["UF_SECTION_ICON"], array("width" => 50, "height" => 35));
			}else{
				$photo = CFile::ResizeImageGet($arSection["PICTURE"], array("width" => 50, "height" => 35));
			}
            $arSection["PICTURE"]["SRC"] = $photo['src'];
        ?>
        <div class="home-cat" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
            <div class="container">
				<?if(strlen($arSection["PICTURE"]["SRC"])){?>
					<img class="home-cat-img" src="<?=$arSection["PICTURE"]["SRC"]?>" />
				<?}?>
                <h2>
                    <?=strtoupper($arSection["NAME"])?> <span>(<?=$arSection["ELEMENT_CNT"]?> <?=GetMessage('SECTIONS_PRODUCTOV')?>)</span>
                </h2>
                <a class="button" href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=GetMessage('SECTIONS_SEEALL')?></a>
            </div>
        </div>
        <div class="root-carousel">
            <div class="container">
                <?
                    $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        "product-slider", 
                        array(
                            "SHOW_EXPAND_OPTIONS" => "N",
                            "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                            "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                            "SECTION_ID" => $arSection["ID"],
                            "SECTION_CODE" => "",
                            "SECTION_USER_FIELDS" => array(
                                0 => "",
                                1 => "",
                            ),
                            "ELEMENT_SORT_FIELD" => $arParams['ELEMENT_SORT_FIELD'],
                            "ELEMENT_SORT_ORDER" => $arParams['ELEMENT_SORT_ORDER'],
                            "ELEMENT_SORT_FIELD2" => "RAND",
                            "ELEMENT_SORT_ORDER2" => "asc",
                            "FILTER_NAME" => "arrFilter",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "SHOW_ALL_WO_SECTION" => "Y",
                            "HIDE_NOT_AVAILABLE" => "N",
                            "PAGE_ELEMENT_COUNT" => "20",
                            "LINE_ELEMENT_COUNT" => "20",
                            "PROPERTY_CODE" => array(
                                0 => "MORE_PHOTO"
                            ),
                            "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                            "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                            "OFFERS_SORT_FIELD" => "sort",
                            "OFFERS_SORT_ORDER" => "asc",
                            "OFFERS_SORT_FIELD2" => "active_from",
                            "OFFERS_SORT_ORDER2" => "desc",
                            "OFFERS_LIMIT" => "0",
                            "TEMPLATE_THEME" => "blue",
                            "PRODUCT_DISPLAY_MODE" => "Y",
                            "ADD_PICT_PROP" => "MORE_PHOTO",
                            "LABEL_PROP" => "-",
                            'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                            'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                            "PRODUCT_SUBSCRIPTION" => "N",
                            "SHOW_DISCOUNT_PERCENT" => "N",
                            "SHOW_OLD_PRICE" => "Y",
                            'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
                            'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
                            'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
                            'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
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
                            "PRICE_CODE" => array('BASE'),
                            "USE_PRICE_COUNT" => "N",
                            "SHOW_PRICE_COUNT" => "1",
                            "PRICE_VAT_INCLUDE" => "Y",
                            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                            'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                            "BASKET_URL" => $arParams["BASKET_URL"],
                            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
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
        <?
        }
    ?>

    <?
    }
?>