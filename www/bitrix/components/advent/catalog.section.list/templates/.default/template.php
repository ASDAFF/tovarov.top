<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="cats-filter">
    <h2 class="side-title"><?=GetMessage('LIST_TITLE')?></h2>
    <ul class="cats-list">
        <?
        $CURRENT_DEPTH = $arResult["SECTION"]["DEPTH_LEVEL"]+1;
        foreach($arResult["SECTIONS"] as $arSection){
            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));

            //echo'<pre>';print_r($arSection);echo'</pre>';
            if($arSection["ELEMENT_CNT"] > 0){
                $name = trim($arResult["SECTIONS"][$arSection["IBLOCK_SECTION_ID"]]["NAME"]);
                if(!empty($name)) $name .= " / ";

                $name .= $arSection["NAME"]
                ?>
                    <li <?if($arParams["ACTIVE_SECTION_ID"] == $arSection["ID"]):?>class="active"<?endif?>>
                        <a href="<?=$APPLICATION->GetCurPageParam("SECTION_ID=".$arSection["ID"], array("SECTION_ID", "PAGEN_3", "SIZEN_3", "arrFilter_P1_MIN", "arrFilter_P1_MAX"))?>"><?=$name?> (<?=intval($arSection["ELEMENT_CNT"])?>)</a>
                    </li>
                <?
            }
        }?>
    </ul>
</div>

