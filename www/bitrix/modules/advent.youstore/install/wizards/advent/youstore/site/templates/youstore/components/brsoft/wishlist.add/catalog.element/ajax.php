<?
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); 
	global $APPLICATION, $DB, $USER;
	
	$result = array("result" => false, "err_code" => 0);
	if(CModule::IncludeModule("brsoft.wishlist") && CModule::IncludeModule("iblock")){
		$action = $_REQUEST["ACTION"];
		$WL_USER_ID = CBrWishlist::GetWLUserID();
		
		switch($action){
			case 'DELETE':
				$wID = intval($_REQUEST["WID"]);
					if($wID <= 0){
						$pID = intval($_REQUEST["PID"]);
						$iID = intval($_REQUEST["IID"]);
						if($pID > 0 && $iID > 0){
							$dbWID = CBrWishlist::GetList(array(), array("WL_USER_ID" => $WL_USER_ID, "PARAM3" => $pID, "PARAM2" => $iID), array("ID"));
							if($arWID = $dbWID->GetNext()){
								$wID = $arWID["ID"];
							}
						}
					}
					
					if($wID > 0){
						if(CBrWishlist::GetCount(array("ID" => $wID, "WL_USER_ID" => $WL_USER_ID)) > 0){
							CBrWishlist::Delete($wID);
							$result["result"] = true;
						}else{
							$result["err_code"] = -100;//security exception
						}
					}else{
						$result["err_code"] = -3;//wID doesn't exists, can't delete 0;
					}
				break;
			case 'ADD': 
				$param1 = $_REQUEST["PARAM1"];
				$param2 = intval($_REQUEST["PARAM2"])?:false;
				$param3 = intval($_REQUEST["PARAM3"]);
				
				if($param3 <= 0) {$result["err_code"] = -4;/*unknow element*/ break;}
				
				if(!$param2){
					$param2 = CIBlockElement::GetIBlockByID($param3);
					if(!$param2){$result["err_code"] = -5;/*unknown iblock_id*/ break;}
				}
				
				$dbWishlistElement = CBrWishlist::GetList(array(), array("WL_USER_ID" => $WL_USER_ID, "PARAM1" => $param1, "PARAM2" => $param2, "PARAM3" => $param3), array("ID"));
				if($arWishlistElement = $dbWishlistElement->GetNext()){
					//element already exists
					$result["WID"] = $arWishlistElement["ID"];
				}else{
					//add element to wishlist
					$result["WID"] = CBrWishlist::Add(array("WL_USER_ID" => $WL_USER_ID, "PARAM1" => $param1, "PARAM2" => $param2, "PARAM3" => $param3));
				}
				
				$result["result"] = true;
				
				break;
			case 'CHECK':
				$param1 = $_REQUEST["PARAM1"];
				$param2 = intval($_REQUEST["PARAM2"])?:false;
				$param3 = intval($_REQUEST["PARAM3"]);
				
				$dbWishlistElement = CBrWishlist::GetList(array(), array("WL_USER_ID" => $WL_USER_ID, "PARAM1" => $param1, "PARAM2" => $param2, "PARAM3" => $param3), array("ID"));
				if($arWishlistElement = $dbWishlistElement->GetNext()){
					//element already exists
					$result["WID"] = $arWishlistElement["ID"];
					$result["result"] = true;
				}
				
				break;
			default: $result["err_code"] = -2; /*unknown action type*/
				break;
		}
	}else{
		$result["err_code"] = -1;//Модуль не установлен
	}
	
	//$APPLICATION->RestartBuffer();
	echo json_encode($result);
	die();
?>