<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    ob_start();
    $APPLICATION->IncludeComponent(
        "advent:sale.basket.basket", 
        "popup", 
        array(
            "OFFERS_PROPS" => array(
                0 => "COLOR",
            ),
            "PATH_TO_ORDER" => SITE_DIR."personal/order/",
            "PATH_TO_BASKET" => SITE_DIR."personal/basket/",
            "HIDE_COUPON" => "Y",
            "COLUMNS_LIST" => array(
                0 => "NAME",
                1 => "DELETE",
                2 => "PRICE",
                3 => "QUANTITY",
                4 => "PROPERTY_MORE_PHOTO",
            ),
            "PRICE_VAT_SHOW_VALUE" => "Y",
            "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
            "USE_PREPAYMENT" => "N",
            "SET_TITLE" => "N",
            "QUANTITY_FLOAT" => "N",
            "ACTION_VARIABLE" => "action"
        ),
        false
    );
    $basket_string = ob_get_contents();
    ob_end_clean();

    $APPLICATION->AddViewContent("basket", $basket_string, 1);
?>
<?if($APPLICATION->GetCurPage(false) != SITE_DIR):?>
    </div><!--.container-->
    <?endif?>
</div>

<?
    // âêëþ÷àåìàÿ îáëàñòü äëÿ ðàçäåëà
    $APPLICATION->IncludeFile(SITE_DIR."include/bottom-feed.php", Array(), Array(
            "MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
            "NAME"      => GetMessage('FOOTER_NEWS'),      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
            "TEMPLATE"  => "section_include_template.php"                    // èìÿ øàáëîíà äëÿ íîâîãî ôàéëà
        ));
?>
<div id="footer" class="new">
    <div class="container">
        <div class="footer-right boxes">
            <div class="rows">
              <div class="box">
                <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                        "AREA_FILE_SHOW" => "sect",
                        "AREA_FILE_SUFFIX" => "footer_text",
                        "AREA_FILE_RECURSIVE" => "Y",
                        "EDIT_TEMPLATE" => "standard.php"
                    )
                );?>
                <div class="address-box">
                  <div class="row address">
                    <p><?// âêëþ÷àåìà¤ îáëàñòü äë¤ ðàçäåëà
                        $APPLICATION->IncludeFile(SITE_DIR."include/address_footer.php", Array(), Array(
                                "MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
                                "NAME"      => GetMessage('FOOTER_ADRESS'),      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
                                "TEMPLATE"  => "section_include_template.php"                    // èì¤ øàáëîíà äë¤ íîâîãî ôàéëà
                            )
                        );
                    ?></p>
                  </div>
                  <div class="row tel">
                    <p><?// âêëþ÷àåìà¤ îáëàñòü äë¤ ðàçäåëà
                        $APPLICATION->IncludeFile(SITE_DIR."include/telephone.php", Array(), Array(
                                "MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
                                "NAME"      =>  GetMessage('FOOTER_PHONE'),      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
                                "TEMPLATE"  => "section_include_template.php"                    // èì¤ øàáëîíà äë¤ íîâîãî ôàéëà
                            )
                        );
                    ?></p>
                  </div>
                  <div class="row mail">
                    <p><a href="mailto:<?require_once($_SERVER['DOCUMENT_ROOT'].SITE_DIR."include/email.php")?>"><?
                        $APPLICATION->IncludeFile(SITE_DIR."include/email.php", Array(), Array(
                                "MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
                                "NAME"      => "Email",      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
                                "TEMPLATE"  => "section_include_template.php"                    // èì¤ øàáëîíà äë¤ íîâîãî ôàéëà
                            )
                        );
                    ?></a></p>
                  </div>
                  <div class="row skype">
                    <p><?// âêëþ÷àåìà¤ îáëàñòü äë¤ ðàçäåëà
                        $APPLICATION->IncludeFile(SITE_DIR."include/skype.php", Array(), Array(
                                "MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
                                "NAME"      => "Skype",      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
                                "TEMPLATE"  => "section_include_template.php"                    // èì¤ øàáëîíà äë¤ íîâîãî ôàéëà
                            )
                        );
                    ?></p>
                  </div>
                </div>
              </div>
              <div class="box">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "action",
                    array(
                        "ROOT_MENU_TYPE" => "actions",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "actions",
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
              </div>
              <div class="box tablet-hide">
                <?$APPLICATION->IncludeComponent("bitrix:search.tags.cloud","bottom",Array(
                        "FONT_MAX" => "13",
                        "FONT_MIN" => "13",
                        "COLOR_NEW" => "FFFFFF",
                        "COLOR_OLD" => "FFFFFF",
                        "PERIOD_NEW_TAGS" => "",
                        "SHOW_CHAIN" => "N",
                        "COLOR_TYPE" => "Y",
                        "WIDTH" => "100%",
                        "SORT" => "NAME",
                        "PAGE_ELEMENTS" => "150",
                        "PERIOD" => "",
                        "URL_SEARCH" => SITE_DIR."search/",
                        "TAGS_INHERIT" => "Y",
                        "CHECK_DATES" => "Y",
                        "FILTER_NAME"=> "",
                        "arrFILTER" => Array("no"),
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600"
                    )
                );?>
              </div>
              <div class="box">
                <h3>Мы в соцсетях</h3>
                <?// âêëþ÷àåìàÿ îáëàñòü äëÿ ðàçäåëà
                $APPLICATION->IncludeFile(SITE_DIR."include/bottom-social.php", Array(), Array(
                        "MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
                        "NAME"      => GetMessage('FOOTER_EDIT'),      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
                        "TEMPLATE"  => "section_include_template.php"                    // èìÿ øàáëîíà äëÿ íîâîãî ôàéëà
                    )
                );
                ?>
                <?$APPLICATION->IncludeFile(SITE_DIR."include/subscribe_form.php", Array(), Array(
                    "MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
                    "NAME"      => "subscribe_form",      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
                    "TEMPLATE"  => "section_include_template.php"                    // èì¤ øàáëîíà äë¤ íîâîãî ôàéëà
                ));?>
                <div id="bx-composite-banner"></div>
              </div>
            </div>
        </div>
    </div>
    <div class="copyright">
      <div class="container">
        <p class="copy">
            <?// âêëþ÷àåìàÿ îáëàñòü äëÿ ðàçäåëà
            $APPLICATION->IncludeFile(SITE_DIR."include/copyright.php", Array(), Array(
                    "MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
                    "NAME"      => GetMessage('FOOTER_EDIT'),      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
                    "TEMPLATE"  => "section_include_template.php"                    // èìÿ øàáëîíà äëÿ íîâîãî ôàéëà
                )
            );?>
        </p>
      </div>
    </div>
</div>
	</div><!--.wrapper-inner-->

</div><!--#wrapper-->
      </div>
    </div>
  </div>
</div>

<?
    // âêëþ÷àåìàÿ îáëàñòü äëÿ ðàçäåëà
    $APPLICATION->IncludeFile(SITE_DIR."include/popups.php", Array(), Array(
            "MODE"      => "html",                                           // áóäåò ðåäàêòèðîâàòü â âåá-ðåäàêòîðå
            "NAME"      => "Popups",      // òåêñò âñïëûâàþùåé ïîäñêàçêè íà èêîíêå
            "TEMPLATE"  => "section_include_template.php"                    // èìÿ øàáëîíà äëÿ íîâîãî ôàéëà
        ));
?>

	<div class="ajax-tmp"></div>

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-73212558-1', 'auto');
	  ga('send', 'pageview');

	</script>

	<!-- Yandex.Metrika counter -->
	<script type="text/javascript">
	(function (d, w, c) {
		(w[c] = w[c] || []).push(function() {
			try {
				w.yaCounter34016145 = new Ya.Metrika({id:34016145,
						webvisor:true,
						clickmap:true,
						trackHash:true});
			} catch(e) { }
		});

		var n = d.getElementsByTagName("script")[0],
			s = d.createElement("script"),
			f = function () { n.parentNode.insertBefore(s, n); };
		s.type = "text/javascript";
		s.async = true;
		s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

		if (w.opera == "[object Opera]") {
			d.addEventListener("DOMContentLoaded", f, false);
		} else { f(); }
	})(document, window, "yandex_metrika_callbacks");
	</script>
	<noscript><div><img src="//mc.yandex.ru/watch/34016145" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->

    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/lemmon-slider.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.jcountdown1.3.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.mixitup.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.formstyler.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.mCustomScrollbar.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.infinitecarousel3.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/owl.carousel.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.main.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/fancybox/source/jquery.fancybox.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/scripts.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/product.share.js"></script>        
</body>
</html>