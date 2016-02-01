<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetPageProperty("prop-h1", "Корзина");
	$APPLICATION->SetTitle("Корзина");
?>
	<div class="contents">
		<div class="article-container">
			<?$APPLICATION->IncludeComponent("advent:sale.basket.basket", ".default", array(
				"COLUMNS_LIST" => array(
					0 => "NAME",
					1 => "DISCOUNT",
					2 => "QUANTITY",
					3 => "PROPS",
					4 => "DELETE",
					5 => "PRICE",
					6 => "SUM",
					8 => "PROPERTY_MORE_PHOTO",
				),
				"OFFERS_PROPS" => array(
					0 => "SIZE",
					1 => "COLOR",
				),
				"PATH_TO_ORDER" => SITE_DIR."personal/order/",
				"HIDE_COUPON" => "N",
				"PRICE_VAT_SHOW_VALUE" => "N",
				"COUNT_DISCOUNT_4_ALL_QUANTITY" => "Y",
				"USE_PREPAYMENT" => "N",
				"QUANTITY_FLOAT" => "N",
				"SET_TITLE" => "Y"
				),
				false
			);?> 
		</div>
        <div class="aside">
            <?
                // включаемая область для раздела
                $APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_contacts.php", Array(), Array(
                    "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                    "NAME"      => "Виджет контактов",      // текст всплывающей подсказки на иконке
                    "TEMPLATE"  => "section_include_template.php"                    // имя шаблона для нового файла
                ));
            ?>
            <?
                // включаемая область для раздела
                $APPLICATION->IncludeFile(SITE_DIR."include/parts/widget_bigdata.php", Array(), Array(
                    "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                    "NAME"      => "Виджет товаров",      // текст всплывающей подсказки на иконке
                    "TEMPLATE"  => "section_include_template.php"                    // имя шаблона для нового файла
                ));
            ?>
        </div>
	</div>
<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>