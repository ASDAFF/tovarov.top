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
        <?$APPLICATION->IncludeComponent(
	"bitrix:main.profile", 
	"new", 
	array(
		"USER_PROPERTY_NAME" => "",
		"SET_TITLE" => "Y",
		"AJAX_MODE" => "N",
		"USER_PROPERTY" => array(
		),
		"SEND_INFO" => "N",
		"CHECK_RIGHTS" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>
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