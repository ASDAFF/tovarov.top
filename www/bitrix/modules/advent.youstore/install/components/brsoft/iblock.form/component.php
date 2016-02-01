<?
######################################################
# Name: br-soft                                      #
# (c) 2012-2014 br-soft                              #
# http://br-soft.ru/                                 #
# mailto:info@br-soft.ru                             #
######################################################
?>
<?php

setlocale( LC_NUMERIC, '' );

if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
require_once("functions.php");
CJSCore::Init(array("date"));
if(!(CModule::IncludeModule("iblock"))) return;

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 *
 * Supported iblock usertypes is: S, T, D, L, C, E, G, F. H - is HTML|text
 */

$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());

$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");

$arParams["SEND_EMAIL"] = trim($arParams["SEND_EMAIL"]);

$arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"]);
if($arParams["EVENT_NAME"] == '')
    $arParams["EVENT_NAME"] = "BRSOFT_SEND_MAIL";

$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
if($arParams["EMAIL_TO"] == '')
    $arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");

$arParams["SUCCESS_TEXT"] = trim($arParams["SUCCESS_TEXT"]);
if($arParams["SUCCESS_TEXT"] == '')
    $arParams["SUCCESS_TEXT"] = GetMessage("BRSOFT_FC_OK_MESSAGE");

$showBaseFields = $arParams["SHOW_BASE_FIELDS"];
$reqBaseFields = $arParams["REQUIRED_BASE_FIELDS"];

$showFields = $arParams["SHOW_FIELDS"];
$reqFields = $arParams["REQUIRED_FIELDS"];

$iblock_id = $arParams["IBLOCK_ID"];

$arParams["CACHE_TIME"] = "36000";
$arParams["CACHE_TYPE"] = (defined("ERROR_404")?"N":"A");

if ($this->InitComponentTemplate())
{
    $template = & $this->GetTemplate();
    $folderPath = $template->GetFolder();
    $cPrologPath = $_SERVER["DOCUMENT_ROOT"].$folderPath."/component_prolog.php";
    if (strlen($folderPath) > 0 && file_exists($cPrologPath))
    {
        include_once($cPrologPath);
    }
}


if ($this->StartResultCache(36000, false))
{

    $arResult["FIELDS"] = array();
    $arResult["BASE_FIELDS"] = array();
    $sort = 10;

    foreach($showBaseFields as $baseField){

        $msgName = "BRSOFT_FC_".$baseField;

        $arField = array(
            "CODE" => $baseField,
            "REQUIRED" => (in_array($baseField, $reqBaseFields)?true:false),
            "NAME" => GetMessage($msgName),
            "SORT" => $sort,
            "TYPE" => "BASE",
            "HINT" => GetMessage($msgName),
            "INPUT_TYPE" => (($baseField == "NAME")?"S":"T"),

        );

        $arResult["FIELDS"][] = $arField;
        $sort += 100;
    }

    foreach($showFields as $field){
        $arField = array(
            "TYPE" => "PROPERTY"
        );

        $dbField = CIBlockProperty::GetByID($field, $iblock_id);

        if($rsField = $dbField->GetNext()){
            $input_type = "S";//default value
            switch($rsField["PROPERTY_TYPE"]){
                case 'S':
                    switch($rsField["USER_TYPE"]){
                        case 'DateTime':
                            $input_type = "D";
                            break;
                        case 'HTML': $input_type = "H";break;// html/text usertype
                        default:
                            if($rsField["ROW_COUNT"] > 1) $input_type = "T"; else $input_type = "S";
                            break;
                    }
                    break;
                case 'L':
                    $input_type = $rsField["LIST_TYPE"];//L or C
                    break;
                case 'N':
                    $input_type = "S";//for number type
                    break;
                case 'E':
                case 'G':
                    $input_type = $rsField["PROPERTY_TYPE"]; //E or G: element or group (link to iblock)
                    break;
                case 'F':
                default:
                    $input_type = $rsField["PROPERTY_TYPE"]; //F: file
                    break;
            }

            $arField["SORT"] = $rsField["SORT"];
            $arField["NAME"] = $rsField["NAME"];
            $arField["CODE"] = $rsField["CODE"];
            $arField["HINT"] = $rsField["HINT"];
            $arField["REQUIRED"] = (in_array($field, $reqFields)?true:false);
            $arField["INPUT_TYPE"] = $input_type;
            $arField["PLACEHOLDER"] = $rsField["DEFAULT_VALUE"];
			$arField["MULTIPLE"] = $rsField["MULTIPLE"];
            $arField["PROPERTY_DEF"] = $rsField;
        }

        $listTypes = array("L", "C");
        if(in_array($arField["INPUT_TYPE"], $listTypes, true)){
            $arField["VALUES"] = array();
            $dbEnums = CIBlockPropertyEnum::GetList(Array("SORT" => "ASC", "DEF" => "DESC"), Array("IBLOCK_ID" => $iblock_id, "PROPERTY_ID" => $rsField["ID"]));
            while($rsEnums = $dbEnums->GetNext()){
                $arField["VALUES"][$rsEnums["ID"]] = $rsEnums["VALUE"];
            }
        }

        if(in_array($arField["INPUT_TYPE"], array("E", "G"))){
            if($arField["INPUT_TYPE"] == "E"){

                $property_E_Filter = array(
                    "IBLOCK_ID" => $rsField["LINK_IBLOCK_ID"],
                    "ACTIVE" => "Y"
                );

                $arField["VALUES"] = array();

                $db_element_E = CIBlockElement::GetList(array("SORT" => "ASC"), $property_E_Filter, array("ID", "NAME"));
                while($ar_element_E = $db_element_E->GetNext()){
                    $arField["VALUES"][$ar_element_E["ID"]] = $ar_element_E["NAME"];
                }
            }
            else{
                $property_G_Filter = array(
                    "IBLOCK_ID" => $rsField["LINK_IBLOCK_ID"],
                    "ACTIVE" => "Y"
                );

                $arField["VALUES"] = array();

                $db_element_G = CIBlockSection::GetList(array("SORT" => "ASC"), $property_G_Filter, array("ID", "NAME"));
                while($ar_element_G = $db_element_G->GetNext()){
                    $arField["VALUES"][$ar_element_G["ID"]] = $ar_element_G["NAME"];
                }
            }

            $arField["LINK_IBLOCK_ID"] = $rsField["LINK_IBLOCK_ID"]; //linked iblock id
        }

        $arResult["FIELDS"][] = $arField;
    }

    uasort($arResult["FIELDS"], 'fCmp'); //sort fields by SORT feld from iblock

    $this->EndResultCache();
}


if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["submit"]) && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"]))
{
    $arResult["ERROR_MESSAGE"] = array();
    if(check_bitrix_sessid())
    {
        //handling errors in filled fields
        foreach($arResult["FIELDS"] as $v){

            $check_v = $_POST[$v["CODE"]];
            if(is_array($check_v)) $check_v = array_filter($check_v);
            else $check_v = trim($check_v);

            if($v["REQUIRED"] && empty($check_v)){
                $arResult["ERROR_MESSAGE"][$v["CODE"]] = str_replace("#NAME#", $v["NAME"], GetMessage("BRSOFT_FC_REQ_FIELD"));
            }
        }

        //use bitrix captcha lib
        if($arParams["USE_CAPTCHA"] == "Y")
        {
            include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");

            $captcha_code = $_POST["captcha_sid"];
            $captcha_word = $_POST["captcha_word"];

            $cpt = new CCaptcha();
            $captchaPass = COption::GetOptionString("main", "captcha_password", "");

            if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0)
            {
                //check user captcha input
                if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass))
                    $arResult["ERROR_MESSAGE"][] = GetMessage("BRSOFT_FC_CAPTCHA_WRONG");
            }
            else{
                $arResult["ERROR_MESSAGE"][] = GetMessage("BRSOFT_FC_CAPTHCA_EMPTY");
            }
        }

        if(empty($arResult["ERROR_MESSAGE"]))
        {

            $arEventFields = Array(
                "AUTHOR" => $_POST["NAME"],
                "EMAIL_TO" => $arParams["EMAIL_TO"],
                "TEXT" => $_POST["MESSAGE"],
                "PARAMS" => ""
            );

            $arIBlockFields = array(
                "ACTIVE" => ($arParams["ACTIVATE"] != "N")?"Y":"N", //set flag ACTIVE from @component -> @arParams
                "IBLOCK_ID" => $iblock_id,
                "IBLOCK_SECTION_ID" => false //in the root of iblock
            );
			
            foreach($arResult["FIELDS"] as $f){
                switch($f["TYPE"]){
                    case "BASE":
                        $code = $f["CODE"];

                        if($f["CODE"] == "MESSAGE")
                            $code = "PREVIEW_TEXT";

                        $arIBlockFields[$code] = $_REQUEST[$f['CODE']];

                        $arEventFields["PARAMS"] .= $f["NAME"].": ".$_REQUEST[$f['CODE']]."\n";

                        break;
                    case "PROPERTY":
                        switch ($f["INPUT_TYPE"]){
                            case 'L':case'C':
                                foreach($f["VALUES"] as $k => $v){
                                    if(checkValueExists($v["ID"], $_REQUEST[$f["CODE"]])){
                                        $arEventFields["PARAMS"] .= $f["NAME"].": ".$v["NAME"]."\n";
                                    }
                                }
                                $arIBlockFields["PROPERTY_VALUES"][$f['CODE']] = prepareIBlockPropertyValue($_REQUEST[$f["CODE"]], $f);
                            break;
                            case 'F':
                                $arIBlockFields["PROPERTY_VALUES"][$f['CODE']] = prepareIBlockPropertyValue($_REQUEST[$f["CODE"]], $f);
                                break;
                            case 'E':
                                $curVal = "";
                                $linkVal = "";
                                if(empty($curVal)){
                                    $dbE = CIBlockElement::GetByID($_REQUEST[$f["CODE"]]);
                                    if($rsE = $dbE->GetNext()){
                                        $curVal = $rsE["NAME"].(!empty($rsE["ACTIVE_FROM"])?"(".$rsE["ACTIVE_FROM"].")":"")." [".$rsE["ID"]."]";
                                        $linkVal = "http://".$_SERVER["HTTP_HOST"].$rsE["DETAIL_PAGE_URL"];
                                    }
                                }

                                $arEventFields["PARAMS"] .= $f["NAME"].": ".$curVal."\n";
                                if(!empty($linkVal)){
                                    $arEventFields["PARAMS"] .= "Cсылка на ".$f["NAME"].": ".$linkVal."\n";
                                }

                                $arIBlockFields["PROPERTY_VALUES"][$f['CODE']] = prepareIBlockPropertyValue($_REQUEST[$f["CODE"]], $f);
                                break;
                            default:
                                $arEventFields["PARAMS"] .= $f["NAME"].": ".$_REQUEST[$f['CODE']]."\n";
                                $arIBlockFields["PROPERTY_VALUES"][$f['CODE']] = prepareIBlockPropertyValue($_REQUEST[$f["CODE"]], $f);
                                break;
                        }
                        break;
                    default:break;
                }
            }

            $el = new CIBlockElement;
            if(!($result = $el->Add($arIBlockFields))){
                $arResult["ERROR_MESSAGE"][] = $el->LAST_ERROR;
            }else{
                if(($rsIBlock = CIBlockElement::GetIBlockByID($result)) !== FALSE){
					$dbIBlock = CIBlock::GetByID($rsIBlock);
					if($arIBlock = $dbIBlock->GetNext()){
						$rsIBlockType = $arIBlock["IBLOCK_TYPE_ID"];
						$arEventFields["EDIT_LINK"] = "http://".$_SERVER["HTTP_HOST"]."/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=".$rsIBlock."&type=".$rsIBlockType."&ID=".$result."&lang=ru&find_section_section=-1&WF=Y";
					}
				}
            }

            if(empty($arResult["ERROR_MESSAGE"])){
				if($arParams["SEND_EMAIL"] == "Y"){
					if(!empty($arParams["EVENT_MESSAGE_ID"]))
					{
						foreach($arParams["EVENT_MESSAGE_ID"] as $v)
							if(IntVal($v) > 0)
								CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arEventFields, "N", IntVal($v));
					}
					else
						CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arEventFields);
				}
                $_SESSION["BRSOFT_FC_NAME"] = htmlspecialcharsbx($_POST["NAME"]);
                $_SESSION["BRSOFT_FC_EMAIL"] = htmlspecialcharsbx($_POST["AUTHOR_EMAIL"]);

                LocalRedirect($APPLICATION->GetCurPageParam("success=".$arResult["PARAMS_HASH"], Array("success")));
            }
        }

        foreach($arResult["FIELDS"] as $f){
            $arResult[$f["CODE"]] = htmlspecialcharsbx($_POST[$f["CODE"]]);
        }
    }
    else
        $arResult["ERROR_MESSAGE"][] = GetMessage("BRSOFT_FC_SESS_EXP");
}
elseif($_REQUEST["success"] == $arResult["PARAMS_HASH"]){

    $arResult["OK_MESSAGE"] = $arParams["SUCCESS_TEXT"];
}

if(empty($arResult["ERROR_MESSAGE"]))
{
    if($USER->IsAuthorized())
    {
        $arResult["NAME"] = $USER->GetFormattedName(false);
        $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($USER->GetEmail());
    }
    else
    {
        if(strlen($_SESSION["BRSOFT_FC_NAME"]) > 0)
            $arResult["NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
        if(strlen($_SESSION["BRSOFT_FC_EMAIL"]) > 0)
            $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_SESSION["MF_EMAIL"]);
    }
}


if($arParams["USE_CAPTCHA"] == "Y")
    $arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());

$this->ShowComponentTemplate();
