<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetPageProperty("prop-container-class", "page-main");
?>

<?
	if (\Bitrix\Main\Loader::includeModule("iblock"))
	{
		$arFilter = array(
			"IBLOCK_ID" => '#BRANDS_IBLOCK_ID#',
			"ACTIVE" => "Y",
			"GLOBAL_ACTIVE" => "Y",
		);
		if('' != $_REQUEST["CODE"])
		{
			$arFilter["=CODE"] = $_REQUEST["CODE"];
		}

		$obCache = new CPHPCache();
		if($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
		{
			$arCurBrand = $obCache->GetVars();
		}
		elseif($obCache->StartDataCache())
		{
			$arCurBrand = array();
			$dbRes = CIBlockElement::GetList(array(), $arFilter, false, array("ID", "NAME"));

			if(defined("BX_COMP_MANAGED_CACHE"))
			{
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache("/iblock/catalog");

				if ($arCurBrand = $dbRes->GetNext())
				{
					$CACHE_MANAGER->RegisterTag("iblock_id_3");
				}
				$CACHE_MANAGER->EndTagCache();
			}
			else
			{
				if(!$arCurBrand = $dbRes->GetNext())
					$arCurBrand = array();
			}

			$obCache->EndDataCache($arCurBrand);
		}
	}
?>

	<div id="sidebar">
		<?
		//ACTIVE_SECTION_ID - активный раздел
		//ELEMENT_INCLUDE_SUBSECTIONS - при подсчете елементов включать подразделы?
		//FILTER_NAME - фильтр по елементам разделов
		//SECT_FILTER_NAME - фильтр по свойствам самих разделов
		
		$brandSectionFilter = array(
			"PROPERTY_MANUFACTURER" => $arCurBrand["ID"],
			"ACTIVE" => "Y"
		);
		
		$APPLICATION->IncludeComponent(
			"advent:catalog.section.list",
			"",
			Array(
				"SHOW_ALL" => "Y",
				"ACTIVE_SECTION_ID" => $_REQUEST["SECTION_ID"],
				"VIEW_MODE" => "TEXT",
				"ELEMENT_INCLUDE_SUBSECTIONS" => "N",
				"FILTER_NAME" => "brandSectionFilter",
				"IBLOCK_TYPE" => "catalog",
				"IBLOCK_ID" => "#CATALOG_IBLOCK_ID#",
				"SECTION_ID" => "",
				"SECTION_CODE" => "",
				"SECTION_URL" => "",
				"COUNT_ELEMENTS" => "Y",
				"TOP_DEPTH" => "4",
				"SECTION_FIELDS" => "",
				"SECTION_USER_FIELDS" => array(),
				"ADD_SECTIONS_CHAIN" => "N",
				"CACHE_TYPE" => "N",
				"CACHE_TIME" => "36000000",
				"CACHE_NOTES" => "",
				"CACHE_GROUPS" => "Y",
				"NEWS_COUNT" => 999,
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => 3600,
				"PAGER_DESC_NUMBERING_CACHE_TYPE" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N"
			)		
		);?>
		<?
		$_REQUEST["arrFilter_8_".abs(crc32($arCurBrand["ID"]))] =
		$_POST["arrFilter_8_".abs(crc32($arCurBrand["ID"]))] =
		$_GET["arrFilter_8_".abs(crc32($arCurBrand["ID"]))]
		= "Y";
		$_REQUEST["set_filter"] = $_GET["set_filter"] = $_POST["set_filter"] = "Y";
		
		$APPLICATION->IncludeComponent(
			"bitrix:catalog.smart.filter",
			"brand_vertical",
			Array(
				"BRAND_ID" => $arCurBrand["ID"],
				"IBLOCK_TYPE" => "catalog",
				"IBLOCK_ID" => "#CATALOG_IBLOCK_ID#",
				"SECTION_ID" => $_REQUEST["SECTION_ID"],
				"FILTER_NAME" => "arrFilter",
				"PRICE_CODE" => array(
					0 => "BASE",
				),
				"CACHE_TYPE" => "N",
				"CACHE_TIME" => 0,
				"CACHE_GROUPS" => "Y",
				"SAVE_IN_SESSION" => "N",
				"XML_EXPORT" => "Y",
				"SECTION_TITLE" => "NAME",
				"SECTION_DESCRIPTION" => "DESCRIPTION",
				'HIDE_NOT_AVAILABLE' => "N"
			),
			array('HIDE_ICONS' => 'Y')
		);?>
	</div>
	<div id="content">
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.detail",
			"brand-info",
			Array(
				"DISPLAY_DATE" => "Y",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"USE_SHARE" => "N",
				"AJAX_MODE" => "N",
				"IBLOCK_TYPE" => "content",
				"IBLOCK_ID" => "#BRANDS_IBLOCK_ID#",
				"ELEMENT_ID" => "",
				"ELEMENT_CODE" => $_REQUEST["CODE"],
				"CHECK_DATES" => "N",
				"FIELD_CODE" => array(
					"ID",
					"PREVIEW_PICTURE",
					"DETAIL_PICTURE",
					"PREVIEW_TEXT"
				),
				"PROPERTY_CODE" => array(
					"TITLE"
				),
				"IBLOCK_URL" => "",
				"META_KEYWORDS" => "-",
				"META_DESCRIPTION" => "-",
				"BROWSER_TITLE" => "NAME",
				"SET_TITLE" => "N",
				"SET_STATUS_404" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"USE_PERMISSIONS" => "N",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_GROUPS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Страница",
				"PAGER_SHOW_ALL" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N"
			),
		false
		);?>
		<?
		if(empty($arrFilter["=PROPERTY_MANUFACTURER"])){
			$arrFilter["=PROPERTY_MANUFACTURER"] = array(
				$arCurBrand["ID"]
			);
		}
		?>
			<div class="top-panel">
				<?foreach($_GET as $key => $val):?>
					<?if($key == "sort" || $key == "size") continue;?>
					<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
				<?endforeach;?>
				<div class="names">
					<h2><?=$arCurSection["NAME"]?></h2>
					<p>Всего <?$APPLICATION->ShowProperty("products-count", 0)?> товаров</p>
				</div>
				<form class="view-form">
					<div class="cell">
						<label>Показать товаров</label>
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
						<label>Сортировать</label>
						<?
							$arSortes = array(
								"name" => array("NAME", "ASC"),
								"price_asc" => array("CATALOG_PRICE_1", "ASC"),
								"price_desc" => array("CATALOG_PRICE_1", "DESC"),
							);
							
							$arSortesName = array(
								"name" => "По названию",
								"price_asc" => "От дешевых к дорогим",
								"price_desc" => "От дорогих к дешевым"
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
					<script>$(function(){
						$('.views a').click(function(){
							$('[name=show]').val($(this).data("value"));
							$('.view-form').submit();
						});
					});</script>
					<ul class="views">
						<li><a href="javascript:void(0)" data-value="" class="icons <?if(empty($show)):?>active<?endif?>">icons</a></li>
						<li><a href="javascript:void(0)" data-value="list" class="icons-pic-list <?if(!empty($show) && $show== "list"):?>active<?endif?>">icons-pic-list</a></li>
                        <li><a href="javascript:void(0)" data-value="table" class="icons-list <?if(!empty($show) && $show == "table"):?>active<?endif?>">table-list</a></li>
					</ul>
					
					<input type="hidden" name="show" value="" />
				</form>
			</div>
			<div class="products-content">
				<div class="<?=($show == ""?"items-cells":(($show == "table")?"products-items-listview":"products-items-list"))?>">
					<?
						$APPLICATION->IncludeComponent(
							"bitrix:catalog.section", 
							$show, 
							array(
								"IBLOCK_TYPE" => "catalog",
								"IBLOCK_ID" => "#CATALOG_IBLOCK_ID#",
								"SECTION_ID" => $_REQUEST["SECTION_ID"],
								"SECTION_CODE" => "",
								"SECTION_USER_FIELDS" => array(
									0 => "",
									1 => "",
								),
								"ELEMENT_SORT_FIELD" => "sort",
								"ELEMENT_SORT_ORDER" => "asc",
								"ELEMENT_SORT_FIELD2" => "name",
								"ELEMENT_SORT_ORDER2" => "asc",
								"FILTER_NAME" => "arrFilter",
								"INCLUDE_SUBSECTIONS" => "Y",
								"SHOW_ALL_WO_SECTION" => "Y",
								"HIDE_NOT_AVAILABLE" => "N",
								"PAGE_ELEMENT_COUNT" => "20",
								"LINE_ELEMENT_COUNT" => "4",
								"PROPERTY_CODE" => array(
									0 => "MORE_PHOTO",
									1 => "",				
								),
								"OFFERS_LIMIT" => "0",
								"TEMPLATE_THEME" => "blue",
								"ADD_PICT_PROP" => "MORE_PHOTO",
								"LABEL_PROP" => "LABEL_PROP",
								"PRODUCT_SUBSCRIPTION" => "N",
								"SHOW_DISCOUNT_PERCENT" => "N",
								"SHOW_OLD_PRICE" => "Y",
								"MESS_BTN_BUY" => "Купить",
								"MESS_BTN_ADD_TO_BASKET" => "В корзину",
								"MESS_BTN_SUBSCRIBE" => "Подписаться",
								"MESS_BTN_DETAIL" => "Подробнее",
								"MESS_NOT_AVAILABLE" => "Нет в наличии",
								"SECTION_URL" => "",
								"DETAIL_URL" => "",
								"SECTION_ID_VARIABLE" => "SECTION_ID",
								"AJAX_MODE" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"AJAX_OPTION_HISTORY" => "N",
								"CACHE_TYPE" => "A",
								"CACHE_TIME" => "360000",
								"CACHE_GROUPS" => "Y",
								"SET_META_KEYWORDS" => "Y",
								"META_KEYWORDS" => "-",
								"SET_META_DESCRIPTION" => "Y",
								"META_DESCRIPTION" => "-",
								"BROWSER_TITLE" => "-",
								"ADD_SECTIONS_CHAIN" => "N",
								"DISPLAY_COMPARE" => "N",
								"SET_TITLE" => "Y",
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
								"PARTIAL_PRODUCT_PROPERTIES" => "Y",
								"PRODUCT_PROPERTIES" => array(
								),
								"PAGER_TEMPLATE" => ".default",
								"DISPLAY_TOP_PAGER" => "N",
								"DISPLAY_BOTTOM_PAGER" => "Y",
								"PAGER_TITLE" => "Товары",
								"PAGER_SHOW_ALWAYS" => "N",
								"PAGER_DESC_NUMBERING" => "N",
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
								"PAGER_SHOW_ALL" => "N",
								"AJAX_OPTION_ADDITIONAL" => "",
								"PRODUCT_QUANTITY_VARIABLE" => "quantity"
								),
							false
						);?>
					</div>
				</div>
	</div>
<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>