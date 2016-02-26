<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetPageProperty("prop-h1", "Оформление заказа");
	$APPLICATION->SetTitle("Оформление заказа");

    //setlocale(LC_ALL, "");
    //setlocale(LC_ALL, 'ru_RU.CP1251');
    //setlocale(LC_NUMERIC,'C');
    //setlocale(LC_NUMERIC,'');

    setlocale( LC_NUMERIC, '' );
?>
<div class="contents">
   <?if(!array_key_exists('ORDER_ID',$_REQUEST)):?> <div class="order-container"> <?endif;?>  
        <?$APPLICATION->IncludeComponent("bitrix:sale.order.ajax", ".default", array(
            "PAY_FROM_ACCOUNT" => "Y",
            "ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
            "COUNT_DELIVERY_TAX" => "N",
            "ALLOW_AUTO_REGISTER" => "Y",
            "SEND_NEW_USER_NOTIFY" => "Y",
            "DELIVERY_NO_AJAX" => "Y",
            "DELIVERY_NO_SESSION" => "N",
            "TEMPLATE_LOCATION" => "",
            "DELIVERY_TO_PAYSYSTEM" => "d2p",
            "USE_PREPAYMENT" => "N",
            "ALLOW_NEW_PROFILE" => "Y",
            "SHOW_PAYMENT_SERVICES_NAMES" => "Y",
            "SHOW_STORES_IMAGES" => "N",
            "PATH_TO_BASKET" => SITE_DIR."personal/basket/",
            "PATH_TO_PERSONAL" => SITE_DIR."personal/",
            "PATH_TO_PAYMENT" => SITE_DIR."personal/pay/",
            "PATH_TO_AUTH" => SITE_DIR."auth/",
            "SET_TITLE" => "Y",
            "DISABLE_BASKET_REDIRECT" => "N",
            "PRODUCT_COLUMNS" => array(
                0 => "PROPERTY_MORE_PHOTO",
                1 => "WEIGHT_FORMATED"
            )
            ),
            false
        );?>
    <?if(!array_key_exists('ORDER_ID',$_REQUEST)):?></div><?endif;?>
    <?if(!array_key_exists('ORDER_ID',$_REQUEST)):?>
    <div class="aside">
        <?
        // включаемая область дл§ раздела
        $APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_contacts.php", Array(), Array(
            "MODE"      => "html",                                           // будет редактировать в веб-редакторе
            "NAME"      => "Виджет контактов",      // текст всплывающей подсказки на иконке
            "TEMPLATE"  => "section_include_template.php"                    // им§ шаблона дл§ нового файла
        ));
        ?>

        <?
            // включаема§ область дл§ раздела
            $APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_preferences.php", Array(), Array(
                    "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                    "NAME"      => "Виджет преймуществ",      // текст всплывающей подсказки на иконке
                    "TEMPLATE"  => "section_include_template.php"                    // им§ шаблона дл§ нового файла
                ));
        ?>

        <?
            // включаема§ область дл§ раздела
            $APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_reviews.php", Array(), Array(
                    "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                    "NAME"      => "Виджет отзывов",      // текст всплывающей подсказки на иконке
                    "TEMPLATE"  => "section_include_template.php"                    // им§ шаблона дл§ нового файла
                ));
        ?>
    </div>
    <?endif;?>
</div>
<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>