<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="three-columns">
<div class="two-columns">
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"root",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
			"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
			"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
			"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N")
		),
		$component
	);?>
	
	<?
		// ���������� ������� ��� �������
		$APPLICATION->IncludeFile(SITE_DIR."include/parts/brands.php", Array(), Array(
			"MODE"      => "html",                                           // ����� ������������� � ���-���������
			"NAME"      => "Area edit",      // ����� ����������� ��������� �� ������
			"TEMPLATE"  => "section_include_template.php"                    // ��� ������� ��� ������ �����
		));
	?>
	<?
		// ���������� ������� ��� �������
		$APPLICATION->IncludeFile(SITE_DIR."include/parts/blog.php", Array(), Array(
			"MODE"      => "html",                                           // ����� ������������� � ���-���������
			"NAME"      => "Area edit",      // ����� ����������� ��������� �� ������
			"TEMPLATE"  => "section_include_template.php"                    // ��� ������� ��� ������ �����
		));
	?>
</div>
</div>