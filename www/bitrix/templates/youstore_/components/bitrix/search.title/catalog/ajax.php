<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    if(!empty($arResult["CATEGORIES"])):?>
    <div class="search-drop" style="display:block;">
        <ul class="title-search-result">
            <?
                $moreStr = "";
                $moreCnt = 1;
                foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
                <?foreach($arCategory["ITEMS"] as $i => $arItem):?>
                    <?
                        if(isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]])):
                            $arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];
                        ?>
                        <li>
                       
                            <a class="gray" href="<?=$arItem["URL"]?>">
                                <?if(is_array($arElement['PICTURE'])):?><span class="image">
                                    <img alt="image" src="<?=$arElement['PICTURE']['src']?>">
                                </span>
                                <?endif;?>
                                <span class="text-left"><span class="bg"></span><?echo $arItem["NAME"]?></span>
                                <span class="text-right">
                                    <?
                                        $hasPrice = false;
                                        $currency = "RUB";
                                        foreach($arElement["PRICES"] as $code=>$arPrice):
                                            $currency = $arPrice["CURRENCY"];
                                        ?>
                                        <?if($arPrice["CAN_ACCESS"]):
                                                $hasPrice = true;
                                            ?>
                                            <?=$arPrice["DISCOUNT_VALUE"]?> <sup><?=GetMessage("CATALOG_".$arPrice["CURRENCY"]."_TITLE")?></sup>
                                            <?break;endif;?>
                                        <?endforeach;
                                        if(!$hasPrice){ echo '0 <sup>'.GetMessage("CATALOG_".$currency."_TITLE").'</sup>';}
                                    ?>
                                </span>
                            </a>
                        </li>
                        <?endif;?>
                    <?endforeach;?>
                <?endforeach;?>
        </ul>
    </div>
    <?endif;
?>