<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetPageProperty("prop-h1", "Отзывы");
    $APPLICATION->SetTitle("Отзывы");
?>
<div class="contents">
    <div class="article-container">
      
      <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"reviews", 
	array(
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "#SHOPREVIEWS_IBLOCK_ID#",
		"NEWS_COUNT" => "6",
		"SORT_BY1" => "DATE_CREATE",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "",
		"SORT_ORDER2" => "",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "DATE_CREATE",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "RATING",
			1 => "POSITION",
			2 => "AVATAR",
			3 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "j F Y H:i",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_STATUS_404" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Отзывы",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>
        
        <div class="some-holder">
            <div class="comments-board">

                <?$APPLICATION->IncludeComponent(
	"advent:iblock.comments", 
	"reviews", 
	array(
		"USE_CAPTCHA" => "Y",
		"SUCCESS_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "",
		"IBLOCK_ID" => "#SHOPREVIEWS_IBLOCK_ID#",
		"SHOW_BASE_FIELDS" => array(
			0 => "NAME",
			1 => "MESSAGE",
		),
		"REQUIRED_BASE_FIELDS" => array(
			0 => "NAME",
			1 => "MESSAGE",
		),
		"SHOW_FIELDS" => array(
			0 => "AUTHOR_EMAIL",
			1 => "RATING",
			2 => "AVATAR",
		),
		"REQUIRED_FIELDS" => array(
			0 => "AUTHOR_EMAIL",
		),
		"EVENT_MESSAGE_ID" => array(
			0 => "37",
		),
		"ELEMENT_ID" => "",
		"ACTIVATE" => "Y",
		"AJAX_MODE" => "Y",
		"EMAIL_FIELD" => "AUTHOR_EMAIL",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>


            </div>

        </div>
    </div>
       <?
        // включаемая область для раздела
        $APPLICATION->IncludeFile(SITE_DIR."include/parts/main-right-banners.php", Array(), Array(
            "MODE"      => "html",                                           // будет редактировать в веб-редакторе
            "NAME"      => "",      // текст всплывающей подсказки на иконке
            "TEMPLATE"  => "section_include_template.php"                    // имя шаблона для нового файла
        ));
    ?>
    
</div>
<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>