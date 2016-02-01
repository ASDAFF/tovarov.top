<?
    if(!function_exists(findId)){
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

    if(!function_exists(findCode)){
        function findCode($id,$val){
            if(CModule::IncludeModule("iblock"))
            {
                $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", 'ID'=>$id));
                while ($prop_fields = $properties->GetNext())
                {
                    $temp['CODE'] = $prop_fields['CODE'];
                    if($prop_fields['PROPERTY_TYPE']=='L')
                    {
                        $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array( "CODE"=>$prop_fields['CODE'],'ID'=>$val));
                        while($enum_fields = $property_enums->GetNext())
                        {
                            $temp['VALUE'] =$enum_fields["VALUE"];
                        }

                    }
                }
                return $temp;
            }else{
                return false;
            }
        } 
    }
    if(!function_exists(getSectionId)){
        function getSectionId($code){
            $uf_arresult = CIBlockSection::GetList(Array(), Array('CODE'=>$code), false, array('ID'));
            if($uf_value = $uf_arresult->GetNext()):
                $id = $uf_value['ID'];
                endif;
            return $id;      
        }  
    }  
?>