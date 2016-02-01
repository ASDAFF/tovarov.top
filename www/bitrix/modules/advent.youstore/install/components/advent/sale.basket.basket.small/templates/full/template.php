<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    $this->setFrameMode(true);$wish=0;$compare=0; $items=0;
    if($arResult["ITEMS"])foreach ($arResult["ITEMS"] as $arItem) if ($arItem["DELAY"]=="Y" && $arItem["CAN_BUY"]=="Y")$wish++;
    if($arResult["ITEMS"])foreach ($arResult["ITEMS"] as $arItem) if ($arItem["DELAY"]=="N" && $arItem["CAN_BUY"]=="Y")$items++;
    if($arResult["COMPARE"]) foreach ($arResult["COMPARE"] as $arIb)if($arIb["ITEMS"])foreach ($arIb["ITEMS"] as $arItem)$compare++;
?>
<div id="yourcart-popup" class="popup yourcart-popup" style="display: block;">
    <div class="popup-inner">
        <div class="popup-title">
            <a href="" class="close"><?=GetMessage('CART_CLOSE')?></a>
            <div class="ttl_4"><?=GetMessage('CART_FULL')?> <?=$arResult['PRICE_FORMATED']?></div>
        </div>
        <div class="popup-content">
         <?if($items>0):?>
            <div class="table-popup-holder">
           
                <table class="cart-popup-table">
                <?foreach ($arResult["ITEMS"] as $arItem): if ($arItem["DELAY"]=="N" && $arItem["CAN_BUY"]=="Y"):?>
            
                    <tr>
                        <td><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$arItem['PICTURE']['SRC']?>" alt=""/></a></td>
                        <td>
                            <div class="ttl_4"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></div>
                            <div class="clearfix">
                                <div class="infos">
                                    <div class="links">
                                        <a href="<?=$APPLICATION->GetCurPageParam('action=ADD_TO_COMPARE_LIST&id='.$arItem['PRODUCT_ID'], array('action', 'id'))?>" class="icon-compare addtocompare"></a>
                                    </div>
                                    <div class="price">
                                        <span><?=$arItem['PRICE_FORMATED']?>&nbsp;x&nbsp;<?=$arItem['QUANTITY']*1?></span>
                                     </div>
                                </div>
                                <p><?if($arItem['PROPS']):?><?foreach($arItem['PROPS'] as $key=>$arProp):?><? echo $arProp['VALUE'];
                                if(($key+1)<count($arItem['PROPS']))echo ' / ';?><? endforeach?><?endif?></p>
                                <span class="art"><?=GetMessage('CART_ART')?><?=$arItem['ARTNUMBER']?></span>
                                <span class="instore"><?=$arItem['CATALOG']['CATALOG_AVAILABLE']=='Y'?GetMessage('CART_AVAILABLE'):GetMessage('CART_NOAVAILABLE')?></span>
                            </div>
                        </td>
                        <td>
                            <a href="<?=$APPLICATION->GetCurPageParam('action=DELETEFROMCART&id='.$arItem['ID'], array('action', 'id'))?>" class="icon-del deletefrombasket"></a>
                            <div><a href="<?=$APPLICATION->GetCurPageParam('action=ADD2DELAY&id='.$arItem['ID'], array('action', 'id'))?>" class="delay"><?=GetMessage('CART_DELAY')?></a></div>
                        </td>
                    </tr>
                 <?endif;endforeach?>
                </table>
            </div>
            <div class="clearfix">
                <div class="intotal-popup">
                    <div><?=GetMessage('CART_ALL')?>: <?=$arResult['PRICE_FORMATED']?></div>
                </div>
                <div class="popup-buttons">
                    <a href="<?=$arParams['PATH_TO_BASKET']?>" class="btn-blue"><?=GetMessage('CART_ORDER')?></a>
                    <a href="#" class="btn-blue close-popup"><?=GetMessage('CART_CONTINUE')?></a>
                </div>
            </div>
            <?else:?>
    <div class="empty"><?=GetMessage('CART_EMPTY')?></div>
    <?endif?>
        </div>
    </div>
</div>