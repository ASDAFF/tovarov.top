<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<div class="review-section">
    <div class="brief">
        <h2><?=$arResult['NAME']?></h2>
        <?=$arResult["DETAIL_TEXT"]?:$arResult["PREVIEW_TEXT"]?>
    </div>
    <?if(is_array($arResult['TABS'])):?>

        <div class="rew-cols">
            <div class="links">
                <?foreach($arResult['TABS'] as $key => $tab):?>
                    <div class="item look">
                        <a href="#box-<?=$key+1?>" <?=($key==0)?'class="active"':''?>>
                            <span class="icon">
                                <span class="icon-holder">
                                    <img alt="icon" src="<?=$tab['TYPE']['ICO']?>" />
                                </span>
                            </span>

                            <em class="ico-text"><?=$tab['TYPE']['NAME']?></em>
                        </a>
                    </div>
                    <?endforeach;?>
            </div>



            <div class="contents-holder">
                <?foreach($arResult['TABS'] as $key => $tab):?>
                    <div class="content-box" id="box-<?=$key+1?>">
                        <h2><?=$tab['NAME']?></h2>
                        <?if(is_array($tab['PHOTOS'])):?>
<?if($tab['PHOTOS']['PICS']):?>
                            <div class="content-gal">
                                <a href="#" class="link-prev">prev</a>
                                <div class="mask">
                                    <ul class="slides">
                                        <?foreach($tab['PHOTOS']['PICS'] as $key => $picture):?>                                              
                                            <li>
                                                <a href="#">
                                                    <img alt="image" src="<?=$picture['src']?>" />
                                                    <span class="text-head"><?=$tab['PHOTOS']['DESC'][$key]?></span>
                                                </a>
                                            </li>
                                            <?endforeach;?>
                                    </ul>
                                </div>
                                <a href="#" class="link-next">next</a>
                            </div>
<?endif;?>
                            <?endif;?>
                        <div class="text-details">
                            <?=$tab['TEXT']?>
                        </div>
                    </div>
                    <?endforeach;?>
            </div>
        </div>

        <?endif;?>
</div>
 
