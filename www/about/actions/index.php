<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Акции");
    $APPLICATION->SetPageProperty("prop-h1", "Акции");
?>
<div class="contents">
    <div class="left-content">
        <?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"actions", 
	array(
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "2",
		"NEWS_COUNT" => "10",
		"USE_SEARCH" => "N",
		"USE_RSS" => "N",
		"USE_RATING" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"SORT_BY1" => "DATE_ACTIVE_TO",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "",
		"SORT_ORDER2" => "",
		"CHECK_DATES" => "N",
		"SEF_MODE" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_ELEMENT_CHAIN" => "N",
		"USE_PERMISSIONS" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"USE_SHARE" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"LIST_ACTIVE_DATE_FORMAT" => "",
		"LIST_FIELD_CODE" => array(
			0 => "DATE_ACTIVE_TO",
			1 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "BG",
			1 => "",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"DISPLAY_NAME" => "Y",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"DETAIL_ACTIVE_DATE_FORMAT" => "",
		"DETAIL_FIELD_CODE" => array(
			0 => "DATE_ACTIVE_TO",
			1 => "",
		),
		"DETAIL_PROPERTY_CODE" => array(
			0 => "DETAIL_TITLE",
			1 => "BG",
			2 => "",
		),
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"PAGER_TEMPLATE" => "",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"TAGS_CLOUD_ELEMENTS" => "150",
		"PERIOD_NEW_TAGS" => "",
		"DISPLAY_AS_RATING" => "rating",
		"FONT_MAX" => "50",
		"FONT_MIN" => "10",
		"COLOR_NEW" => "3E74E6",
		"COLOR_OLD" => "C0C0C0",
		"TAGS_CLOUD_WIDTH" => "100%",
		"SEF_FOLDER" => "/about/actions/",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "",
			"detail" => "#ELEMENT_CODE#/",
		)
	),
	false
);?>
    </div>
    <div class="aside">
        <div class="widget">
            <form action="<?=SITE_DIR?>ajax/subscribe_action.php" name="subsc_action" class="aside-contact" method="post" >
                <fieldset>
                    <h3>Подписка на акции</h3>
                    <div class="row">
                        <input type="email" required name="EMAIL" class="text" placeholder="Ваш Email" value="" />
                    </div>
                    <div class="row">
                        <input type="submit" class="button" value="Подписаться" />
                    </div>
                </fieldset>
            </form>
        </div>
       <?
            // включаема§ область дл§ раздела
            $APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_contacts.php", Array(), Array(
                "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                "NAME"      => "Виджет контактов",      // текст всплывающей подсказки на иконке
                "TEMPLATE"  => "section_include_template.php"                    // им§ шаблона дл§ нового файла
            ));
        ?>
    </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>