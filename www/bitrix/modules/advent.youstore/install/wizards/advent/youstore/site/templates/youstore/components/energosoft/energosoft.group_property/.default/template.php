<?
######################################################
# Name: energosoft.grouping                          #
# File: template.php                                 #
# (c) 2005-2012 Energosoft, Maksimov M.A.            #
# Dual licensed under the MIT and GPL                #
# http://energo-soft.ru/                             #
# mailto:support@energo-soft.ru                      #
######################################################
?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<?
$groupCount = 0;
foreach($arResult as $arElement):
	if($arElement["PROPERTIES"])foreach($arElement["PROPERTIES"] as $key => $prop){
		if(empty($prop["VALUE"])) unset($arElement["PROPERTIES"][$key]);
	}
?>
	<?if(count($arElement["PROPERTIES"]) > 0 || $arParams["ES_SHOW_EMPTY"] == "Y"):
		if(++$groupCount > $arParams["ES_SHOW_GROUP_COUNT"] && $arParams["ES_SHOW_GROUP_COUNT"] > 0) break;
	?>
	<div class="tab-box">
		<img class="tab-img" src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" alt="#" width="33" height="31">
		<h3 class="box-title"><?=$arElement["NAME"]?></h3>
		<ul class="tab-details">
			<?foreach($arElement["PROPERTIES"] as $arProp):?>
                <?if($arProp["VALUE"] != "" || $arParams["ES_SHOW_EMPTY_PROPERTY"] == "Y"):?>
                    <?if(!empty($arProp["DESCRIPTION"])):?>
                        <?if(count($arResult["VALUES"][$arProp["CODE"]]) > 1):?>
                            <?foreach($arResult["VALUES"][$arProp["CODE"]] as $prop):?>
                                <li>
                                    <p class="label"><span><?=$prop["VALUE"]?></span></p>
                                    <p class="value"><?=$prop["DESCRIPTION"]?></p>
                                </li>
                            <?endforeach;?>
                        <?else:?>
                            <li>
                                <p class="label"><span><?=$arProp["VALUE_ENUM"]==""?$arProp["DISPLAY_VALUE"]:$arProp["VALUE_ENUM"]?></span></p>
                                <p class="value"><?=$arProp["DESCRIPTION"]?></p>
                            </li>
                        <?endif?>
                    <?else:?>
                        <li>
                            <p class="label">
                                <span><?
                                    $string = preg_replace('~(.*)\[(.*)\]~', "\$1", $arProp["NAME"]);
                                    echo $string;
                                ?>
                                </span>
                            </p>
                            <p class="value">
                                <?if(count($arResult["VALUES"][$arProp["CODE"]]) > 1):
                                    $valStr = "";
                                    ?>
                                    <?foreach($arResult["VALUES"][$arProp["CODE"]] as $value){
                                        $valStr .= (($value["VALUE_ENUM"]?:$value["VALUE"]) . " <br/> ");
                                    }?>
                                    <?echo rtrim($valStr, " <br/> ");?>
                                <?else:?>
                                    <?=$arProp["VALUE_ENUM"]==""?$arProp["DISPLAY_VALUE"]:$arProp["VALUE_ENUM"]?>
                                <?endif?>
                            </p>
                        </li>
                    <?endif?>
                <?endif;?>
			<?endforeach;?>
		</ul>
	</div>
	<?endif;?>
<?endforeach;?>