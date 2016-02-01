<?
define('SITE_ID', '#SITE_ID#');
define('SITE_DIR', '#SITE_DIR#');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); 
?>
<div class="popup reg-popup" id="register" style="display: block!important; position: relative;">
    <div class="holder">
        <a href="#" class="btn-close">close</a>
        <?$APPLICATION->IncludeComponent(
                "bitrix:main.register",
                "",
                Array(
                    "USER_PROPERTY_NAME" => "", 
                    "SEF_MODE" => "Y", 
                    "SHOW_FIELDS" => Array(), 
                    "REQUIRED_FIELDS" => Array(), 
                    "AUTH" => "Y", 
                    "USE_BACKURL" => "Y", 
                    "SUCCESS_PAGE" => "", 
                    "SET_TITLE" => "Y", 
                    "USE_CAPTCHA" => "Y",
                    "USER_PROPERTY" => Array(), 
                    "SEF_FOLDER" => "/", 
                    "VARIABLE_ALIASES" => Array(),
					"AJAX_MODE" => "Y",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => ""
                )
            );?>
    </div>
</div>