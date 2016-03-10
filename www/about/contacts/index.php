<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Контактная информация интерент-магазина tovarov.top. +7(967) 168-45-83");
$APPLICATION->SetPageProperty("keywords", "Контактные данные Товаров.ТОП, контакты Tovarov.TOP");
$APPLICATION->SetPageProperty("title", "Контактные данные Tovarov.TOP");
    $APPLICATION->SetTitle("Контактные данные Tovarov.TOP");
    $APPLICATION->SetPageProperty("prop-h1", "Контакты");
?><div class="contents">
	<div class="contacts-holder">
		<div class="col-form">
			<h2>ОБРАТНАЯ СВЯЗЬ</h2>
			 <?$APPLICATION->IncludeComponent(
	"advent:main.feedback",
	".default",
	Array(
		"AJAX_MODE" => "Y",
		"EMAIL_TO" => COption::GetOptionString("main","email_from"),
		"EVENT_MESSAGE_ID" => array(0=>"7",),
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"REQUIRED_FIELDS" => array(0=>"NAME",1=>"EMAIL",),
		"USE_CAPTCHA" => "Y"
	)
);?>
		</div>
		<div class="col-info">
			<h2>КОНТАКТНАЯ ИНФОРМАЦИЯ</h2>
			<div class="contact-boxes" itemscope="" itemtype="http://schema.org/Organization">
				<div class="box">
					<div class="holder">
 <em> <img src="/bitrix/templates/youstore_/images/ico-contact-location.png" alt="image"> </em>
						<div class="text">
							<?
                                // включаема¤ область дл¤ раздела
                                $APPLICATION->IncludeFile(SITE_DIR."include/address.php", Array(), Array(
                                        "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                                        "NAME"      => "Адрес",      // текст всплывающей подсказки на иконке
                                        "TEMPLATE"  => "section_include_template.php"                    // им¤ шаблона дл¤ нового файла
                                    ));
                        ?>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="holder">
 <em> <img src="/bitrix/templates/youstore_/images/ico-contact-phone.png" alt="image"> </em>
						<div class="text">
							<?
                                // включаема¤ область дл¤ раздела
                                $APPLICATION->IncludeFile(SITE_DIR."include/phone.php", Array(), Array(
                                        "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                                        "NAME"      => "Телефон",      // текст всплывающей подсказки на иконке
                                        "TEMPLATE"  => "section_include_template.php"                    // им¤ шаблона дл¤ нового файла
                                    ));
                            ?><br>
							<a href="<?=SITE_DIR?>ajax/callback.php" class="callback callback-popup-link">Обратный звонок</a>
						</div>
					</div>
				</div>
				<div class="box">
					<div class="holder">
 <em> <img src="/bitrix/templates/youstore_/images/ico-contact-skype.png" alt="image"> </em>
						<div class="text">
 <strong itemprop="name"><?
                                    // включаема¤ область дл¤ раздела
                                    $APPLICATION->IncludeFile(SITE_DIR."include/skype.php", Array(), Array(
                                            "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                                            "NAME"      => "Skype",      // текст всплывающей подсказки на иконке
                                            "TEMPLATE"  => "section_include_template.php"                    // им¤ шаблона дл¤ нового файла
                                        ));
                            ?></strong>
							Пишите или звоните
						</div>
					</div>
				</div>
				<div class="box">
					<div class="holder">
 <em> <img src="/bitrix/templates/youstore_/images/ico-contact-mail.png" alt="image"> </em>
						<div class="text">
 <strong><?
                                    // включаема¤ область дл¤ раздела
                                    $APPLICATION->IncludeFile(SITE_DIR."include/email.php", Array(), Array(
                                            "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                                            "NAME"      => "Email",      // текст всплывающей подсказки на иконке
                                            "TEMPLATE"  => "section_include_template.php"                    // им¤ шаблона дл¤ нового файла
                                        ));
                            ?></strong>
							Пишите нам на почту
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	 <?
        // включаема¤ область дл¤ раздела
        $APPLICATION->IncludeFile(SITE_DIR."include/parts/main-right-banners.php", Array(), Array(
                "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                "NAME"      => "Баннеры",      // текст всплывающей подсказки на иконке
                "TEMPLATE"  => "section_include_template.php"                    // им¤ шаблона дл¤ нового файла
            ));
    ?>
	<div class="contact-info">
		<div class="row">
             <a href="#" class="link-show plus">Реквизиты компании</a>
                    <div style="display: none;" class="expander">
                        <p>
                            <strong>Юридический адрес:</strong> 367000 РД, г Махачкала, пр-т Акушинского 62 к2 оф22
                        </p>
                        <p>
                            <strong>ИНН:</strong> 0573003548
                        </p>
                        <p>
                            <strong>КПП:</strong> 057301001
                        </p>
                        <p>
                            <strong>ОГРН:</strong> 1140573000270
                        </p>
                        <p>
                            <strong>Р/с:</strong> 40702810260320005745
                        </p>
                        <p>
                            <strong>БИК:</strong> 040702660 СЕВЕРО-КАВКАЗСКИЙ БАНК ПАО СБЕРБАНК
                        </p>
                        <p>
                            <strong>К/с:</strong> 30101810600000000660
                        </p>
                    </div>
		</div>
	</div>
</div><?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>