<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = Array(
	"PARAMETERS" => Array(
		"PATH_TO_BASKET" => Array(
			"NAME" => GetMessage("SBBS_PATH_TO_BASKET"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "/personal/basket.php",
			"COLS" => 25,
			"PARENT" => "ADDITIONAL_SETTINGS",
		),
        "PATH_TO_ORDER" => Array(
            "NAME" => GetMessage("SBBS_PATH_TO_ORDER"),
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
            "DEFAULT" => "/personal/order.php",
            "COLS" => 25,
            "PARENT" => "ADDITIONAL_SETTINGS",
        ),
		"PATH_TO_WISHLIST" => Array(
            "NAME" => GetMessage("SBBS_PATH_TO_WISHLIST"),
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
            "DEFAULT" => "/personal/wishlist/",
            "COLS" => 25,
            "PARENT" => "ADDITIONAL_SETTINGS",
        ),"PATH_TO_VISITED" => Array(
			"NAME" => GetMessage("SBBS_PATH_TO_VISITED"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "/personal/visited/",
			"COLS" => 25,
			"PARENT" => "ADDITIONAL_SETTINGS",
		),
		"SHOW_DELAY" => array(
			"NAME" => GetMessage('SBBS_SHOW_DELAY'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"MULTIPLE" => "N",
		),
		"SHOW_NOTAVAIL" => array(
			"NAME" => GetMessage('SBBS_SHOW_NOTAVAIL'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"MULTIPLE" => "N",
		),
		"SHOW_SUBSCRIBE" => array(
			"NAME" => GetMessage('SBBS_SHOW_SUBSCRIBE'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"MULTIPLE" => "N",
		),
        "DISPLAY_IMG_WIDTH" => Array(
            "NAME" => GetMessage("LIST_PARAMETERS_IMG_WIDTH"),
            "TYPE" => "TEXT",
            "DEFAULT" => "70",
        ),
        "DISPLAY_IMG_HEIGHT" => Array(
            "NAME" => GetMessage("LIST_PARAMETERS_IMG_HEIGHT"),
            "TYPE" => "TEXT",
            "DEFAULT" => "89",
        ),
        "DISPLAY_IMG_PROP" => Array(
            "NAME" => GetMessage("LIST_PARAMETERS_IMG_PROP"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ),
        "COMPARE_URL" => array(
            "NAME" => GetMessage("IBLOCK_COMPARE_URL"),
            "TYPE" => "STRING",
            "DEFAULT" => "compare.php"
        ),
        "NAME" => array(
            "NAME" => GetMessage("IBLOCK_COMPARE_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => "CATALOG_COMPARE_LIST"
        ),
	)
);
?>