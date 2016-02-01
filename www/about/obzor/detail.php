<? 
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("page-image", "/about/obzor/back.png");
?>
<div class="contents">
	<div class="article-container">
		<?$ID=$APPLICATION->IncludeComponent("bitrix:news.detail", "obzor", Array(
	"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"USE_SHARE" => "Y",
		"SHARE_HIDE" => "N",
		"SHARE_TEMPLATE" => "",                        
		"SHARE_HANDLERS" => "",
		"SHARE_SHORTEN_URL_LOGIN" => "",
		"SHARE_SHORTEN_URL_KEY" => "",
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"IBLOCK_TYPE" => "content",	// Тип информационного блока (используется только для проверки)
		"IBLOCK_ID" => "9",	// Код информационного блока
		"ELEMENT_ID" => "",	// ID новости
		"ELEMENT_CODE" => $_REQUEST["CODE"],	// Код новости
		"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
		"FIELD_CODE" => array(	// Поля
			0 => "ID",
			1 => "CREATED_BY",
			2 => "",
		),
		"PROPERTY_CODE" => array(	// Свойства
			0 => "",
			1 => "TAB_1_TYPE",
			2 => "TAB_1_TEXT",
			3 => "TAB_2_TYPE",
			4 => "TAB_2_TEXT",
			5 => "",
			6 => "",
		),
		"META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
		"META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
		"BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
		"DISPLAY_PANEL" => "Y",
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"SET_STATUS_404" => "Y",	// Устанавливать статус 404, если не найдены элемент или раздел
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
		"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
		"ADD_ELEMENT_CHAIN" => "Y",	// Включать название элемента в цепочку навигации
		"ACTIVE_DATE_FORMAT" => "d F, Y",	// Формат показа даты
		"USE_PERMISSIONS" => "N",	// Использовать дополнительное ограничение доступа
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"DISPLAY_TOP_PAGER" => "Y",	// Выводить над списком
		"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
		"PAGER_TITLE" => "Страница",	// Название категорий
		"PAGER_TEMPLATE" => "",	// Шаблон постраничной навигации
		"PAGER_SHOW_ALL" => "Y",	// Показывать ссылку "Все"
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"IBLOCK_URL" => "",	// URL страницы просмотра списка элементов (по умолчанию - из настроек инфоблока)
		"SET_BROWSER_TITLE" => "Y",	// Устанавливать заголовок окна браузера
		"SET_META_KEYWORDS" => "Y",	// Устанавливать ключевые слова страницы
		"SET_META_DESCRIPTION" => "Y",	// Устанавливать описание страницы
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
	),
	false
);?> 
		
		<?
		$arrFilter["!ID"] = $ID;
		$APPLICATION->IncludeComponent(
			"bitrix:news.list", 
			"obzor",  
			array(
				"TITLE" => "Другие обзоры",
				"DISPLAY_DATE" => "Y",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"AJAX_MODE" => "N",
				"IBLOCK_TYPE" => "content",
				"IBLOCK_ID" => "9",
				"NEWS_COUNT" => "5",
				"SORT_BY1" => "ACTIVE_FROM",
				"SORT_ORDER1" => "DESC",
				"SORT_BY2" => "SORT",
				"SORT_ORDER2" => "ASC",
				"FILTER_NAME" => "arrFilter",
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
				"ACTIVE_DATE_FORMAT" => "j M",
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
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => "",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => ""
			),
			false
		);?>
	</div>
	<?
		// включаемая область дл¤ раздела
		$APPLICATION->IncludeFile(SITE_DIR."include/parts/main-right-banners.php", Array(), Array(
			"MODE"      => "html",                                           // будет редактировать в веб-редакторе
			"NAME"      => "Баннеры",      // текст всплывающей подсказки на иконке
			"TEMPLATE"  => "section_include_template.php"                    // им¤ шаблона дл¤ нового файла
		));
	?>
</div>
<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>