<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?
$arUrls = Array(
	"delete" => SITE_DIR."ajax/basket.php?action=delete&id=#ID#",
	"delay" => $APPLICATION->GetCurPage()."?action=delay&id=#ID#",
	"add" => $APPLICATION->GetCurPage()."?action=add&id=#ID#",
);

$arBasketJSParams = array(
	'SALE_DELETE' => GetMessage("SALE_DELETE"),
	'SALE_DELAY' => GetMessage("SALE_DELAY"),
	'SALE_TYPE' => GetMessage("SALE_TYPE"),
	'TEMPLATE_FOLDER' => $templateFolder,
	'DELETE_URL' => $arUrls["delete"],
	'DELAY_URL' => $arUrls["delay"],
	'ADD_URL' => $arUrls["add"]
);
?>
<?
	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/functions.php");

	$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
	$normalHidden = ($normalCount == 0) ? "style=\"display:none\"" : "";

	$delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
	$delayHidden = ($delayCount == 0) ? "style=\"display:none\"" : "";

	$subscribeCount = count($arResult["ITEMS"]["ProdSubscribe"]);
	$subscribeHidden = ($subscribeCount == 0) ? "style=\"display:none\"" : "";

	$naCount = count($arResult["ITEMS"]["nAnCanBuy"]);
	$naHidden = ($naCount == 0) ? "style=\"display:none\"" : "";

	?>

	<a rel="nofollow" class="mini-cart" href="<?=$arParams["PATH_TO_BASKET"]?>"><span class="number"><?=$normalCount?></span></a>
	<?if($normalCount > 0):?>
		<div class="cart-popup">
			<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");?>
		</div>
	<?endif?>