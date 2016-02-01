<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript">
var wished = [];
</script>
<?
$wish=0;
if($arResult["BASKET_ITEMS"]){
	foreach ($arResult["BASKET_ITEMS"] as $arItem){
		if ($arItem["DELAY"]=="Y" && $arItem["CAN_BUY"]=="Y")
		{
			$wish++;  
			?>
			<script type="text/javascript">
				 wished.push(<?=$arItem['PRODUCT_ID']?>) ;
			</script>
			<?
		}
	}
}
?>
<div class="links" style="display: block;">
    <a href="<?=$arParams['PATH_TO_VISITED']?>" class="link-visit link"><span><?=GetMessage('CART_VISITED')?> <em>(<?=count($arResult['VIEWED']);?>)</em></span></a>
    <a href="<?=$arParams['PATH_TO_WISHLIST']?>" class="link-wish link"><span><?=GetMessage('CART_WISHLIST')?> <em>(<?=$wish?>)</em></span></a>
    <a href="#" class="btn-close">close</a>
</div>