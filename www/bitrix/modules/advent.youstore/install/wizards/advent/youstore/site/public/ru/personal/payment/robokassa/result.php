<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("ROBOTS", "nofollow");
$APPLICATION->SetPageProperty("TITLE", "Прием информации об оплате");
$APPLICATION->SetPageProperty("prop-h1", "Прием информации об оплате");
$APPLICATION->SetTitle("Прием информации об оплате");
?><?$APPLICATION->IncludeComponent(
    "bitrix:sale.order.payment.receive",
    "",
    Array(
        "PAY_SYSTEM_ID" => "6",
        "PERSON_TYPE_ID" => "1"
    ),
false
);?> <?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>