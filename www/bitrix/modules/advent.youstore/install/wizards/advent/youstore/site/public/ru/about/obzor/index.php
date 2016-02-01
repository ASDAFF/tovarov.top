<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetTitle("Обзоры");
	$APPLICATION->SetPageProperty("prop-h1", "Обзоры");
?> 	 
<div class="contents">
	<div class="article-container">
		<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"obzor", 
	array(
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "#REVIEWS_IBLOCK_ID#",
		"NEWS_COUNT" => "10",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "PREVIEW_TEXT",
			3 => "PREVIEW_PICTURE",
			4 => "SHOW_COUNTER",
			5 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d F Y",
		"SET_TITLE" => "Y",
		"SET_STATUS_404" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"THEME_CODE" => "tmpl_2",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"TITLE" => ""
	),
	false
);?>
	</div>
	<div class="aside">
		<?
			// включаема§ область дл§ раздела
			$APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_contacts.php", Array(), Array(
				"MODE"      => "php",                                           // будет редактировать в веб-редакторе
				"NAME"      => "Bиджет контактов",      // текст всплывающей подсказки на иконке
				"TEMPLATE"  => "section_include_template.php"                    // им§ шаблона дл§ нового файла
			));
		?>

		<?
			// включаема§ область дл§ раздела
			$APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_preferences.php", Array(), Array(
				"MODE"      => "php",                                           // будет редактировать в веб-редакторе
				"NAME"      => "Bиджет контактов",      // текст всплывающей подсказки на иконке
				"TEMPLATE"  => "section_include_template.php"                    // им§ шаблона дл§ нового файла
			));
		?>

		<?
			// включаема§ область дл§ раздела
			$APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_reviews.php", Array(), Array(
				"MODE"      => "html",                                           // будет редактировать в веб-редакторе
				"NAME"      => "Bиджет контактов",      // текст всплывающей подсказки на иконке
				"TEMPLATE"  => "section_include_template.php"                    // им§ шаблона дл§ нового файла
			));
		?>
	</div>
</div>
<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>