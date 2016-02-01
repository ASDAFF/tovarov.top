<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/*************************************************************************
	Processing of received parameters
*************************************************************************/
if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

if(strlen($arParams["FILTER_NAME"])<=0)
	$arParams["FILTER_NAME"] = "fFilter";
$arParams["FILTER_NAME"] = trim($arParams["FILTER_NAME"]);

global $$arParams["FILTER_NAME"];
	$arrFilter = $GLOBALS[$arParams["FILTER_NAME"]];
	if(!is_array($arrFilter))
		$arrFilter = array();

if(strlen($arParams["SECT_FILTER_NAME"])<=0)
	$arParams["SECT_FILTER_NAME"] = "fsFilter";
$arParams["SECT_FILTER_NAME"] = trim($arParams["SECT_FILTER_NAME"]);


global $$arParams["SECT_FILTER_NAME"];
	$arrSectFilter = $GLOBALS[$arParams["SECT_FILTER_NAME"]];
	if(!is_array($arrSectFilter))
		$arrSectFilter = array();


$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);
$arParams["SECTION_ID"] = intval($arParams["SECTION_ID"]);
$arParams["SECTION_CODE"] = trim($arParams["SECTION_CODE"]);

$arParams["ELEMENT_INCLUDE_SUBSECTIONS"] = $arParams["ELEMENT_INCLUDE_SUBSECTIONS"]?:"N";

$arParams["SECTION_URL"]=trim($arParams["SECTION_URL"]);

$arParams["TOP_DEPTH"] = intval($arParams["TOP_DEPTH"]);
if($arParams["TOP_DEPTH"] <= 0)
	$arParams["TOP_DEPTH"] = 2;
$arParams["COUNT_ELEMENTS"] = $arParams["COUNT_ELEMENTS"]!="N";
$arParams["ADD_SECTIONS_CHAIN"] = $arParams["ADD_SECTIONS_CHAIN"]!="N"; //Turn on by default

$arResult["SECTIONS"]=array();

if($arParams["DISPLAY_TOP_PAGER"] || $arParams["DISPLAY_BOTTOM_PAGER"])
{
	$arNavParams = array(
		"nPageSize" => $arParams["NEWS_COUNT"],
		"bDescPageNumbering" => $arParams["PAGER_DESC_NUMBERING"] == "Y",
		"bShowAll" => $arParams["PAGER_SHOW_ALL"],
	);
	$arNavigation = CDBResult::GetNavParams($arNavParams);
	if($arNavigation["PAGEN"]==0 && $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"]>0)
		$arParams["CACHE_TIME"] = $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"];
}
else
{
	$arNavParams = array(
		"nTopCount" => $arParams["NEWS_COUNT"],
		"bDescPageNumbering" => $arParams["PAGER_DESC_NUMBERING"],
	);
	$arNavigation = false;
}

/*************************************************************************
			Work with cache
*************************************************************************/
if($this->StartResultCache(false, array(($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups()), $arNavigation, $arrFilter, $arrSectFilter)))
{
	if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	
	$arFilter = array(
		"ACTIVE" => "Y",
		"GLOBAL_ACTIVE" => "Y",
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"CNT_ACTIVE" => "Y",
	);

	$arSelect = array();
	if(isset($arParams["SECTION_FIELDS"]) && is_array($arParams["SECTION_FIELDS"]))
	{
		foreach($arParams["SECTION_FIELDS"] as $field)
			if(is_string($field) && !empty($field))
				$arSelect[] = $field;
	}

	if(!empty($arSelect))
	{
		$arSelect[] = "ID";
		$arSelect[] = "NAME";
		$arSelect[] = "LEFT_MARGIN";
		$arSelect[] = "RIGHT_MARGIN";
		$arSelect[] = "DEPTH_LEVEL";
		$arSelect[] = "IBLOCK_ID";
		$arSelect[] = "IBLOCK_SECTION_ID";
		$arSelect[] = "LIST_PAGE_URL";
		$arSelect[] = "SECTION_PAGE_URL";
	}

	if(isset($arParams["SECTION_USER_FIELDS"]) && is_array($arParams["SECTION_USER_FIELDS"]))
	{
		foreach($arParams["SECTION_USER_FIELDS"] as $field)
			if(is_string($field) && preg_match("/^UF_/", $field))
				$arSelect[] = $field;
	}

	$arResult["SECTION"] = false;
	if(strlen($arParams["SECTION_CODE"])>0)
	{
		$arFilter["CODE"] = $arParams["SECTION_CODE"];
		$rsSections = CIBlockSection::GetList(array(), $arFilter, $arParams["COUNT_ELEMENTS"], $arSelect);
		$rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
		$arResult["SECTION"] = $rsSections->GetNext();
	}
	elseif($arParams["SECTION_ID"]>0)
	{
		$arFilter["ID"] = $arParams["SECTION_ID"];
		$rsSections = CIBlockSection::GetList(array(), $arFilter, $arParams["COUNT_ELEMENTS"], $arSelect);
		$rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
		$arResult["SECTION"] = $rsSections->GetNext();
	}

	if(is_array($arResult["SECTION"]))
	{
		unset($arFilter["ID"]);
		unset($arFilter["CODE"]);
		$arFilter["LEFT_MARGIN"]=$arResult["SECTION"]["LEFT_MARGIN"]+1;
		$arFilter["RIGHT_MARGIN"]=$arResult["SECTION"]["RIGHT_MARGIN"];
		$arFilter["<="."DEPTH_LEVEL"]=$arResult["SECTION"]["DEPTH_LEVEL"] + $arParams["TOP_DEPTH"];

		$arResult["SECTION"]["PATH"] = array();
		$rsPath = CIBlockSection::GetNavChain($arResult["SECTION"]["IBLOCK_ID"], $arResult["SECTION"]["ID"]);
		$rsPath->SetUrlTemplates("", $arParams["SECTION_URL"]);
		while($arPath = $rsPath->GetNext())
		{
			$arResult["SECTION"]["PATH"][]=$arPath;
		}
	}
	else
	{
		$arResult["SECTION"] = array("ID"=>0, "DEPTH_LEVEL"=>0);
		$arFilter["<="."DEPTH_LEVEL"] = $arParams["TOP_DEPTH"];
	}

	//ORDER BY
	$arSort = array(
		"left_margin"=>"asc",
	);
	//EXECUTE
	$rsSections = CIBlockSection::GetList($arSort, array_merge($arrSectFilter, $arFilter), $arParams["COUNT_ELEMENTS"], $arSelect, $arNavParams);
	$rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
	while($arSection = $rsSections->GetNext())
	{
		if(isset($arSection["PICTURE"]))
			$arSection["PICTURE"] = CFile::GetFileArray($arSection["PICTURE"]);

		$arButtons = CIBlock::GetPanelButtons(
			$arSection["IBLOCK_ID"],
			0,
			$arSection["ID"],
			array("SESSID"=>false, "CATALOG"=>true)
		);
		$arSection["EDIT_LINK"] = $arButtons["edit"]["edit_section"]["ACTION_URL"];
		$arSection["DELETE_LINK"] = $arButtons["edit"]["delete_section"]["ACTION_URL"];
		$elFilter = array("SECTION_ID"=>$arSection["ID"], "INCLUDE_SUBSECTIONS" => $arParams["ELEMENT_INCLUDE_SUBSECTIONS"]);
		$elFilter = array_merge($elFilter,$arrFilter);
		$arSection["ELEMENT_CNT"] = $arSection["~ELEMENT_CNT"] = CIBlockElement::GetList(array(),$elFilter,array());
		$arResult["SECTIONS"][]=$arSection;
	}

	$arResult["SECTIONS_COUNT"] = count($arResult["SECTIONS"]);

	
	$arResult["NAV_STRING"] = $rsSections->GetPageNavStringEx($navComponentObject, $arParams["PAGER_TITLE"], $arParams["PAGER_TEMPLATE"], $arParams["PAGER_SHOW_ALWAYS"]);
	$arResult["NAV_CACHED_DATA"] = $navComponentObject->GetTemplateCachedData();
	$arResult["NAV_RESULT"] = $rsSections;
	
	$dbSectionTags = CIBlockSection::GetList(
		array("ID" => "ASC"),
		array("ACTIVE" => "Y", "GLOBAL_ACTIVE" => "Y", "IBLOCK_ID" => $arParams["IBLOCK_ID"]),
		false,
		array("UF_TAGS", "ID")
	);
	
	$tagList = array();
	while($rsSectionTags = $dbSectionTags->GetNext()){
		$sectionTags = array_map("trim", explode(",", $rsSectionTags["UF_TAGS"]));
		$tagList = array_merge($sectionTags, $tagList);
	}
	
	$arResult["TAGS"] = array_unique(array_filter($tagList));
	
	$this->SetResultCacheKeys(array(
		"SECTIONS_COUNT",
		"SECTION",
		"NAV_CACHED_DATA"
	));

	$this->IncludeComponentTemplate();
}

if($arResult["SECTIONS_COUNT"] > 0 || isset($arResult["SECTION"]))
{
	if(
		$USER->IsAuthorized()
		&& $APPLICATION->GetShowIncludeAreas()
		&& CModule::IncludeModule("iblock")
	)
	{
		$UrlDeleteSectionButton = "";
		if(isset($arResult["SECTION"]) && $arResult["SECTION"]['IBLOCK_SECTION_ID'] > 0)
		{
			$rsSection = CIBlockSection::GetList(
				array(),
				array("=ID" => $arResult["SECTION"]['IBLOCK_SECTION_ID']),
				false,
				array("SECTION_PAGE_URL")
			);
			$rsSection->SetUrlTemplates("", $arParams["SECTION_URL"]);
			$arSection = $rsSection->GetNext();
			$UrlDeleteSectionButton = $arSection["SECTION_PAGE_URL"];
		}

		if(empty($UrlDeleteSectionButton))
		{
			$url_template = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "LIST_PAGE_URL");
			$arIBlock = CIBlock::GetArrayByID($arParams["IBLOCK_ID"]);
			$arIBlock["IBLOCK_CODE"] = $arIBlock["CODE"];
			$UrlDeleteSectionButton = CIBlock::ReplaceDetailURL($url_template, $arIBlock, true, false);
		}

		$arReturnUrl = array(
			"add_section" => (
				strlen($arParams["SECTION_URL"])?
				$arParams["SECTION_URL"]:
				CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_PAGE_URL")
			),
			"add_element" => (
				strlen($arParams["SECTION_URL"])?
				$arParams["SECTION_URL"]:
				CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_PAGE_URL")
			),
			"delete_section" => $UrlDeleteSectionButton,
		);
		$arButtons = CIBlock::GetPanelButtons(
			$arParams["IBLOCK_ID"],
			0,
			$arResult["SECTION"]["ID"],
			array("RETURN_URL" =>  $arReturnUrl, "CATALOG"=>true)
		);

		$this->AddIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));
	}

	if($arParams["ADD_SECTIONS_CHAIN"] && isset($arResult["SECTION"]) && is_array($arResult["SECTION"]["PATH"]))
	{
		foreach($arResult["SECTION"]["PATH"] as $arPath)
		{
			$APPLICATION->AddChainItem($arPath["NAME"], $arPath["~SECTION_PAGE_URL"]);
		}
	}
}
?>
