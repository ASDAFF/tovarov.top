<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<script type="text/javascript">
var wished = [];
</script>
<?
    $wish=0;
    if($arResult["ITEMS"])
        foreach ($arResult["ITEMS"] as $arItem)
            if ($arItem["DELAY"]=="Y" && $arItem["CAN_BUY"]=="Y")
            {$wish++;  
            ?>
            <script type="text/javascript">
                 wished.push(<?=$arItem['PRODUCT_ID']?>) ;
            </script>
            <?
            }
?>
<div class="links" style="display: block;">
    <?
        $APPLICATION->IncludeComponent(
            "bitrix:sale.viewed.product",
            "empty",
            Array(
                "VIEWED_IMG_HEIGHT" => "150",
                "VIEWED_IMG_WIDTH" => "150",
                "VIEWED_COUNT" => "999",
                "VIEWED_NAME" => "Y",
                "VIEWED_IMAGE" => "Y",
                "VIEWED_PRICE" => "Y",
                "VIEWED_CURRENCY" => "default",
                "VIEWED_CANBUY" => "N",
                "VIEWED_CANBASKET" => "N",
                "BASKET_URL" => SITE_DIR."personal/basket/",
                "ACTION_VARIABLE" => "action",
                "PRODUCT_ID_VARIABLE" => "id",
                "SET_TITLE" => "Y"
            ),
            false
        );
        $IDs = unserialize($APPLICATION->GetProperty("prop-viewed", serialize(array())));
        $visited = count($IDs); 
    ?>
    <a href="<?=$arParams['PATH_TO_VISITED']?>" class="link-visit link"><span><?=GetMessage('CART_VISITED')?> <em>(<?=$visited?>)</em></span></a>
    <a href="<?=$arParams['PATH_TO_WISHLIST']?>" class="link-wish link"><span><?=GetMessage('CART_WISHLIST')?> <em>(<?=$wish?>)</em></span></a>
    <a href="#" class="btn-close"><?=GetMessage('CLOCE')?></a>
</div>