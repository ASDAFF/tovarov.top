<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!CModule::IncludeModule("iblock"))
	return;
	

$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
$arFilter = Array("TYPE_ID" => "FEEDBACK_FORM", "ACTIVE" => "Y");
if($site !== false)
	$arFilter["LID"] = $site;

$arEvent = Array();
$dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
while($arType = $dbType->GetNext())
	$arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["SUBJECT"];

$arIBlocks=Array();
$db_iblock = CIBlock::GetList(Array("SORT"=>"ASC"), Array("SITE_ID"=>$_REQUEST["site"]));

while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];
	
$iblock_id = $arCurrentValues["IBLOCK_ID"];

$show_base_list = Array("NAME" => GetMessage("MFP_NAME"), "MESSAGE" => GetMessage("MFP_MESSAGE"));

$show_list = array();//Array("NAME" => GetMessage("MFP_NAME"), "EMAIL" => "E-mail", "MESSAGE" => GetMessage("MFP_MESSAGE"));

if(intval($iblock_id) > 0){
	$show_list = array();
	$properties = CIBlockProperty::GetList(
		Array("sort" => "asc", "name" => "asc"),
		Array("ACTIVE" => "Y", "IBLOCK_ID" => $iblock_id)
	);
	while($prop = $properties->GetNext()){
		$show_list[$prop["CODE"]] = $prop["NAME"];
	}
}
	
$arComponentParameters = array(
	"PARAMETERS" => array(
    "AJAX_MODE" => array(),
		"USE_CAPTCHA" => Array(
            "NAME" => GetMessage("MFP_CAPTCHA"), 
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y", 
            "PARENT" => "BASE",
        ),
        "ACTIVATE" => Array(
			"NAME" => GetMessage("MFP_ACTIVATE"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N", 
			"PARENT" => "BASE",
		),
		"SUCCESS_TEXT" => Array(
			"NAME" => GetMessage("MFP_OK_MESSAGE"), 
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("MFP_OK_TEXT"), 
			"PARENT" => "BASE",
		),
		"EMAIL_TO" => Array(
			"NAME" => GetMessage("MFP_EMAIL_TO"), 
			"TYPE" => "STRING",
			"DEFAULT" => htmlspecialcharsbx(COption::GetOptionString("main", "email_from")), 
			"PARENT" => "BASE",
		),
		"IBLOCK_ID" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"SHOW_BASE_FIELDS" => Array(
			"NAME" => GetMessage("MFP_SHOW_FIELDS"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"Y", 
			"VALUES" => $show_base_list,
			"DEFAULT"=>"", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		),
		"REQUIRED_BASE_FIELDS" => Array(
			"NAME" => GetMessage("MFP_REQUIRED_FIELDS"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"Y", 
			"VALUES" => $show_base_list,
			"DEFAULT"=>"", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		),
		"SHOW_FIELDS" => Array(
            "NAME" => GetMessage("MFP_SHOW_FIELDS"), 
            "TYPE"=>"LIST", 
            "MULTIPLE"=>"Y", 
            "VALUES" => $show_list,
            "DEFAULT"=>"", 
            "COLS"=>25, 
            "PARENT" => "BASE",
        ),
        "EMAIL_FIELD" => Array(
			"NAME" => GetMessage("MFP_EMAIL_FIELD"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"N", 
			"VALUES" => $show_list,
			"DEFAULT"=>"", 
			"COLS"=>25, 
			"PARENT" => "BASE",
            "ADDITIONAL_VALUES" => "Y",
		),
		"REQUIRED_FIELDS" => Array(
			"NAME" => GetMessage("MFP_REQUIRED_FIELDS"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"Y", 
			"VALUES" => $show_list,
			"DEFAULT"=>"", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		),
		"EVENT_MESSAGE_ID" => Array(
			"NAME" => GetMessage("MFP_EMAIL_TEMPLATES"), 
			"TYPE"=>"LIST", 
			"VALUES" => $arEvent,
			"DEFAULT"=>"", 
			"MULTIPLE"=>"Y", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		)
	)
);


?>