<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetPageProperty("prop-h1", "Бренды");
	$APPLICATION->SetTitle("Бренды");
?>
<div class="brand-wrap">
	<?
	$letter = $_REQUEST["letter"]?:"A";
	if(preg_match("/[а-яА-Я]/ui", $letter)){
		$letter = "А-Я";
		$brandFilter = array(">NAME" => "А");
	}
	else{
		$brandFilter = array("NAME" => $letter."%");
	}
	?>
	<?$APPLICATION->IncludeComponent("bitrix:news.list","brands",Array(
            "CURRENT_LETTER" => $letter,
			"DISPLAY_DATE" => "Y",
			"DISPLAY_NAME" => "Y",
			"DISPLAY_PICTURE" => "Y",
			"DISPLAY_PREVIEW_TEXT" => "Y",
			"AJAX_MODE" => "N",
			"IBLOCK_TYPE" => "system",
			"IBLOCK_ID" => "#BRANDS_IBLOCK_ID#",
			"NEWS_COUNT" => "999",
			"SORT_BY1" => "NAME",
			"SORT_ORDER1" => "ASC",
			"SORT_BY2" => "SORT",
			"SORT_ORDER2" => "ASC",
			"FILTER_NAME" => "brandFilter",
			"FIELD_CODE" => Array("ID", "PREVIEW_PICTURE", "DETAIL_PICTURE", "NAME", "DETAIL_PAGE_URL"),
			"PROPERTY_CODE" => Array("FAVORITES"),
			"CHECK_DATES" => "N",
			"DETAIL_URL" => "",
			"PREVIEW_TRUNCATE_LEN" => "",
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"SET_TITLE" => "Y",
			"SET_STATUS_404" => "Y",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"ADD_SECTIONS_CHAIN" => "N",
			"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"INCLUDE_SUBSECTIONS" => "Y",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "3600",
			"CACHE_FILTER" => "Y",
			"CACHE_GROUPS" => "Y",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"PAGER_TITLE" => "Новости",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => "",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_ADDITIONAL" => ""
		)
	);?>
	<?
		// включаемая область для раздела
		$APPLICATION->IncludeFile(SITE_DIR."include/parts/brands.php", Array(), Array(
			"MODE"      => "html",                                           // будет редактировать в веб-редакторе
			"NAME"      => "Редактирование включаемой области раздела",      // текст всплывающей подсказки на иконке
			"TEMPLATE"  => "section_include_template.php"                    // имя шаблона для нового файла
		));
	?>
</div>
<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>