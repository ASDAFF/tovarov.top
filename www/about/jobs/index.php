<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Вакансии");
    $APPLICATION->SetPageProperty("prop-h1", "Вакансии");
?> 	 
<div class="contents">
    <div class="article-container">
        <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                    "AREA_FILE_SHOW" => "page", 
                    "AREA_FILE_SUFFIX" => "inc", 
                    "AREA_FILE_RECURSIVE" => "Y", 
                    "EDIT_TEMPLATE" => "standard.php" 
                )
            );?>
        <div class="job-offers">
            <?$APPLICATION->IncludeComponent(
                    "bitrix:news.list", 
                    "jobs", 
                    array(
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "AJAX_MODE" => "N",
                        "IBLOCK_TYPE" => "content",
                        "IBLOCK_ID" => "15",
                        "NEWS_COUNT" => "9999",
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
                        "AJAX_OPTION_ADDITIONAL" => ""
                    ),
                    false
                );?>
        </div>
        <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "team",
                Array(
                    "IBLOCK_TYPE" => "content",
                    "IBLOCK_ID" => "12",
                    "NEWS_COUNT" => "20",
                    "SORT_BY1" => "",
                    "SORT_ORDER1" => "",
                    "SORT_BY2" => "",
                    "SORT_ORDER2" => "",
                    "FILTER_NAME" => "",
                    "FIELD_CODE" => array("",""),
                    "PROPERTY_CODE" => array("POSITION",""),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "",
                    "SET_TITLE" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_STATUS_404" => "N",
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
                    "PAGER_TEMPLATE" => "",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "PAGER_TITLE" => "Новости",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "Y"
                )
            );?>
    </div>
    <div class="aside">
        <?
            // включаемаІ область длІ раздела
            $APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_contacts.php", Array(), Array(
                    "MODE"      => "php",                                           // будет редактировать в веб-редакторе
                    "NAME"      => "Виджет контактов",      // текст всплывающей подсказки на иконке
                    "TEMPLATE"  => "section_include_template.php"                    // имІ шаблона длІ нового файла
                ));
        ?>

        <?
            // включаемаІ область длІ раздела
            $APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_preferences.php", Array(), Array(
                    "MODE"      => "php",                                           // будет редактировать в веб-редакторе
                    "NAME"      => "Виджет контактов",      // текст всплывающей подсказки на иконке
                    "TEMPLATE"  => "section_include_template.php"                    // имІ шаблона длІ нового файла
                ));
        ?>

        <?
            // включаемаІ область длІ раздела
            $APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_reviews.php", Array(), Array(
                    "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                    "NAME"      => "Виджет контактов",      // текст всплывающей подсказки на иконке
                    "TEMPLATE"  => "section_include_template.php"                    // имІ шаблона длІ нового файла
                ));
        ?>
    </div>
</div>
<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>