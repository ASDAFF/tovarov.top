<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

    list($day, $month) = explode(" ", $arResult["DISPLAY_ACTIVE_FROM"]);
    $month = strtoupper($month);?>

<div class="box details wide">
    <div class="news-images image">
        <ul class="img-tools">
            <?if(!empty($day)):?>
                <li class="date">
                    <div class="frame">
                        <a href="#">
                            <strong><?=$day?></strong>
                            <?=$month?>
                        </a>
                    </div>
                </li>
                <?endif;?>
            <li class="views">
                <div class="frame">
                    <a href="#"><?=$arResult['SHOW_COUNTER']?></a>
                </div>
            </li>
            <li class="share">
                <div class="frame">
                    <a class="share-ico" href="#">share</a>
                    <div class="share-box">
                        <form class="share-form" action="#">
                            <fieldset>
                                <span class="text-shadow">&nbsp;</span>
                                <input type="text" class="text" value="http://<?=$_SERVER["HTTP_HOST"]?><?=$arResult['DETAIL_PAGE_URL']?>" />
                                <ul class="soc">
                                    <li><a href="#" onclick="Share.vk('http://<?=$_SERVER["HTTP_HOST"]?><?=$arResult["DETAIL_PAGE_URL"]?>', '<?=$arResult["NAME"]?>', 'http://<?=$_SERVER["HTTP_HOST"]?><?=$arResult["PREVIEW_PICTURE"]["SRC"]?>', '<?=substr(strip_tags($arResult["PREVIEW_TEXT"]), 0, 120)?>...')" class="vkontakte">vkontakte</a></li>
                                    <li><a href="#" onclick="Share.fb('http://<?=$_SERVER["HTTP_HOST"]?><?=$arResult["DETAIL_PAGE_URL"]?>', '<?=$arResult["NAME"]?>', 'http://<?=$_SERVER["HTTP_HOST"]?><?=$arResult["PREVIEW_PICTURE"]["SRC"]?>', '<?=substr(strip_tags($arResult["PREVIEW_TEXT"]), 0, 120)?>...')" class="facebook">facebook</a></li>
                                    <li><a href="#" onclick="Share.twitter('http://<?=$_SERVER["HTTP_HOST"]?><?=$arResult["DETAIL_PAGE_URL"]?>', '<?=$arResult["NAME"]?>', 'http://<?=$_SERVER["HTTP_HOST"]?><?=$arResult["PREVIEW_PICTURE"]["SRC"]?>', '<?=substr(strip_tags($arResult["PREVIEW_TEXT"]), 0, 120)?>...')" class="twitter">twitter</a></li>
                                    <li><a href="#" onclick="Share.gplus('http://<?=$_SERVER["HTTP_HOST"]?><?=$arResult["DETAIL_PAGE_URL"]?>')" class="google">google</a></li>
                                </ul>
                                <a href="#" class="btn-close">close</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
       <?if($arResult['PHOTOS']):?> 
        <ul class="images">
        <?if($arResult['PHOTOS'])foreach($arResult['PHOTOS'] as $photo):?>
            <li class="item"><a href="#"><img alt="image" src="<?=$photo['SRC']?>" /></a></li>
        <?endforeach;?>
        </ul>
        <div class="navigate">
            <ul>
            <?foreach($arResult['PHOTOS'] as $key=>$photo):?>
                <li><a href="#"><?=$key+1?></a></li>
            <?endforeach;?>
               
            </ul>
        </div>
<?endif?>
    </div>
    <div class="text">
        <h1><?=$arResult['NAME']?></h1>

        <?=$arResult['DETAIL_TEXT']?>

    </div>
</div>