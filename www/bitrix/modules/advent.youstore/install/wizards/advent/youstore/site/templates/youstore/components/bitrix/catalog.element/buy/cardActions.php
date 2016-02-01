<?
	if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
	{
		$canBuy = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['CAN_BUY'];
	}
	else
	{
		$canBuy = $arResult['CAN_BUY'];
	}
	if ($canBuy)
	{
		$buyBtnMessage = ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
		$buyBtnClass = 'bx_big bx_bt_button bx_cart';
	}
	else
	{
		$buyBtnMessage = ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
		$buyBtnClass = 'bx_big bx_bt_button_type_2 bx_cart';
	}
?>
<div class="buttons">
    <a class="button btn-cart" id="<? echo $arItemIDs['BUY_LINK']; ?>" href="javascript:void(0)"><span><?=GetMessage('CATALOG_INCART')?></span></a>
</div>