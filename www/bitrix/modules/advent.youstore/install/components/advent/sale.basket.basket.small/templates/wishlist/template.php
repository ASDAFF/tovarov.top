<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    $this->setFrameMode(true);
    include 'functions.php';
?>
<h2 class="strong-header large-header"><?$APPLICATION->ShowTitle(false)?></h2>
<div class="row">
    <?$k=0;foreach ($arResult["ITEMS"] as $arItem): if ($arItem["DELAY"]=="Y"): $k++;?>
        <div class="col-xs-6 col-sm-4 col-md-3 item">
            <!-- SHOP FEATURED ITEM -->
            <article class="shop-item shop-item-wishlist overlay-element">
                <div class="overlay-wrapper">
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                        <img src="<?=$arItem['PICTURE']['SRC']?>" style="padding:<?=margin($arItem['PICTURE']['HEIGHT'], $arParams['DISPLAY_IMG_HEIGHT'], $arItem["PICTURE"]["WIDTH"], $arParams['DISPLAY_IMG_WIDTH'], false)?>" alt="<?=$arItem['NAME']?>">
                    </a>
                    <div class="overlay-contents">
                        <div class="shop-item-actions">
                            <form action="<?=$APPLICATION->GetCurPage(true)?>">
                                <input type="hidden" name="action" value="DELETE_FROM_DELAY">
                                <input type="hidden" name="id" value="<?=$arItem['ID']?>">
                                <button type="submit" class="close" aria-hidden="true"><span aria-hidden="true" data-icon="&#xe005;"></span></button>
                            </form>

                            <a href="<?=$APPLICATION->GetCurPageParam('action=ADD_DELAY2BASKET&id='.$arItem['ID'], array('action', 'id'))?>" class="btn btn-primary btn-block btn-small">
                                <?=GetMEssage('CART_INBASKET')?>
                            </a>
                        </div>
                    </div>
                </div>
                <header class="item-info-name-features-price">
                    <h4><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></h4>
                    <span class="features"><?if($arItem['PROPS'])foreach($arItem['PROPS'] as $key=>$arProp): echo $arProp['VALUE'];
                        if(($key+1)<count($arItem['PROPS']))echo ', '; endforeach?></span><br>
                    <span class="price"><?=$arItem['PRICE_FORMATED']?></span>
                </header>
            </article>
            <!-- !SHOP FEATURED ITEM -->
        </div>
        <?if($k%2==0 || $k%3==0 || $k%4==0):?>
            <div class="clearfix <?=$k%2==0?'visible-xs':''?> <?=$k%4==0?'visible-md visible-lg':''?> <?=$k%3==0?'visible-sm':''?> space-15"></div>
            <?endif?>
        <?endif?>
        <?endforeach?>
</div>