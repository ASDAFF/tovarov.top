<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!CModule::IncludeModule("iblock"))
    return false;

$arTemplateParameters = array(
    "ELEMENT_ID" => array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("FIELD_ELEMENT_ID_NAME"),
        "TYPE" => "STRING",
        "MULTIPLE" => "N",
        "DEFAULT" => ""
    )
);
?>