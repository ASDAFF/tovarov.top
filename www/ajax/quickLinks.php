<?
define("NO_KEEP_STATISTIC", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");?>
<ul class="page-nav">
    <li class="back">
        <a href="#header">
            <span class="ico">&nbsp;</span>
            <span class="text">Наверх</span>
        </a>
    </li>
    <li class="views">
        <a href="/personal/visited/">
            <span class="ico">&nbsp;</span>
            <span class="text">Просмотренные товары</span>
        </a>
    </li>
    <li class="compare-nav">
        <a href="/catalog/compare.php">
            <span class="ico">&nbsp;</span>
            <span class="text">В сравнении (<?=count($_SESSION["CATALOG_COMPARE_LIST"]["1"]["ITEMS"])?>)</span>
        </a>
    </li>
    <li class="like-nav">
        <a href="/personal/wishlist/">
            <span class="ico">&nbsp;</span>
            <span class="text">Лист желаний (<?CModule::IncludeModule("sale");
            echo intval(CSaleBasket::GetList(
                array(
                        "NAME" => "ASC",
                        "ID" => "ASC"
                    ),
                array(
                        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                        "ORDER_ID" => "NULL",
                        "DELAY" => "Y"
                    ),
                array()
            ));
            ?>)</span>
        </a>
    </li>
    <?/*<li class="reviews">
        <a href="#">
            <span class="ico">&nbsp;</span>
            <span class="text">Онлайн-консультант</span>
        </a>
    </li>
    */?>
</ul>