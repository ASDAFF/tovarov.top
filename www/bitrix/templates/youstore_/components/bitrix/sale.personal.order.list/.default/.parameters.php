<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arTemplateParameters = array(
    "IMG_PROPERTY" => array(
        "NAME" => GetMessage("IMG_PROPERTY"),
        "TYPE" => "STRING",
        "MULTIPLE" => "N",
        "DEFAULT" => "",
        "PARENT" => "BASE",
    ), 
      "PATH_TO_PAYMENT" => array(
        "NAME" => GetMessage("PATH_TO_PAY"),
        "TYPE" => "STRING",
        "MULTIPLE" => "N",
        "DEFAULT" => "",
        "PARENT" => "BASE",
    ),
);
?>