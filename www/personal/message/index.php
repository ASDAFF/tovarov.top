<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

    $APPLICATION->SetPageProperty("prop-h1", "Личный кабинет");
    $APPLICATION->SetPageProperty("prop-container-class", "account-page");

    $APPLICATION->SetTitle("Личный кабинет");
?>
<?
    //change data to save
    if(!empty($_POST["PERSONAL_BIRTHDAY_DAY"]) && !empty($_POST["PERSONAL_BIRTHDAY_MONTH"]) && !empty($_POST["PERSONAL_BIRTHDAY_YEAR"])){
        foreach(array("DAY", "MONTH", "YEAR") as $v){
            $_POST["PERSONAL_BIRTHDAY_".$v] = str_pad($_POST["PERSONAL_BIRTHDAY_".$v], 2, '0', STR_PAD_LEFT);
        }

        $_REQUEST["PERSONAL_BIRTHDAY"] = $_GET["PERSONAL_BIRTHDAY"] = $_POST["PERSONAL_BIRTHDAY"] = $_POST["PERSONAL_BIRTHDAY_DAY"].".".$_POST["PERSONAL_BIRTHDAY_MONTH"].".".$_POST["PERSONAL_BIRTHDAY_YEAR"];
    }

?>
<div class="account-holder">
    <?
        $APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"account-menu", 
	array(
		"ROOT_MENU_TYPE" => "left",
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		)
	),
	false
);
    ?>
    <div class="account-frames">
        <div class="title">
            <h2>ОСТАВЬТЕ ВАШЕ СООБЩЕНИЕ</h2>
        </div>
        <?
            $APPLICATION->IncludeComponent(
                "advent:main.feedback", 
                "personal", 
                array(
                    "USE_CAPTCHA" => "N",
                    "OK_TEXT" => "Спасибо, ваше сообщение принято.",
                    "EMAIL_TO" => COption::GetOptionString("main","email_from"),
                    "REQUIRED_FIELDS" => array(
                        0 => "NAME",
                        1 => "EMAIL",
                    ),
                    "EVENT_MESSAGE_ID" => array(
                        0 => "7",
                    ),
                    'AJAX_MODE'=>'Y'
                ),
                false
            );?>

        <?
            /* if($USER->IsAuthorized()){

            }else{
            $APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "", Array(
            "REGISTER_URL" => "#fancybox01",
            "PROFILE_URL" => "/personal/",
            "SHOW_ERRORS" => "Y"
            ),
            false
            );
            }  */
        ?>
    </div>
</div>
<?
    // включаемая область для раздела
    $APPLICATION->IncludeFile(SITE_DIR."include/parts/main-right-banners.php", Array(), Array(
            "MODE"      => "html",                                           // будет редактировать в веб-редакторе
            "NAME"      => "Баннеры",      // текст всплывающей подсказки на иконке
            "TEMPLATE"  => "section_include_template.php"                    // имя шаблона для нового файла
        ));
?>
<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>