<?
    if(!function_exists('findID')){
        function findId($code){
            if(CModule::IncludeModule("iblock")){
                $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", 'CODE'=>$code));
                while ($prop_fields = $properties->GetNext())
                {
                    $temp = $prop_fields['ID'];
                }
                return $temp;
            }else{
                return false;
            }
        }
    }
?>