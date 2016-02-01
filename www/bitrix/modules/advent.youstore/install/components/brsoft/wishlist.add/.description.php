<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
//TODO: перенести все в lang
$arComponentDescription = array(
	"NAME" => GetMessage("BRSOFT_WL_COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("BRSOFT_WL_COMPONENT_DESCRIPTION"),
	"ICON" => "/images/menu_ext.gif",
	"CACHE_PATH" => "N",
	"PATH" => array(
		"ID" => "brsoft",
		"NAME" => "BrSoft",
		"CHILD" => array(
			"ID" => "brsoft_wishlist",
			"NAME" => "Wishlist"
		)
	),
);
?>