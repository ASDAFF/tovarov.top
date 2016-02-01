<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("BRSOFT_FC_COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("BRSOFT_FC_COMPONENT_DESCR"),
	"ICON" => "/images/feedback.gif",
	"PATH" => array(
		"ID" => "brsoft",
		"NAME" => "BrSoft",
		"CHILD" => array(
			"ID" => "brsoft_form",
			"NAME" => GetMessage("BRSOFT_FC_COMPONENT_NAME")
		)
	),
);
?>