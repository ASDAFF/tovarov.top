<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
echo ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;

if ($normalCount > 0):
?>
    <div id="basket_items_list" class="items">
        <?
        foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

            if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
        ?>
            <div class="item" id="<?=$arItem["ID"]?>">
                <div class="item-holder">
                    <a class="closed close-a full-basket-reload item-delete" onclick="fullBasketReload();return false;" href="/ajax/basket.php?action=delete&id=<?=$arItem["ID"]?>">closed</a>&nbsp;
                    <div class="item-form-holder">
                        <div class="holder">
                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                                <div class="image">
                                    <?
                                    if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
                                        $url = $arItem["PREVIEW_PICTURE_SRC"];
                                    elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
                                        $url = $arItem["DETAIL_PICTURE_SRC"];
                                    elseif(!empty($arItem["~PROPERTY_MORE_PHOTO_VALUE"])):
                                        $url = CFile::GetPath(reset(explode(",",$arItem["~PROPERTY_MORE_PHOTO_VALUE"])));
                                    else:
                                        $url = $templateFolder."/images/no_photo.png";
                                    endif;
                                    ?>
                                        <img src="<?=$url?>" width="109" />
                                </div>
                            </a>
                            <div class="title">
                                <h2><a class="name" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h2>
                            </div>
                            <p class="id"># <?=$arItem["ID"]?></p>
                        </div>
                        <div class="item-form">
                            <?if (is_array($arItem["SKU_DATA"])) { ?>
                                <div class="frame">
                                    <?
                                        foreach ($arItem["SKU_DATA"] as $propId => $arProp):
                                            // is image property
                                            $isImgProperty = false;
                                            foreach ($arProp["VALUES"] as $id => $arVal)
                                            {
                                                if (isset($arVal["PICT"]) && !empty($arVal["PICT"]))
                                                {
                                                    $isImgProperty = true;
                                                    break;
                                                }
                                            }
                                            
                                            if(empty($arProp["VALUES"])) continue;
                                            ?>
                                            <div class="row">
                                                <?
                                                $full = (count($arProp["VALUES"]) > 5) ? "full" : "";
                                                if ($isImgProperty): // iblock element relation property
                                                ?>
                                                <h3><?=$arProp["NAME"]?></h3>
                                                <ul class="color-list sku_prop_list" id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>">
                                                    <?
                                                    foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

                                                        $selected = "";
                                                        foreach ($arItem["PROPS"] as $arItemProp):
                                                            if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
                                                            {
                                                                if ($arItemProp["VALUE"] == $arSkuValue["NAME"] || $arItemProp["VALUE"] == $arSkuValue["XML_ID"])
                                                                    $selected = "active";
                                                            }
                                                        endforeach;
                                                    ?>
                                                        <li style="background-image:url(<?=$arSkuValue["PICT"]["SRC"]?>)"
                                                            class="<?=$selected?> sku_prop"
                                                            data-value-id="<?=$arSkuValue["XML_ID"]?>"
                                                            data-element="<?=$arItem["ID"]?>"
                                                            data-property="<?=$arProp["CODE"]?>"
                                                            >
                                                            <a class="cnt_item" href="javascript:void(0);">
                                                                <?=$arSkuValue["NAME"]?>
                                                            </a>
                                                        </li>
                                                    <?
                                                    endforeach;
                                                    ?>
                                                </ul>
                                                <?
                                                else:
                                                ?>
                                                    <h3><?=$arProp["NAME"]?></h3>
                                                    <div class="selectbox memory-holder">
                                                        <span class="select">
                                                            <?
                                                                $input_val = "";
                                                                foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

                                                                    $selected = "";
                                                                    foreach ($arItem["PROPS"] as $arItemProp):
                                                                        if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
                                                                        {
                                                                            if ($arItemProp["VALUE"] == $arSkuValue["NAME"]){
                                                                                $selected = "active";
                                                                                $input_val = $arItemProp["VALUE"];
                                                                            }
                                                                        }
                                                                    endforeach;
                                                                endforeach;
                                                            ?>
                                                            <div class="__trigger"><a><?=$input_val?></a></div>
                                                            <s></s>
                                                            <ul class="sku_prop_list" id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="display:none">
                                                                <?
                                                                $input_val = "";
                                                                foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

                                                                    $selected = "";
                                                                    foreach ($arItem["PROPS"] as $arItemProp):
                                                                        if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
                                                                        {
                                                                            if ($arItemProp["VALUE"] == $arSkuValue["NAME"]){
                                                                                $selected = "active";
                                                                                $input_val = $arItemProp["VALUE"];
                                                                            }
                                                                        }
                                                                    endforeach;
                                                                ?>
                                                                    <li
                                                                        class="<?=$selected?> sku_prop"
                                                                        data-value-id="<?=$arSkuValue["NAME"]?>"
                                                                        data-element="<?=$arItem["ID"]?>"
                                                                        data-property="<?=$arProp["CODE"]?>"
                                                                        >
                                                                        <?=$arSkuValue["NAME"]?>
                                                                    </li>
                                                                <?
                                                                endforeach;
                                                                ?>
                                                            </ul>
                                                            <?/*<input type="text" readonly placeholder="(�� �������)" value="<?=$input_val?>" />*/?>
                                                        </span>
                                                    </div>
                                                <?endif;?>
                                            </div>
                                    <?
                                        endforeach;
                                    ?>
                                </div>    
                            <? } ?>
                            <div class="price-frame">
                                <div class="frame">
                                    <strong class="price"><?=intval($arItem["PRICE"]);?> <sub><?=GetMEssage('SALE_RUB')?></sub></strong> 
                                    <a onclick="fullBasketReload();return false;" href="<?=SITE_DIR?>ajax/basket.php?action=delete&id=<?=$arItem["ID"]?>" class="btn-delete closed close-a">delete</a>
                                    <input
                                        type="text"
                                        class="number"
                                        size="3"
                                        id="QUANTITY_INPUT_<?=$arItem["ID"]?>"
                                        name="QUANTITY_INPUT_<?=$arItem["ID"]?>"
                                        size="2"
                                        min="0"
                                        <?=$max?>
                                        step="<?=$ratio?>"
                                        maxlength="18"
                                        value="<?=$arItem["QUANTITY"]?>"
                                        onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', '<?=$ratio?>', '<?=$useFloatQuantity?>')"
                                    >
                                    
                                    <div style="display:none">
                                        <!-- quantity selector for mobile -->
                                        <?
                                            echo getQuantitySelectControl(
                                                "QUANTITY_SELECT_".$arItem["ID"],
                                                "QUANTITY_SELECT_".$arItem["ID"],
                                                $arItem["QUANTITY"],
                                                $arItem["AVAILABLE_QUANTITY"],
                                                $useFloatQuantity,
                                                $arItem["MEASURE_RATIO"],
                                                $arItem["MEASURE_TEXT"]
                                            );
                                        ?>
                                        <input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?
            endif;
        endforeach;
        ?>
        <input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arParams["COLUMNS_LIST"], ","))?>" />
        <input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ","))?>" />
        
        <input type="hidden" id="QUANTITY_FLOAT" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
        <input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
        
        <input type="hidden" id="COUNT_DISCOUNT_4_ALL_QUANTITY" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
        <input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
        
        <input type="hidden" id="PRICE_VAT_SHOW_VALUE" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
        <input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
        
        <input type="hidden" id="HIDE_COUPON" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
        <input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
        
        <input type="hidden" id="USE_PREPAYMENT" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />
        <input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />
        
        <input type="hidden" id="action_var" value="action">
    </div>
    <div class="hidden">
        <input type="submit" class="bt2" name="BasketRefresh" value="<?=GetMessage('SALE_REFRESH')?>">
    </div>
    <div class="total">
        <p><?=GetMessage('SALE_TOTAL')?><strong><?=$arResult["allSum"]?></strong> <sub><?=GetMessage('SALE_RUB')?></sub></p>
    </div>
    
    <?
        if ($arParams["HIDE_COUPON"] != "Y"):
    ?>
        <div class="text-row">
            <h3><?=GetMessage('SALE_PROMO')?></h3>
            <a href="#promo-popup" class="how popup-open"><?=GetMessage('SALE_DISC')?></a>
        </div>
        <div class="promo-form" action="#">
            <?
                $couponClass = "";
                if (array_key_exists('COUPON_VALID', $arResult))
                {
                    $couponClass = ($arResult["COUPON_VALID"] == "Y") ? "good" : "bad";
                }elseif (array_key_exists('COUPON', $arResult) && strlen($arResult["COUPON"]) > 0)
                {
                    $couponClass = "good";
                }

            ?>
            <input id="coupon" type="text" name="COUPON" class="text <?=$couponClass?>" onchange="enterCoupon();" size="21" placeholder="<?=GetMessage('SALE_DISC_HERE')?>" value="<?=$arResult["COUPON"]?>">
            <a href="javascript:void(0)" class="submit" onclick="enterCoupon(); return false;">&nbsp;</a>
        </div>
    <?endif?>
    <div class="buttons">
        <a class="button btn-cart" onclick="checkOut();return false;" href="#">
            <span><?=GetMessage('SALE_ORDER')?></span>
        </a>
        <a class="order button btn-click callback-popup-link" href="/ajax/callback.php">
            <span><?=GetMessage('SALE_ORDERPHONE')?></span>
        </a>
    </div>
<?
else:
?>
<div id="basket_items_list">
    <table>
        <tbody>
            <tr>
                <td colspan="<?=$numCells?>" style="text-align:center">
                    <div class=""><?=GetMessage("SALE_NO_ITEMS");?></div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?
endif;
?>