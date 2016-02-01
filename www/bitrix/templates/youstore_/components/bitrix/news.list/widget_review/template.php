<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="quotes-list">
    <div class="mask">
        <ul class="items">
            <?foreach($arResult['ITEMS'] as $arItem):?>        
                <li class="item">
                    <div class="quote">
                        <div class="holder">
                            <div class="frame">
                                <q><?=$arItem['PREVIEW_TEXT']?></q>
                            </div>
                        </div>
                    </div>
                    <div class="photo">
                        <img alt="image" src="<?=$arItem['RESIZE_PICTURE']['SRC']?>" />
                        <h4><?=$arItem['NAME']?></h4>
                        <?if($arItem['PROPERTIES']['POSITION']['VALUE']):?>  
                            <p><?=$arItem['PROPERTIES']['POSITION']['VALUE']?></p>
                            <?endif;?>
                    </div>
                </li>
                <?endforeach;?>
        </ul>
    </div>
    <div class="pagess">
        <ul>
            <?foreach($arResult['ITEMS'] as $key=> $arItem):?>
                <li><a href="#"><?=$key+1?></a></li>
                <?endforeach;?>

        </ul>
    </div>
</div>