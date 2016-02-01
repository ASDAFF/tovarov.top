<?
define('SITE_DIR', '/');
define('SITE_ID', 's1');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); 

/*if(($_REQUEST['action']=='ADD2BASKET' || $_REQUEST['action']=='ADD_DELAY2BASKET') && intval($_REQUEST['id'])>0){
    CModule::includeModule('catalog');
    CModule::includeModule('iblock');
    $id=$_REQUEST['id'];
    $mxResult = CCatalogSku::GetProductInfo($id);
    if (is_array($mxResult))$ib=$mxResult['IBLOCK_ID']; 
    else $ib=CIBlockElement::GetIBlockByID($id);
    $quantity=intval($_REQUEST['quantity'])>0?intval($_REQUEST['quantity']):'1';
    if($_REQUEST['prop']){
        $propsTemp=json_decode(urldecode($_REQUEST['prop']));
        $product_properties = CIBlockPriceTools::GetOfferProperties($id,$ib,$propsTemp,array()); 
    }
    Add2BasketByProductID($id, $quantity, array(), $product_properties);
   
}*/
$APPLICATION->IncludeComponent("advent:sale.basket.basket.small", "links", array(
    "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
    "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
    "PATH_TO_WISHLIST" => SITE_DIR."personal/wishlist/",
    "SHOW_DELAY" => "Y",
    "SHOW_NOTAVAIL" => "N",
    "SHOW_SUBSCRIBE" => "N",
    "DISPLAY_IMG_WIDTH" => "70",
    "DISPLAY_IMG_HEIGHT" => "89",
    "DISPLAY_IMG_PROP" => "Y"
    ),
    false
);
?>