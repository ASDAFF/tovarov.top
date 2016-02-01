<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetPageProperty("prop-h1", "РђРєС†РёРё");
	$APPLICATION->SetTitle("РђРєС†РёРё");
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
			<form class="subscription-form" action="/ajax/subscribe.php">
				<fieldset>
					<div class="subscription-holder">
						<span class="title">РџРѕРґРїРёСЃРєР° РЅР° Р°РєС†РёРё</span>
						<input class="text default" name="NAME" type="text" placeholder="Р’Р°С€Рµ РёРјСЏ">
						<input class="text default" name="EMAIL" type="text" placeholder="Р’Р°С€ Email">
						<input class="submit" type="submit" value="РџРѕРґРїРёСЃР°С‚СЊСЃСЏ">
						<input type="hidden" name="RUB_ID[]" value="2" />
					</div>
				</fieldset>
			</form>
			<?
				$APPLICATION->IncludeComponent(
				"bitrix:news.list", 
				"actions-menu", 
				array(
					"IBLOCK_TYPE" => "content",
					"IBLOCK_ID" => "#CALLBACK_IBLOCK_ID#",
					"NEWS_COUNT" => "4",
					"SORT_BY1" => "RAND",
					"SORT_ORDER1" => "DESC",
					"SORT_BY2" => "SORT",
					"SORT_ORDER2" => "ASC",
					"FILTER_NAME" => "",
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
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.list", 
				"actions", 
				array(
					"IBLOCK_TYPE" => "content",
					"IBLOCK_ID" => "#CALLBACK_IBLOCK_ID#",
					"NEWS_COUNT" => "20",
					"SORT_BY1" => "ACTIVE_FROM",
					"SORT_ORDER1" => "DESC",
					"SORT_BY2" => "SORT",
					"SORT_ORDER2" => "ASC",
					"FILTER_NAME" => "",
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
					"DISPLAY_BOTTOM_PAGER" => "Y",
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
<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>