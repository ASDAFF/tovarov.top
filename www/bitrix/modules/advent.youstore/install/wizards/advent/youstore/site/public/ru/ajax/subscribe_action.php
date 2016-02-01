<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); 
    global $APPLICATION, $USER;
    
    //echo "INIT<br/>";
    
    $backUrl = ($_REQUEST["backurl"]?:$_SERVER["HTTP_REFERER"])?:"#SITE_DIR#";
if(CModule::IncludeModule("subscribe")){
        
        //echo "INCLUDE<br/>";
        
        $RUB_ID = $_REQUEST["RUB_ID"];//?:array(1);
        if(empty($RUB_ID)){
            $rbkIDs = array();            
            $rubSelect = array("SORT" => "ASC", "NAME" => "ASC");
            $rubFilter = array("ACTIVE" => "Y", "VISIBLE" => "Y",'NAME'=>'Акции');
            
            $dbRub = CRubric::GetList($rubSelect, $rubFilter);
            while($arRubric = $dbRub->GetNext()) 
            { 
               echo  $rbkIDs[] = $arRubric["ID"]; 
            }
            
            $RUB_ID = $rbkIDs;
        }
        
        $email = $_REQUEST["EMAIL"];
        $ID = ($USER->IsAuthorized()? $USER->GetID():false);
        
        //echo "DATACHECK ID=$ID, EMAIL=$email<br/>";
        
        if($ID || !empty($email)){
            //echo "DATA_VALID<br/>";
            if(empty($email)) $email = $USER->GetEmail();
            $subscr = new CSubscription;
            
            //echo "SEARCH SUBSCRIPTION<br/>";
            
            $arSFields = array(
                "USER_ID" => $ID,
                "FORMAT" => "html",
                "ACTIVE" => "Y",
                "EMAIL" => $email,
                "SEND_CONFIRM" => "N",
                "CONFIRMED" => "Y",
                "DATE_CONFIRM" => ConvertTimeStamp(time(), "SHORT", "ru"),
                "RUB_ID" => $RUB_ID,
                "SEND_CONFIRM" => "N"
            );
                
            
            $dbSubscr = CSubscription::GetByEmail($email);
            if($arSubscr = $dbSubscr->GetNext()){
            //    echo "FOUND.UPDATE<br/>";
                $result = $subscr->Update($arSubscr["ID"], $arSFields, "#SITE_ID#");
            }else{
            //    echo "NOT FOUND.ADD<br/>";            
                $result = $subscr->Add($arSFields, "#SITE_ID#");
            //    echo $subscr->LAST_ERROR;
            }
        } 
    }
  //  LocalRedirect($backUrl);
?>