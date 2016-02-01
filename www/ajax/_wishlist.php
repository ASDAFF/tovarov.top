<?
define("NO_KEEP_STATISTIC", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); 
//wishlist - РґРѕР±Р°РІР»РµРЅРёРµ РІ РѕС‚Р»РѕР¶РµРЅС‹Рµ
$action = $_REQUEST["action"];
$BASKET_ID = $PRODUCT_ID = $_REQUEST["ID"];

$bResult = false;

if (CModule::IncludeModule("catalog") && CModule::IncludeModule("sale"))
{
    if ($action == "LIKE" && IntVal($PRODUCT_ID)>0)
    {
        $bResult = Add2BasketByProductID(
			$PRODUCT_ID,
			1,
			array(
				"DELAY" => "Y"
			),
			array()
        );
    }elseif($action == "DISLIKE" && intval($BASKET_ID) > 0){
		$bResult = CSaleBasket::Delete($BASKET_ID);
	}elseif($action == "DISLIKE" && strtolower($BASKET_ID) == "all"){
		$dbBasketItems = CSaleBasket::GetList(
			array(
					"NAME" => "ASC",
					"ID" => "ASC"
				),
			array(
					"FUSER_ID" => CSaleBasket::GetBasketUserID(),
					"ORDER_ID" => "NULL",
					"DELAY" => "Y"
				),
			false,
			false,
			array("ID", "PRODUCT_ID", "DELAY")
		);
		
		while ($arItems = $dbBasketItems->Fetch())
		{
			echo'<pre>';print_r($arItems);echo'</pre>';
			//if($arItems["DELAY"] == "Y"){
				$bResult = CSaleBasket::Delete($arItems["ID"]);
			//}
		}
	}

	$APPLICATION->RestartBuffer();
	if(!$bResult) die("FAIL"); else die("OK");
}
$APPLICATION->RestartBuffer();
die("FAIL");
?>