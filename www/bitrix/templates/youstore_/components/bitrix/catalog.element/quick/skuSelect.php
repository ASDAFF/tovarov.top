<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']) && !empty($arResult['OFFERS_PROP']))
{
    ?>
    <div class="selects">
        <?
        $arSkuProps = array();
        ?>
        <div class="item_info_section" id="<? echo $arItemIDs['PROP_DIV']; ?>">
            <?
            foreach ($arResult['SKU_PROPS'] as &$arProp)
            {
                if (!isset($arResult['OFFERS_PROP'][$arProp['CODE']]))
                    continue;
                $arSkuProps[] = array(
                    'ID' => $arProp['ID'],
                    'SHOW_MODE' => $arProp['SHOW_MODE'],
                    'VALUES_COUNT' => $arProp['VALUES_COUNT']
                );

                if ('TEXT' == $arProp['SHOW_MODE'])
                {
                    $strSlideStyle = 'display: none;';
                    ?>
                    <div class="" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont" style="display: inline-block">
                        <div class="memory-holder">
                            <?/*<span><? echo htmlspecialcharsex($arProp['NAME']); ?>:</span>*/?>
                            <span class="select">
                                    <div class="__trigger"><a><?=GetMessage("NOTHIN_SELECTED")?></a></div>
                                    <s></s>
                                    <ul style="display:none" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list">
                                        <?
                                        $input_val = GetMessage('CATALOG_NONSELECTED');
                                        $i = 0;
                                        foreach ($arProp['VALUES'] as $arOneValue)
                                        {
                                            if($arOneValue["ID"] > 0){
                                                if($i == 0) $input_val = $arOneValue["NAME"];
                                                $i++;
                                            }
                                            ?>
                                            <li
                                                data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID']; ?>"
                                                data-onevalue="<? echo $arOneValue['ID']; ?>"
                                                ><a href="javascript:void(0)"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></a></li>
                                        <?
                                        }
                                        ?>
                                    </ul>
                                <?/*<input type="text" readonly placeholder="<?=$input_val?>" value="" />*/?>
                                </span>
                        </div>
                        <div class="bx_slide_left hidden" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
                        <div class="bx_slide_right hidden" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
                    </div>
                <?
                }
                elseif ('PICT' == $arProp['SHOW_MODE'])
                {
                    $strSlideStyle = 'display: none;';
                    ?>

                    <div id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont" style="display: inline-block">
                        <div class="color-holder" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
                                <span class="select">
                                    <div class="__trigger"></div>
                                    <s></s>
                                    <ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" class="color-list">
                                        <?
                                        foreach ($arProp['VALUES'] as $arOneValue)
                                        {
                                            ?>
                                            <li
                                                data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID'] ?>"
                                                data-onevalue="<? echo $arOneValue['ID']; ?>"
                                                >
                                                <a style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');" class="cnt_item" title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>">
                                                    <? echo htmlspecialcharsbx($arOneValue['NAME']); ?>
                                                </a>
                                            </li>
                                        <?
                                        }
                                        ?>
                                    </ul>
                                </span>
                            <div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
                            <div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
                        </div>
                    </div>
                <?
                }
            }
            unset($arProp);
            ?>
        </div>
    </div>
<?
}
?>