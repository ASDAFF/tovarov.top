<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    $this->setFrameMode(true);$wish=0;$compare=0; $items=0;
    if($arResult["ITEMS"])foreach ($arResult["ITEMS"] as $arItem) if ($arItem["DELAY"]=="Y" && $arItem["CAN_BUY"]=="Y")$wish++;
    if($arResult["ITEMS"])foreach ($arResult["ITEMS"] as $arItem) if ($arItem["DELAY"]=="N" && $arItem["CAN_BUY"]=="Y")$items++;
    if($arResult["COMPARE"]) foreach ($arResult["COMPARE"] as $arIb)if($arIb["ITEMS"])foreach ($arIb["ITEMS"] as $arItem)$compare++;
?>
<?$frame = $this->createFrame()->begin()?>
<a href="<?=$arParams['PATH_TO_COMPARE']?>" class="footer-compare"><i class="icon-compare-footer"></i><em><?=GetMessage('CART_COMPARE')?></em> <span class="comparecnt"><?=$compare?></span></a>
<a href="<?=$arParams['PATH_TO_WISHLIST']?>" class="footer-favorite"><i class="icon-like-footer"></i><em><?=GetMessage('CART_WISHLIST')?></em> <span class="wishcnt"><?=$wish?></span></a>
<div class="footer-cart"><i class="icon-cart-footer"></i><em><?=GetMessage('CART_BASKET')?></em> <span><?=$items?></span> <b><?=$arResult['PRICE_FORMATED']?></b> <?if($items>0):?><a href="<?=SITE_DIR?>personal/cart/" class="btn-order"><?=GetMessage('CART_ORDER')?></a><?endif?></div>

<?$frame->beginStub()?>
<a href="<?=$arParams['PATH_TO_COMPARE']?>" class="footer-compare"><i class="icon-compare-footer"></i><em><?=GetMessage('CART_COMPARE')?></em> <span>0</span></a>
<a href="<?=$arParams['PATH_TO_WISHLIST']?>" class="footer-favorite"><i class="icon-like-footer"></i><em><?=GetMessage('CART_WISHLIST')?></em> <span>0</span></a>
<div class="footer-cart"><i class="icon-cart-footer"></i><em><?=GetMessage('CART_BASKET')?></em> <span>0</span> <a href="<?=$arParams['PATH_TO_CART']?>" class="btn-order"><?=GetMessage('CART_ORDER')?></a></div>
<?$frame->end()?>