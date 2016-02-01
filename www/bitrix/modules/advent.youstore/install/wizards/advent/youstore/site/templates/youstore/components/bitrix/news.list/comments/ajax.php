<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.06.14
 * Time: 14:13
 */
?>
<?
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

    /**
     * ERROR_CODE:
     *       0: undefined error
     *      -1: element_id is .default
     *      -2: iblock module doesn't exist
     *      -3: iblockID not found
     *      -4: iblcokElement not found
     *      -5: user has already vote for this comment
    **/

    $result = array("result" => false, "ERROR_CODE" => 0);

    $element_id = intval($_REQUEST["element_id"]);
    $vote_value = intval($_REQUEST["value"]);

    if($element_id > 0){
        //unset($_SESSION["iblock.comments"][$element_id]);
        if(!isset($_SESSION["iblock.comments"][$element_id])){
            $_SESSION["iblock.comments"][$element_id] = true;

            if(abs($vote_value) > 1){
                if($vote_value > 0){
                    $vote_value = 1;
                }else{
                    $vote_value = -1;
                }
            }

            if(CModule::IncludeModule("iblock")){
                $iblock_id = CIBlockElement::GetIBlockByID($element_id);
                if($iblock_id !== FALSE){
                    $arOrder = array("ID" => "ASC");
                    $arFilter = array(
                        "ID" => $element_id
                    );
                    $arSelect = array(
                        "ID",
                        "PROPERTY_VOTE_PLUS",
                        "PROPERTY_VOTE_MINUS"
                    );

                    $dbElement = CIBlockElement::GetList($arOrder, $arFilter, $arSelect);
                    if($arElement = $dbElement->GetNext()){
                        $property_code = ($vote_value > 0)?"VOTE_PLUS":"VOTE_MINUS";
                        $arElement["PROPERTY_".$property_code."_VALUE"] += $vote_value;
                        $property_value = $arElement["PROPERTY_".$property_code."_VALUE"];

                        CIBlockElement::SetPropertyValues($element_id, $iblock_id, $property_value, $property_code);

                        $result["result"] = true;
                        $result["VOTE_PLUS"] = $arElement["PROPERTY_VOTE_PLUS_VALUE"];
                        $result["VOTE_MINUS"] = $arElement["PROPERTY_VOTE_MINUS_VALUE"];
                    }else{
                        $result["ERROR_CODE"] = -4;
                    }
                }else{
                    $result["ERROR_CODE"] = -3;
                }
            }else{
                $result["ERROR_CODE"] = -2;
            }
        }else{
            $result["ERROR_CODE"] = -5;//update 0.0.1
        }
    }else{
        $result["ERROR_CODE"] = -1;
    }

    die(json_encode($result));
?>
