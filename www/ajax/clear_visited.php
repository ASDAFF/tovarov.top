<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
    if (CModule::IncludeModule("sale"))
    {
        CSaleViewedProduct::DeleteForUser(CSaleBasket::GetBasketUserID(), $LIMIT = NULL);
    }
?>