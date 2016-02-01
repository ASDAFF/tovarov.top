<?
    if(!function_exists('fCmp')){   
        function fCmp($a, $b){
        if ($a['SORT'] === $b['SORT']) return 0;
        return $a['SORT'] < $b['SORT'] ? -1 : 1;
        }
    }

    function checkValueExists($val, $arr){
        if(empty($arr) || empty($val)) return false;

        if(is_array($arr)){
            return in_array($val, $arr, true);
        }else{
            return $val == $arr;
        }
    }

    function prepareIBlockPropertyValue($val, $property){
        $result = false;//array();
        $user_type = $property["INPUT_TYPE"];
        $multiply = $property["PROPERTY_DEF"]["MULTIPLE"] == "Y"; //if multi

        if($multiply){
            if(!is_array($val)) $val = array($val); //make array for multi field
        }

        switch($user_type){
            case 'S':
                $result = $val;
                break;//string
            case 'T':
                if($multiply){
                    foreach($val as $v){
                        $result[] = array("VALUE" => array("TEXT" => $v, "TYPE" => "html"));
                    }
                }else{
                    //foreach($val as $v){
                    $result = array("VALUE" => array("TEXT" => $val, "TYPE" => "html"));
                    //}
                }
                break;//textarea
            case 'F':
				if($multiply){
					foreach($_FILES[$property["CODE"]]["tmp_name"] as $v){
						$result[] =  CFile::MakeFileArray($v);
					}
				}
				else{
					$result = $_FILES[$property["CODE"]];
				}
                break;//file
            case 'E':
                $result = $val;
                break;//iblock element
            case 'G':
                $result = $val;
                break;//iblock group
            case 'L':
                $result = $val;
                break;//list | checkboxes
            case 'C':
                $result = $val;
                break;//list | checkboxes
            case 'H':
                if($multiply){
                    foreach($val as $v){
                        $result[] = array("VALUE" => array("TEXT" => $v, "TYPE" => "html"));
                    }
                }else{
                    $result = array("VALUE" => array("TEXT" => $val, "TYPE" => "html"));
                }
                break;//html|text
            default:
                if(is_array($val)){
                    foreach($val as $v){
                        $result[] = array("VALUE" => $v);
                    }
                }else $result = $val;
                break;//unknown
        }

        return $result;
    }
?>