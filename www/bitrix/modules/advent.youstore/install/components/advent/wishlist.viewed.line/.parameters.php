<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = Array(
	"PARAMETERS" => Array(
		"PATH_TO_WISHLIST" => Array(
            "NAME" => GetMessage("SBBS_PATH_TO_WISHLIST"),
            "TYPE" => "STRING",
            "MULTIPLE" => "N",
            "DEFAULT" => "/personal/wishlist/",
            "COLS" => 25,
            "PARENT" => "ADDITIONAL_SETTINGS",
        ),
		"PATH_TO_VISITED" => Array(
			"NAME" => GetMessage("SBBS_PATH_TO_VISITED"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "/personal/visited/",
			"COLS" => 25,
			"PARENT" => "ADDITIONAL_SETTINGS",
		),
		"VIEWED_COUNT" => Array(
			"NAME" => GetMessage("VIEWED_COUNT"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "5",
			"COLS" => 5,
			"PARENT" => "BASE",
		),
	)
);
?>