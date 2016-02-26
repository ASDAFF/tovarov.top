<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetPageProperty("prop-h1", "Успешная оплата заказа")
?>
Спасибо, ваш заказ №<?=htmlspecialchars($_REQUEST["InvId"])?> оплачен!
<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>