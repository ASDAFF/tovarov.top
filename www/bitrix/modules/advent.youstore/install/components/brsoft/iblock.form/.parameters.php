<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!CModule::IncludeModule("iblock"))
	return;
	

$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
$arFilter = Array("TYPE_ID" => "BRSOFT_SEND_MAIL", "ACTIVE" => "Y");
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

$show_base_list = Array("NAME" => GetMessage("BRSOFT_FC_NAME"), "MESSAGE" => GetMessage("BRSOFT_FC_MESSAGE"));

$show_list = array();

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
$name_sort = array();
	$name_sort = Array(
		"NAME" => GetMessage("BRSOFT_FC_NAME_SORT_TITLE"), 
		"TYPE" => "STRING",
		"DEFAULT" => "10", 
		"PARENT" => "BASE"
	);

$message_sort = array();
	$message_sort = Array(
		"NAME" => GetMessage("BRSOFT_FC_MESSAGE_SORT_TITLE"), 
		"TYPE" => "STRING",
		"DEFAULT" => "100", 
		"PARENT" => "BASE"
	);


$arComponentParameters = array(
	"PARAMETERS" => array(
		"USE_CAPTCHA" => Array(
			"NAME" => GetMessage("BRSOFT_FC_CAPTCHA"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "BASE",
		),
		"SUCCESS_TEXT" => Array(
			"NAME" => GetMessage("BRSOFT_FC_OK_MESSAGE"), 
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("BRSOFT_FC_OK_TEXT"), 
			"PARENT" => "BASE",
		),
		"SEND_EMAIL" => Array(
			"NAME" => GetMessage("BRSOFT_FC_SEND_EMAIL"), 
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y", 
			"PARENT" => "BASE",
		),
		"EMAIL_TO" => Array(
			"NAME" => GetMessage("BRSOFT_FC_EMAIL_TO"), 
			"TYPE" => "STRING",
			"DEFAULT" => htmlspecialcharsbx(COption::GetOptionString("main", "email_from")), 
			"PARENT" => "BASE",
		),
		"IBLOCK_ID" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BRSOFT_FC_LIST_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"SHOW_BASE_FIELDS" => Array(
			"NAME" => GetMessage("BRSOFT_FC_SHOW_FIELDS"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"Y", 
			"VALUES" => $show_base_list,
			"DEFAULT"=>"", 
			"COLS"=>25, 
			"PARENT" => "BASE",
			"REFRESH" => "Y"
		),
		"NAME_SORT" => $name_sort,
		"MESSAGE_SORT" => $message_sort,
		"REQUIRED_BASE_FIELDS" => Array(
			"NAME" => GetMessage("BRSOFT_FC_REQUIRED_FIELDS"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"Y", 
			"VALUES" => $show_base_list,
			"DEFAULT"=>"", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		),
		"SHOW_FIELDS" => Array(
			"NAME" => GetMessage("BRSOFT_FC_SHOW_FIELDS"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"Y", 
			"VALUES" => $show_list,
			"DEFAULT"=>"", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		),
		"REQUIRED_FIELDS" => Array(
			"NAME" => GetMessage("BRSOFT_FC_REQUIRED_FIELDS"), 
			"TYPE"=>"LIST", 
			"MULTIPLE"=>"Y", 
			"VALUES" => $show_list,
			"DEFAULT"=>"", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		),
		"EVENT_MESSAGE_ID" => Array(
			"NAME" => GetMessage("BRSOFT_FC_EMAIL_TEMPLATES"), 
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