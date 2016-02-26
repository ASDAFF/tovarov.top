<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetPageProperty("prop-h1", "Ошибка оплаты заказа");
?>
Извините, ошибка оплаты вашего заказа №<?=htmlspecialchars($_REQUEST["InvId"])?>!
<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>