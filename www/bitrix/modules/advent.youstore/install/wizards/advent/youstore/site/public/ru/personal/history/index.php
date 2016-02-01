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
            <?
                if($USER->IsAuthorized()){
                    $_REQUEST["show_all"] = "Y";

                    $APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order.list", 
	".default", 
	array(
		"IMG_PROPERTY" => "MORE_PHOTO",
		"PATH_TO_DETAIL" => "",
		"PATH_TO_COPY" => "",
		"PATH_TO_CANCEL" => "",
		"PATH_TO_BASKET" => "",
		"ORDERS_PER_PAGE" => "20",
		"ID" => $ID,
		"SET_TITLE" => "Y",
		"SAVE_IN_SESSION" => "N",
		"NAV_TEMPLATE" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_GROUPS" => "Y",
		"HISTORIC_STATUSES" => array(
		),
		"PATH_TO_PAYMENT" => SITE_DIR."personal/history/payment.php"
	),
	false
);
                }else{
                    $APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "", Array(
                            "REGISTER_URL" => "#fancybox01",
                            "PROFILE_URL" => SITE_DIR."personal/",
                            "SHOW_ERRORS" => "Y"
                        ),
                        false
                    );
                }
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