<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
        die();

    COption::SetOptionString("sale", "SHOP_SITE_".WIZARD_SITE_ID, WIZARD_SITE_ID);
    COption::SetOptionString("fileman", "propstypes", serialize(array("description"=>GetMessage("MAIN_OPT_DESCRIPTION"), "keywords"=>GetMessage("MAIN_OPT_KEYWORDS"), "title"=>GetMessage("MAIN_OPT_TITLE"), "keywords_inner"=>GetMessage("MAIN_OPT_KEYWORDS_INNER"))), false, $siteID);
    COption::SetOptionInt("search", "suggest_save_days", 250);
    COption::SetOptionString("search", "use_tf_cache", "Y");
    COption::SetOptionString("search", "use_word_distance", "Y");
    COption::SetOptionString("search", "use_social_rating", "Y");
    COption::SetOptionString("iblock", "use_htmledit", "Y");

    COption::SetOptionString("main", "captcha_registration", "N");

    //socialservices
    if (COption::GetOptionString("socialservices", "auth_services") == "")
    {
        $bRu = (LANGUAGE_ID == 'ru');
        $arServices = array(
            "VKontakte" => "N",  
            "MyMailRu" => "N",
            "Twitter" => "N",
            "Facebook" => "N",
            "Livejournal" => "Y",
            "YandexOpenID" => ($bRu? "Y":"N"),
            "Rambler" => ($bRu? "Y":"N"),
            "MailRuOpenID" => ($bRu? "Y":"N"),
            "Liveinternet" => ($bRu? "Y":"N"),
            "Blogger" => "Y",
            "OpenID" => "Y",
            "LiveID" => "N",
        );
        COption::SetOptionString("socialservices", "auth_services", serialize($arServices));
    }
    if(COption::GetOptionString("youstore", "wizard_installed", "N", WIZARD_SITE_ID) != "Y")
   {
    $et = new CEventType;
    $et->Add(array(
        "LID"           => 'ru',
        "EVENT_NAME"    => 'CALLBACK',
        "NAME"          => GetMessage('MAIN_OPT_CALLBACK_NAME'),
        "DESCRIPTION"   => ''
    ));
    $arr["ACTIVE"] = "Y";
    $arr["EVENT_NAME"] = "CALLBACK";
    $arr["LID"] = array("ru","en");
    $arr["EMAIL_FROM"] = "#DEFAULT_EMAIL_FROM#";
    $arr["EMAIL_TO"] = "#DEFAULT_EMAIL_FROM#";
    $arr["SUBJECT"] = GetMessage('MAIN_OPT_SUBJECT');
    $arr["BODY_TYPE"] = "text";
    $arr["MESSAGE"] = GetMessage('MAIN_OPT_MESS');

    $emess = new CEventMessage;
    $emess->Add($arr);   }
?>