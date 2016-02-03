<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<div class="brands-catalog">
	<div class="brands-block">
		<div class="brands-carousel container">
			<a href="#" class="btn-prev"><?=GetMessage('PREW')?></a>
			<div class="mask">
				<ul class="items">
					<?
					$brandIDs = array();
					foreach($arResult["ITEMS"] as $i => $arItem):
						$brandIDs[] = $arItem["ID"];
						$photo = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array("width" => $arParams["PREVIEW_WIDTH"], "height" => $arParams["PREVIEW_HEIGHT"]));
					?>
						<li <?if($i == 0):?>class="active"<?endif?>>
							<a href="#tab-<?=md5("MANUFACTURER")?>-<?=$arItem["ID"]?>"><img alt="image" src="<?=$photo['src']?>"></a>
						</li>
					<?endforeach;?>
				</ul>
			</div>
			<a href="#" class="btn-next"><?=GetMessage('PREW')?></a>
		</div>
	</div>
	<div class="items-carousel">
	<?
		global $manufacturerFilter;
		$manufacturerFilter = array(
			"PROPERTY_MANUFACTURER" => $brandIDs,
			"!PROPERTY_SHOW_ON_MANUFACTURER_TAB" => false
		);
		$APPLICATION->IncludeComponent(
			"bitrix:catalog.section", 
			"product-tabs", 
			array(
                "SHOW_EXPAND_OPTIONS" => "Y",
				"TABS_PROPERTY" => "MANUFACTURER",
				"SHOW_TAB_CONTROLS" => "N",
				"IBLOCK_TYPE" => "catalog",
				"IBLOCK_ID" =>  $arParams['IBLOCK_CATALOG'],
				"SECTION_ID" => "",
				"SECTION_CODE" => "",
				"SECTION_USER_FIELDS" => array(
					0 => "",
					1 => "",
				),
				"ELEMENT_SORT_FIELD" => "PROPERTY_MANUFACTURER",
				"ELEMENT_SORT_ORDER" => "asc",
				"ELEMENT_SORT_FIELD2" => "CATALOG_QUANTITY",
				"ELEMENT_SORT_ORDER2" => "desc",
				"FILTER_NAME" => "manufacturerFilter",
				"INCLUDE_SUBSECTIONS" => "Y",
				"SHOW_ALL_WO_SECTION" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"PAGE_ELEMENT_COUNT" => "60",
				"LINE_ELEMENT_COUNT" => "60",
				"PROPERTY_CODE" => array(
					0 => "MORE_PHOTO",
				),
				"OFFERS_FIELD_CODE" => array(
					0 => "ID",
					1 => "NAME",
					2 => "PREVIEW_PICTURE",
					3 => "",
				),
				"OFFERS_PROPERTY_CODE" => array(
					0 => "CML2_ARTICLE",
					1 => "MORE_PHOTO",
					2 => "FILES",
					3 => "COLOR",
					4 => "CML2_LINK",
					5 => "",
				),
				"OFFERS_SORT_FIELD" => "sort",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_FIELD2" => "active_from",
				"OFFERS_SORT_ORDER2" => "desc",
				"OFFERS_LIMIT" => "0",
				"TEMPLATE_THEME" => "blue",
				"PRODUCT_DISPLAY_MODE" => "Y",
				"ADD_PICT_PROP" => "MORE_PHOTO",
				"LABEL_PROP" => "LABEL",
				"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
				"OFFER_TREE_PROPS" => array(
					0 => "COLOR",
				),
				"PRODUCT_SUBSCRIPTION" => "N",
				"SHOW_DISCOUNT_PERCENT" => "N",
				"SHOW_OLD_PRICE" => "Y",
				"SECTION_URL" => "",
				"DETAIL_URL" => "",
				"SECTION_ID_VARIABLE" => "SECTION_ID",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "Y",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_GROUPS" => "N",
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
				"PRICE_CODE" => array(
					0 => "BASE",
				),
				"USE_PRICE_COUNT" => "N",
				"SHOW_PRICE_COUNT" => "1",
				"PRICE_VAT_INCLUDE" => "Y",
				"CONVERT_CURRENCY" => "Y",
				"CURRENCY_ID" => "RUB",
				"BASKET_URL" => SITE_DIR."personal/basket/",
				"ACTION_VARIABLE" => "action",
				"PRODUCT_ID_VARIABLE" => "id",
				"USE_PRODUCT_QUANTITY" => "N",
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"PRODUCT_PROPERTIES" => array(
					"MORE_PHOTO", 
					"LABEL",
					"PRODUCT_LABEL_TEXT"
				),
				"OFFERS_CART_PROPERTIES" => array(
					0 => "COLOR",
				),
				"PAGER_TEMPLATE" => "",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "Страница",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"PRODUCT_QUANTITY_VARIABLE" => "quantity"
			),
			$component
		);
	?>
	</div>

</div>