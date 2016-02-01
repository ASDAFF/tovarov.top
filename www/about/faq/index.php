<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetPageProperty("prop-h1", "Часто задаваемые вопросы");
	$APPLICATION->SetTitle("Часто задаваемые вопросы");
?>
	<div class="contents">
		<div class="article-container">
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"faq",
				Array(
					"DISPLAY_DATE" => "Y",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"AJAX_MODE" => "N",
					"IBLOCK_TYPE" => "content",
					"IBLOCK_ID" => "5",
					"NEWS_COUNT" => "20",
					"SORT_BY1" => "ACTIVE_FROM",
					"SORT_ORDER1" => "DESC",
					"SORT_BY2" => "SORT",
					"SORT_ORDER2" => "ASC",
					"FILTER_NAME" => "",
					"FIELD_CODE" => Array("ID"),
					"PROPERTY_CODE" => Array(),
					"CHECK_DATES" => "Y",
					"DETAIL_URL" => "",
					"PREVIEW_TRUNCATE_LEN" => "",
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
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
		</div>
		<div class="aside">
			<?
				// включаема§ область дл§ раздела
				$APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_contacts.php", Array(), Array(
					"MODE"      => "php",                                           // будет редактировать в веб-редакторе
					"NAME"      => "Виджет контактов",      // текст всплывающей подсказки на иконке
					"TEMPLATE"  => "section_include_template.php"                    // им§ шаблона дл§ нового файла
				));
			?>

			<?
				// включаема§ область дл§ раздела
				$APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_preferences.php", Array(), Array(
					"MODE"      => "php",                                           // будет редактировать в веб-редакторе
					"NAME"      => "Виджет контактов",      // текст всплывающей подсказки на иконке
					"TEMPLATE"  => "section_include_template.php"                    // им§ шаблона дл§ нового файла
				));
			?>

			<?
				// включаема§ область дл§ раздела
				$APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_reviews.php", Array(), Array(
					"MODE"      => "html",                                           // будет редактировать в веб-редакторе
					"NAME"      => "Виджет контактов",      // текст всплывающей подсказки на иконке
					"TEMPLATE"  => "section_include_template.php"                    // им§ шаблона дл§ нового файла
				));
			?>
		</div>
	</div>
<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>