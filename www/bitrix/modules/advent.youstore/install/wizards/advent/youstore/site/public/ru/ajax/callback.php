<?
define('SITE_ID', '#SITE_ID#');
define('SITE_DIR', '#SITE_DIR#');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); 
?>
<div class="popup call-popup" id="recall" style="display: block!important; position: relative;">
    <div class="holder">
        <a href="#" class="btn-close">close</a>
        <div class="title">
            <h2>МЫ ВАМ ПЕРЕЗВОНИМ</h2>
            <p><?
				$APPLICATION->IncludeFile(SITE_DIR."include/callback_we_works.php", Array(), Array(
					"MODE"      => "html",
					"NAME"      => GetMessage('HEADER_INFO'),
					"TEMPLATE"  => "section_include_template.php"
				));
			?></p>
        </div>
        <? include($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/functions.php');
        $APPLICATION->IncludeComponent(
                "advent:iblock.element.add.form",
                ".default",
                Array(
                    "IBLOCK_TYPE" => "requests",
                    "IBLOCK_ID" => "#CALLBACK_S1_IBLOCK_ID#",
                    "STATUS_NEW" => "N",
                    "LIST_URL" => "",
                    "SECTION_CODE" => "",
                    "POST_TEMPLATE" => "CALLBACK",
                    "USE_CAPTCHA" => "N",
                    "USER_MESSAGE_EDIT" => "",
                    "USER_MESSAGE_ADD" => "",
                    "DEFAULT_INPUT_SIZE" => "30",
                    "RESIZE_IMAGES" => "N",
                    "PROPERTY_CODES" => array(0=>"NAME",1=>findId('PHONE_CALLBACK'),2=>findId('TOVAR_CALLBACK'),),
                    "PROPERTY_CODES_REQUIRED" => array(0=>"NAME",1=>findId('PHONE_CALLBACK'),),
                    "GROUPS" => array(0=>"2",),
                    "STATUS" => "ANY",
                    "ELEMENT_ASSOC" => "CREATED_BY",
                    "MAX_USER_ENTRIES" => "100000",
                    "MAX_LEVELS" => "100000",
                    "LEVEL_LAST" => "Y",
                    "MAX_FILE_SIZE" => "0",
                    "PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
                    "DETAIL_TEXT_USE_HTML_EDITOR" => "N",
                    "SEF_MODE" => "N",
                    "CUSTOM_TITLE_NAME" => "Ваше имя",
                    "CUSTOM_TITLE_TAGS" => "",
                    "CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
                    "CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
                    "CUSTOM_TITLE_IBLOCK_SECTION" => "",
                    "CUSTOM_TITLE_PREVIEW_TEXT" => "",
                    "CUSTOM_TITLE_PREVIEW_PICTURE" => "",
                    "CUSTOM_TITLE_DETAIL_TEXT" => "",
                    "CUSTOM_TITLE_DETAIL_PICTURE" => "",
                    "AJAX_MODE" => "Y",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => ""
                )
            );?>
    </div>
</div>