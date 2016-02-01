<?
    /**
    * @author  
    * @email   
    * @version 0.00, 06/06/14
    **/

    IncludeTemplateLangFile(__FILE__);
?>
<?CAjax::Init();?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CHARSET?>" />
    <?$APPLICATION->ShowHead()?>
	<meta name="viewport" content="initial-scale=1">
    <title><?=$APPLICATION->ShowTitle()?></title>

    <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery-1.9.1.min.js"></script>


    <link media="all" rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/jquery.ui.slider.css" />
    <link media="all" rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/jquery.formstyler.css" />
    <link media="all" rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/owl.carousel.css" />
    <link media="all" rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/owl.transitions.css" />
    <link media="all" rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/jquery.mCustomScrollbar.css" />
    <link media="all" rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/styles.css" />
    <link media="all" rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/stars.css" />
    <link media="all" rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/js/fancybox/source/jquery.fancybox.css" />    



    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/bitrix/system.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/bitrix/section.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/bitrix/element.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/bitrix/compare.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/bitrix/iblockvote.js"></script>

    <script>
        var sd='<?=SITE_DIR?>';
        var hours1='<?=GetMessage('HEADER_HOUERS')?>';
        var minutes='<?=GetMessage('HEADER_MINUTES')?>';
        var seconds='<?=GetMessage('HEADER_SECS')?>';
        var more='<?=GetMessage('HEADER_MORE')?>';
        var nowish='<?=GetMessage('HEADER_NOWISH')?>';
        var resadded='<?=GetMessage('HEADER_RESUM')?>';
        
        var js_about_city='<?=GetMessage('JS_ABOUT_CITY')?>';
        var js_menu_name='<?=GetMessage('JS_MENU_NAME')?>';
    </script>



</head>
<body class="<?=$APPLICATION->ShowProperty("body-class")?>">

<div class="wrapper-frame">
  <div class="w1">
	<div class="w2">
	<div class="outer-wrapper">

<div class="toolbox">
	<div class="holder">
		<a href="#" class="link-up" style="display: none;"><span><?=GetMessage('UP')?></span></a>
		<div class="links" style="display: block;">
			<script type="text/javascript">
				var wished = [];
			</script>
			<?
			Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("wishlist");
				$APPLICATION->IncludeComponent("advent:wishlist.viewed.line", "", Array(
						"PATH_TO_WISHLIST" => SITE_DIR."personal/wishlist/",    // Ñòðàíèöà èçáðàííîãî
						"PATH_TO_VISITED" => SITE_DIR."personal/visited/",
						"VIEWED_COUNT" => "999",
					),
					false
				);
			Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("wishlist", "...");
			?>
		</div>
		<a href="#" class="btn-plus" style="display: none;"><span><?=GetMessage('PLUS')?></span></a>
	</div>
</div>
<?//google.analytics (now .default)
$APPLICATION->IncludeFile(SITE_DIR."include/analytics/google_analytics.php", Array(), Array(
	"MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
	"NAME"      => GetMessage('HEADER_GA'),      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
	"TEMPLATE"  => "section_include_template.php"                    // èìÿ øàáëîíà äëÿ íîâîãî ôàéëà
));?>
<?if($USER->IsAuthorized()):?>
    <div id="panel">
        <?$APPLICATION->ShowPanel();?>
    </div>
<?endif?>
<div id="wrapper">
<div class="wrapper-inner">
<div class="top-box">
    <div class="container">
        <?// âêëþ÷àåìàÿ îáëàñòü äëÿ ðàçäåëà
		$APPLICATION->IncludeFile(SITE_DIR."include/social.php", Array(), Array(
			"MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
			"NAME"      => GetMessage('HEADER_SOCIAL'),      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
			"TEMPLATE"  => "section_include_template.php"                    // èìÿ øàáëîíà äëÿ íîâîãî ôàéëà
		));?>
        <div class="top-nav">
            <?$APPLICATION->IncludeComponent(
				"bitrix:menu", 
				"top", 
				array(
					"ROOT_MENU_TYPE" => "top",
					"MAX_LEVEL" => "1",
					"CHILD_MENU_TYPE" => "top",
					"USE_EXT" => "Y",
					"DELAY" => "N",
					"ALLOW_MULTI_SELECT" => "N",
					"MENU_CACHE_TYPE" => "A",
					"MENU_CACHE_TIME" => "36000",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"MENU_CACHE_GET_VARS" => array(
					)
				),
				false
			);?>
            <?/*$APPLICATION->IncludeComponent(
				"bitrix:menu",
				"dop_top",
				Array(
					"ROOT_MENU_TYPE" => "dop",
					"MENU_CACHE_TYPE" => "A",
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"MENU_CACHE_GET_VARS" => "",
					"MAX_LEVEL" => "1",
					"CHILD_MENU_TYPE" => "",
					"USE_EXT" => "N",
					"DELAY" => "N",
					"ALLOW_MULTI_SELECT" => "N"
				)
			);*/?>
			<br>
        </div>
        <?// âêëþ÷àåìàÿ îáëàñòü äëÿ ðàçäåëà
		$APPLICATION->IncludeFile(SITE_DIR."include/top-lk.php", Array(), Array(
			"MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
			"NAME"      => GetMessage('HEADER_PERSONAL'),      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
			"TEMPLATE"  => "section_include_template.php"                    // èìÿ øàáëîíà äëÿ íîâîãî ôàéëà
		));?>
    </div>
</div>
<div id="header">
    <div class="container header-container">
        <strong id="logo"><a href="<?=SITE_DIR?>"><?$APPLICATION->ShowTitle()?></a></strong>
        <?$APPLICATION->IncludeComponent(
                "bitrix:search.title", 
                "catalog", 
                array(
                    "NUM_CATEGORIES" => "1",
                    "TOP_COUNT" => "5",
                    "ORDER" => "date",
                    "USE_LANGUAGE_GUESS" => "N",
                    "CHECK_DATES" => "N",
                    "SHOW_OTHERS" => "N",
                    "SHOW_PREVIEW" => "Y",
                    "PREVIEW_WIDTH" => "45",
                    "PREVIEW_HEIGHT" => "45",
                    "PRICE_CODE" => array(
                        0 => "BASE",
                    ),
                    "PAGE" => SITE_DIR."search/",
                    "CATEGORY_0_TITLE" => GetMessage('HEADER_ALLSEARCH'),
                    "CATEGORY_0" => array(
                        0 => "iblock_catalog",
                    ),
                    "CATEGORY_0_iblock_catalog" => array(
                        0 => "all",
                    ),
                    "SHOW_INPUT" => "Y",
                    "INPUT_ID" => "title-search-input",
                    "CONTAINER_ID" => "search",
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "CONVERT_CURRENCY" => "N"
                ),
                false
            );?>
        <div class="top-info">
            <div class="box call">
                <strong class="phone"> <?
                        // âêëþ÷àåìàÿ îáëàñòü äëÿ ðàçäåëà
                        $APPLICATION->IncludeFile(SITE_DIR."include/telephone.php", Array(), Array(
                                "MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
                                "NAME"      => GetMessage('HEADER_PHONE'),      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
                                "TEMPLATE"  => "section_include_template.php"                    // èìÿ øàáëîíà äëÿ íîâîãî ôàéëà
                            ));
                ?>  </strong>
                <a href="/ajax/callback.php" class="callback callback-popup-link"><?=GetMessage('HEADER_CALLBACK')?></a>
            </div>
            <div class="box clock">
                    <?
                        // âêëþ÷àåìàÿ îáëàñòü äëÿ ðàçäåëà
                        $APPLICATION->IncludeFile(SITE_DIR."include/top-work-time.php", Array(), Array(
                                "MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
                                "NAME"      => GetMessage('HEADER_WORKTIME'),      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
                                "TEMPLATE"  => "section_include_template.php"                    // èìÿ øàáëîíà äëÿ íîâîãî ôàéëà
                            ));
                    ?>
            </div>
            <div class="box location">
                <p>
                    <?
                        // âêëþ÷àåìàÿ îáëàñòü äëÿ ðàçäåëà
                        $APPLICATION->IncludeFile(SITE_DIR."include/address.php", Array(), Array(
                                "MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
                                "NAME"      => GetMessage('HEADER_ADRESS'),      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
                                "TEMPLATE"  => "section_include_template.php"                    // èìÿ øàáëîíà äëÿ íîâîãî ôàéëà
                            ));
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="nav-holder">
    <div class="nav-frame">
        <?$APPLICATION->IncludeComponent(
			"bitrix:menu", 
			"catalog", 
			array(
				"ROOT_MENU_TYPE" => "catalog",
				"MAX_LEVEL" => "3",
				"CHILD_MENU_TYPE" => "catalog",
				"USE_EXT" => "Y",
				"DELAY" => "N",
				"ALLOW_MULTI_SELECT" => "Y",
				"MENU_CACHE_TYPE" => "A",
				"MENU_CACHE_TIME" => "36000",
				"MENU_CACHE_USE_GROUPS" => "Y",
				"MENU_CACHE_GET_VARS" => array(
				)
			),
			false
		);?>
        <a href="<?=SITE_DIR?>about/actions/" class="discount-link"><?=GetMessage('HEADER_ACTIONS')?></a>
        <div class="mini-cart-holder">
			<?
			Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("basket");
			$APPLICATION->ShowViewContent("basket");
			Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("basket", "...");
			?>
        </div>
    </div>
</div>
<?if($APPLICATION->GetCurPage(false) == SITE_DIR):?>
    <?$GLOBALS['filter'] = array('PROPERTY_FOOTER' => false);
	$APPLICATION->IncludeFile(SITE_DIR."include/slider.php", Array(), Array(
			"MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
			"NAME"      => 'slider',      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
			"TEMPLATE"  => "section_include_template.php"                    // èìÿ øàáëîíà äëÿ íîâîãî ôàéëà
		));
	?>
    <?
        $APPLICATION->IncludeFile(SITE_DIR."include/shop-info.php", Array(), Array(
                "MODE"      => "html",
                "NAME"      => GetMessage('HEADER_INFO'),
                "TEMPLATE"  => "section_include_template.php"
            ));
    ?>
    <div id="main">
<?else:?>
    <?if(CSite::InDir(SITE_DIR."about/contacts/")):?>
        <div class="page-map" style="margin-top:0;">
        <?
            $APPLICATION->IncludeFile(SITE_DIR."include/contacts-map.php", Array(), Array(
                    "MODE"      => "html",
                    "NAME"      => GetMessage('HEADER_MAP'),
                    "TEMPLATE"  => ""
                ));
        ?>
	<?else:?>
        <div class="page-image">
            <?if( $APPLICATION->GetProperty("page-image") ):?>
                <img alt="image" src="<?=$APPLICATION->ShowProperty("page-image")?>"id="page-image"  />
            <?else:?>
                <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/breadcrumbs-images/img-paints.jpg" id="page-image" />
			<?endif;?>
    <?endif?>

        <div class="frame">
            &nbsp;
        </div>
        <div class="holder">
            <div class="holder-frame">
                <div class="text">
                    <h1><?=$APPLICATION->ShowProperty("prop-h1", GetMessage('HEADER_NOINSTALL'))?></h1>
                    <?$APPLICATION->IncludeComponent("bitrix:breadcrumb","",Array(
                                "START_FROM" => "0", 
                                "PATH" => "", 
                                "SITE_ID" => "s1" 
                            )
                        );?>
                </div>
            </div>
        </div>
    </div>
    <div id="main">
    <div class="container <?=$APPLICATION->ShowProperty("prop-container-class")?>">
<?endif?>
   