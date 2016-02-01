<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
<div class="three-columns">
	<aside id="aside">
		<span class="title">РЎР•Р Р’Р?РЎР«</span>
		<?
			$APPLICATION->IncludeComponent("bitrix:menu","aside",Array(
					"ROOT_MENU_TYPE" => "top", 
					"MAX_LEVEL" => "1", 
					"CHILD_MENU_TYPE" => "top", 
					"USE_EXT" => "Y",
					"DELAY" => "N",
					"ALLOW_MULTI_SELECT" => "Y",
					"MENU_CACHE_TYPE" => "N", 
					"MENU_CACHE_TIME" => "3600", 
					"MENU_CACHE_USE_GROUPS" => "Y", 
					"MENU_CACHE_GET_VARS" => "" 
				)
			);
		?>
	</aside>
	<div class="two-columns">
		<div id="sidebar">
			<form class="subscription-form" action="<?=SITE_DIR?>ajax/subscribe.php">
				<fieldset>
					<div class="subscription-holder">
						<span class="title">РџРѕРґРїРёСЃРєР° РЅР° Р°РєС†РёРё</span>
						<input class="text default" name="NAME" type="text" placeholder="Р’Р°С€Рµ РёРјСЏ">
						<input class="text default" name="EMAIL" type="text" placeholder="Р’Р°С€ Email">
						<input type="hidden" name="RUB_ID[]" value="2" />
						<input class="submit" type="submit" value="РџРѕРґРїРёСЃР°С‚СЊСЃСЏ">
					</div>
				</fieldset>
			</form>
			<?
				$detailFilter = array("!CODE" => $_REQUEST["CODE"]);
				$APPLICATION->IncludeComponent(
				"bitrix:news.list", 
				"actions-menu", 
				array(
					"IBLOCK_TYPE" => "content",
					"IBLOCK_ID" => "13",
					"NEWS_COUNT" => "4",
					"SORT_BY1" => "RAND",
					"SORT_ORDER1" => "DESC",
					"SORT_BY2" => "SORT",
					"SORT_ORDER2" => "ASC",
					"FILTER_NAME" => "detailFilter",
					"FIELD_CODE" => array(
						0 => "ID",
						1 => "SHOW_COUNTER",
						2 => "DATE_ACTIVE_TO",
						3 => "",
					),
					"PROPERTY_CODE" => array(
						0 => "",
						1 => "",
						2 => "",
					),
					"CHECK_DATES" => "Y",
					"DETAIL_URL" => "",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "3600",
					"CACHE_FILTER" => "Y",
					"CACHE_GROUPS" => "Y",
					"PREVIEW_TRUNCATE_LEN" => "",
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"SET_STATUS_404" => "Y",
					"SET_TITLE" => "Y",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"ADD_SECTIONS_CHAIN" => "N",
					"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"INCLUDE_SUBSECTIONS" => "Y",
					"PAGER_TEMPLATE" => "",
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "N",
					"PAGER_TITLE" => "",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"AJAX_OPTION_ADDITIONAL" => ""
				),
				false
			);?>
		</div>
		<div id="content">
			<?$ID = $APPLICATION->IncludeComponent("bitrix:news.detail", "actions", array(
				"IBLOCK_TYPE" => "content",
				"IBLOCK_ID" => "13",
				"ELEMENT_ID" => "",
				"ELEMENT_CODE" => $_REQUEST["CODE"],
				"CHECK_DATES" => "Y",
				"FIELD_CODE" => array(
					0 => "ID",
					1 => "DETAIL_TEXT",
					2 => "DETAIL_PICTURE",
					3 => "SHOW_COUNTER",
					4 => "DATE_ACTIVE_FROM",
					5 => "DATE_ACTIVE_TO"
				),
				"PROPERTY_CODE" => array(
					0 => "",
					1 => "",
				),
				"IBLOCK_URL" => "",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_GROUPS" => "Y",
				"META_KEYWORDS" => "-",
				"META_DESCRIPTION" => "-",
				"BROWSER_TITLE" => "-",
				"SET_STATUS_404" => "Y",
				"SET_TITLE" => "Y",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "Y",
				"ADD_ELEMENT_CHAIN" => "Y",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"USE_PERMISSIONS" => "N",
				"PAGER_TEMPLATE" => "",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "РЎС‚СЂР°РЅРёС†Р°",
				"PAGER_SHOW_ALL" => "N",
				"AJAX_OPTION_ADDITIONAL" => ""
				),
				false
			);?>
			<div class="stock-text">
				<h3>Р”СЂСѓРіРёРµ Р°РєС†РёРё</h3>
				<?
				$detailFilter = array("!ID" => $ID);
				$APPLICATION->IncludeComponent(
				"bitrix:news.list", 
				"actions", 
				array(
					"IBLOCK_TYPE" => "content",
					"IBLOCK_ID" => "13",
					"NEWS_COUNT" => "4",
					"SORT_BY1" => "RAND",
					"SORT_ORDER1" => "DESC",
					"SORT_BY2" => "SORT",
					"SORT_ORDER2" => "ASC",
					"FILTER_NAME" => "detailFilter",
					"FIELD_CODE" => array(
						0 => "ID",
						1 => "SHOW_COUNTER",
						2 => "DATE_ACTIVE_TO",
						3 => "",
					),
					"PROPERTY_CODE" => array(
						0 => "",
						1 => "",
						2 => "",
					),
					"CHECK_DATES" => "Y",
					"DETAIL_URL" => "",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "3600",
					"CACHE_FILTER" => "Y",
					"CACHE_GROUPS" => "Y",
					"PREVIEW_TRUNCATE_LEN" => "",
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"SET_STATUS_404" => "Y",
					"SET_TITLE" => "Y",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"ADD_SECTIONS_CHAIN" => "N",
					"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"INCLUDE_SUBSECTIONS" => "Y",
					"PAGER_TEMPLATE" => "",
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "N",
					"PAGER_TITLE" => "",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"AJAX_OPTION_ADDITIONAL" => ""
				),
				false
			);?>
			</div>
		</div>
	</div>
</div>
<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>