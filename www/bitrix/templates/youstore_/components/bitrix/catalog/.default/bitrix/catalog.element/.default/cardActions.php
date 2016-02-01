<div class="buttons">
	<?if($canBuy):?>
		<a class="button btn-cart" href="javascript:void(0);" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span><?=GetMessage("CT_BCE_CATALOG_ADD")?></span></a>
	<?else:?>
		<span class="button btn-cart" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span><?=GetMessage("CT_BCE_CATALOG_ADD")?></span></span>
	<?endif?>
	<?if($canBuy):?>
		<a class="button btn-click callback callback-popup-link" id="<? echo $arItemIDs['QUICK_BUY_LINK']?>" data-prod="<?=$arResult['NAME']?>" href="<?=SITE_DIR?>ajax/callback.php?itemid=<?=$arResult['ID']?>"><span><?=GetMessage("CT_BCE_CATALOG_QUICK_ADD")?></span></a>
	<?else:?>
		<span class="button btn-click callback" data-prod="<?=$arResult['NAME']?>" id="<? echo $arItemIDs['QUICK_BUY_LINK']?>"><span><?=GetMessage("CT_BCE_CATALOG_QUICK_ADD")?></span></span>
	<?endif?>
</div>

<div class="wish">
    <a class="link-wish det item<?=$arResult['ID']?>" data-action="ADD2DELAY" data-id="<?=$arResult['ID']?>"  href="<?=SITE_DIR?>ajax/wishlist.php"><?=GetMessage('WISHLIST_TEXT')?></a>
</div>
	<?/*<li class="compare"><a href="/ajax/compare.php?id=<?=$arResult["ID"]?>&action=ADD_TO_COMPARE_LIST" class="bx_big bx_bt_button_type_2 bx_cart"></a></li>*/?>
	<?/*<a class="link-wish" href="/ajax/wishlist.php?action=LIKE&ID=<?=$arResult["ID"]?>"><?=GetMessage("CT_BCE_CATALOG_WISH_TEXT")?></a>*/?>
