<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="page-main">
<?
	if (\Bitrix\Main\Loader::includeModule("iblock"))
	{
		$arFilter = array(
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ACTIVE" => "Y",
			"GLOBAL_ACTIVE" => "Y",
			"ELEMENT_SUBSECTIONS" => "N",
			"CNT_ACTIVE" => "Y"
		);
		
		$arUnderFilter = array(
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ACTIVE" => "Y",
			"GLOBAL_ACTIVE" => "Y"
		);
		
		if(0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
		{
			$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
			//
			$res = CIBlockSection::GetByID($arResult["VARIABLES"]["SECTION_ID"]);
			$ar_res = $res->GetNext();
			if($ar_res['PICTURE']){
			  ?>
			  <script type="text/javascript">
					$("img#page-image").attr('src', '<?=CFile::GetPath($ar_res['PICTURE'])?>');
			</script>
			  <?
			 }
		}
		elseif('' != $arResult["VARIABLES"]["SECTION_CODE"])
		{
			$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
		}

		$obCache = new CPHPCache();
		if($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
		{
			$arCurSection = $obCache->GetVars();
		}
		elseif($obCache->StartDataCache())
		{
            
            
			$arCurSection = array();
			$dbRes = CIBlockSection::GetList(array(), $arFilter, array("ELEMENT_SUBSECTIONS" => "N", "CNT_ALL" => "N", "CNT_ACTIVE" => "Y"), array("ID", "NAME", "DEPTH_LEVEL", "IBLOCK_SECTION_ID", "UF_*"));
			if(defined("BX_COMP_MANAGED_CACHE"))
			{
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache("/iblock/catalog");

				if ($arCurSection = $dbRes->GetNext())
				{     
                    $arUnderFilter['SECTION_ID'] = $arCurSection['ID'] ;
					$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);     
                    $arCurSection["SECTION_CNT"] = CIBlockSection::GetCount($arUnderFilter);
				}
				$CACHE_MANAGER->EndTagCache();
			}
			else
			{
				if(!$arCurSection = $dbRes->GetNext()){    
					$arCurSection = array();
				}else{
					$arUnderFilter["SECTION_ID"] = $arCurSection["ID"];
					$arCurSection["SECTION_CNT"] = CIBlockSection::GetCount($arUnderFilter);
				}
			}
             
			$obCache->EndDataCache($arCurSection);
		}
        echo $sect_count;
		 $depth = $arCurSection['DEPTH_LEVEL'];     
	$hasChildSections = $arCurSection["SECTION_CNT"] > 0 /*/intval($arCurSection["DEPTH_LEVEL"]) == 1*/ && $arCurSection["UF_SHOW_ELEMENTS"] != 1;
	}
?>
<?if(strtoupper($_REQUEST["ajax"]) != 'Y'):?>
	<?$APPLICATION->ShowViewContent('filter');?>
<?endif?>

	<?if($depth==1 && $hasChildSections):
		$APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			"root",
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
				"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
				"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
				"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
				"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N")
			),
			$component
		);		
	else:
		$APPLICATION->SetPageProperty("prop-h1", $arCurSection["NAME"]);
	?>
		<?if(strtoupper($_REQUEST["ajax"]) != 'Y'):?>
			<?$this->SetViewTarget('filter');?>
		<?endif?>
		
			<div id="sidebar">
				<?
					$arParams['USE_FILTER'] = !$hasChildSections && $arParams['USE_FILTER'] == 'Y';
					$APPLICATION->IncludeComponent(
						"bitrix:catalog.section.list",
						"sub",
						array(
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"SECTION_ID" => (($arCurSection["SECTION_CNT"] != 0)?"":$arCurSection["IBLOCK_SECTION_ID"]),
							"SECTION_CODE" => (($arCurSection["SECTION_CNT"] != 0)?$arResult["VARIABLES"]["SECTION_CODE"]:""),
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
							"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
							"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
							"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
							"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
							"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
							"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
							"ACTIVE_SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"]
						),
						$component
					);
				if ($arParams['USE_FILTER'])
				{
                ?>
                    <div class="filter-container">
                        <?
                            if(strtoupper($_REQUEST["ajax_filter"]) == "Y"){
                                $APPLICATION->RestartBuffer();
                            }
                                $APPLICATION->IncludeComponent(
                                    "bitrix:catalog.smart.filter",
                                    "visual_vertical",
                                    Array(
                                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                        "SECTION_ID" => $arCurSection['ID'],
                                        "FILTER_NAME" => "arrFilter",//$arParams["FILTER_NAME"],
                                        "PRICE_CODE" => $arParams["PRICE_CODE"],
                                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                        "SAVE_IN_SESSION" => "N",
                                        "XML_EXPORT" => "Y",
                                        "SECTION_TITLE" => "NAME",
                                        "SECTION_DESCRIPTION" => "DESCRIPTION",
                                        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                                        "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"]
                                    ),
                                    $component,
                                    array('HIDE_ICONS' => 'Y')
                                );

                            if(strtoupper($_REQUEST["ajax_filter"]) == "Y"){
                                die();
                            }
                        ?>
                    </div>
                <?
				}?>
			</div>
		
		<?if(strtoupper($_REQUEST["ajax"]) != 'Y'):?>
			<?$this->EndViewTarget();?>
		<?endif?>
		
		<div id="content">
			<div class="top-panel">
				<?foreach($_GET as $key => $val):?>
					<?if($key == "sort" || $key == "size") continue;?>
					<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
				<?endforeach;?>
				<div class="names">
					<h2><?=$arCurSection["NAME"]?></h2>
					<p><?=GetMessage('SECTION_ALL')?> <?$APPLICATION->ShowProperty("products-count", 0)?> <?=GetMessage('SECTION_PRODUCTS')?></p>
				</div>
				<form class="view-form">
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
								"price_asc" => GetMessage('SECTION_SORT_PRICE_ASC'),
								"price_desc" => GetMessage('SECTION_SORT_PRICE_DESC'),
								"name" => GetMessage('SECTION_SORT_NAME'),
							);
							
							$sort = $arSortes[$_REQUEST["sort"]][0]?:"CATALOG_PRICE_1";
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
								"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
								"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
								"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
								"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
								"INCLUDE_SUBSECTIONS" => "Y",//$arParams["INCLUDE_SUBSECTIONS"],
								"BASKET_URL" => $arParams["BASKET_URL"],
								"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
								"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
								"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
								"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
								"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
								"FILTER_NAME" => "arrFilter",//$arParams["FILTER_NAME"],
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
								"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
								"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
								"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
								"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
								"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
								"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
								"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

								"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
								"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
								"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
								"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
								'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
								'CURRENCY_ID' => $arParams['CURRENCY_ID'],
								'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

								'LABEL_PROP' => $arParams['LABEL_PROP'],
								'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
								'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

								'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
								'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
								'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
								'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
								'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
								'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
								'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
								'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
								'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
								'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

								'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
							)/*,
							$component*/
						);
					?>
				</div>
			</div>
		</div>
	<?
	endif;
	?>
</div>