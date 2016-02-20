<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Контакты");
    $APPLICATION->SetPageProperty("prop-h1", "Контакты");
?> 	 
<div class="contents">
    <div class="contacts-holder">
        <div class="col-form">
            <h2>ОБРАТНАЯ СВЯЗЬ</h2>
            <?
                $APPLICATION->IncludeComponent(
                    "advent:main.feedback", 
                    ".default", 
                    array(
                        "USE_CAPTCHA" => "Y",
                        "OK_TEXT" => "Спасибо, ваше сообщение принято.",
                        "EMAIL_TO" => COption::GetOptionString("main","email_from"),
                        "REQUIRED_FIELDS" => array(
                            0 => "NAME",
                            1 => "EMAIL",
                        ),
                        "EVENT_MESSAGE_ID" => array(
                            0 => "7",
                        ),
                        'AJAX_MODE'=>'Y'
                    ),
                    false
                );?>
        </div>
        <div class="col-info">
            <h2>КОНТАКТНАЯ ИНФОРМАЦИЯ</h2>
            <div class="contact-boxes" itemscope itemtype="http://schema.org/Organization">
                <div class="box">
                    <div class="holder">
                        <em>
                            <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/ico-contact-location.png">
                        </em>
                        <div class="text"><?
                                // включаема¤ область дл¤ раздела
                                $APPLICATION->IncludeFile(SITE_DIR."include/address.php", Array(), Array(
                                        "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                                        "NAME"      => "Адрес",      // текст всплывающей подсказки на иконке
                                        "TEMPLATE"  => "section_include_template.php"                    // им¤ шаблона дл¤ нового файла
                                    ));
                        ?></div>
                    </div>
                </div>
                <div class="box">
                    <div class="holder">
                        <em>
                            <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/ico-contact-phone.png">
                        </em>
                        <div class="text"><?
                                // включаема¤ область дл¤ раздела
                                $APPLICATION->IncludeFile(SITE_DIR."include/phone.php", Array(), Array(
                                        "MODE"      => "html",                                           // будет редактировать в веб-редакторе
                                        "NAME"      => "Телефон",      // текст всплывающей подсказки на иконке
                                        "TEMPLATE"  => "section_include_template.php"                    // им¤ шаблона дл¤ нового файла
                                    ));
                            ?><br><a href="<?=SITE_DIR?>ajax/callback.php" class="callback callback-popup-link">Обратный звонок</a></div>
                    </div>
                </div>
                <div class="box">
                    <div class="holder">
                        <em>
                            <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/ico-contact-skype.png">
                        </em>
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
                        <em>
                            <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/ico-contact-mail.png">
                        </em>
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
</div>
<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>