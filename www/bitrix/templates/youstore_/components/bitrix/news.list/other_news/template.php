<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="row white">
    <div class="row-title">
        <?=$arParams["TITLE"]?"<h2>{$arParams["TITLE"]}</h2>":""?>
    </div>
    <?foreach($arResult["ITEMS"] as $key => $arItem):
            list($day, $month) = explode(" ", $arItem["DISPLAY_ACTIVE_FROM"]);
            $month = strtoupper($month);?>
        <div class="box <?=(($key+1)%2==0)?'right':'left'?>">
            <div class="top">
                <ul class="img-tools">
                    <li class="date">
                        <div class="frame">
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
                                <strong><?=$day?></strong>
                                <?=$month?>
                            </a>
                        </div>
                    </li>
                    <li class="views">
                        <div class="frame">
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=intval($arItem["SHOW_COUNTER"])?></a>
                        </div>
                    </li>
                    <li class="share">
                        <div class="frame">
                            <a class="share-ico" href="#">share</a>
                            <div class="share-box">
                                <form class="share-form" action="#">
                                    <fieldset>
                                        <span class="text-shadow">&nbsp;</span>
                                        <input type="text" class="text" value="http://<?=$_SERVER["HTTP_HOST"]?><?=$arItem["DETAIL_PAGE_URL"]?>" />
                                        <ul class="soc">
                                            <li><a href="#" onclick="Share.vk('http://<?=$_SERVER["HTTP_HOST"]?><?=$arItem["DETAIL_PAGE_URL"]?>', '<?=$arItem["NAME"]?>', 'http://<?=$_SERVER["HTTP_HOST"]?><?=$arItem["PREVIEW_PICTURE"]["SRC"]?>', '<?=substr(strip_tags($arItem["PREVIEW_TEXT"]), 0, 120)?>...')" class="vkontakte">vkontakte</a></li>
                                            <li><a href="#" onclick="Share.fb('http://<?=$_SERVER["HTTP_HOST"]?><?=$arItem["DETAIL_PAGE_URL"]?>', '<?=$arItem["NAME"]?>', 'http://<?=$_SERVER["HTTP_HOST"]?><?=$arItem["PREVIEW_PICTURE"]["SRC"]?>', '<?=substr(strip_tags($arItem["PREVIEW_TEXT"]), 0, 120)?>...')" class="facebook">facebook</a></li>
                                            <li><a href="#" onclick="Share.twitter('http://<?=$_SERVER["HTTP_HOST"]?><?=$arItem["DETAIL_PAGE_URL"]?>', '<?=$arItem["NAME"]?>', 'http://<?=$_SERVER["HTTP_HOST"]?><?=$arItem["PREVIEW_PICTURE"]["SRC"]?>', '<?=substr(strip_tags($arItem["PREVIEW_TEXT"]), 0, 120)?>...')" class="twitter">twitter</a></li>
                                            <li><a href="#" onclick="Share.gplus('http://<?=$_SERVER["HTTP_HOST"]?><?=$arItem["DETAIL_PAGE_URL"]?>')" class="google">google</a></li>
                                        </ul>
                                        <a href="#" class="btn-close">close</a>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="text">
                <h2><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></h2>
                <p><?=$arItem['PREVIEW_TEXT']?></p>
                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="link-more"><?=GetMessage('')?></a>
            </div>
        </div>
        <?endforeach;?>   
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"] == "Y"):?>
    <?=$arResult["NAV_STRING"]?>
    <?endif?>