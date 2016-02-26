<?
    if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
    /**
    * Bitrix vars
    *
    * @var array $arParams
    * @var array $arResult
    * @var CBitrixComponentTemplate $this
    * @global CMain $APPLICATION
    * @global CUser $USER
    *
    * $f["HINT"] - it's @placeholder or @tooltip property of each field, if you're @need to @change it: @make it's in @result_modifier.php of your @template
    */          
?>
<?$this->setFrameMode(true);?>

<div class="add-review">
    <h2><?=GetMessage('ADD_REVIEW')?></h2>

    <?if(!empty($arResult["ERROR_MESSAGE"]))
        { ?>
        <div class="alert alert2">
            <a class="close" href="#">close</a>
            <div class="image-box">
                <img src="<?=$templateFolder?>/ico/ico02.png" alt="#" width="53" height="46" />
            </div>
            <div class="text-box">
                <p><? foreach($arResult["ERROR_MESSAGE"] as $v)
                        echo $v.'<br/>';   ?></p>
            </div>
        </div>



        <?}?>
    <?if (strlen($arResult["OK_MESSAGE"]) > 0):?>
        <script type="text/javascript">
            $(document).ready(function(){
                    $('#review-success').bPopup({
                            closeClass: 'btn-close',
                            modalColor: '#fff'
                    });
            })
        </script>
        <?endif;?>

    <form action="<?=$APPLICATION->GetCurPage(false)?>" method="POST" class="review-form" enctype="multipart/form-data">
        <fieldset>

            <?=bitrix_sessid_post();?>
            <div class="row">
                <div class="left">
                    <?foreach($arResult["FIELDS"] as $f):?>
                        <?switch($f["CODE"]){
                                case 'NAME':?>
                                <input type="text" name="<?=$f["CODE"]?>" class="text" placeholder="<?=$f["HINT"]?$f["HINT"]:$f["NAME"]?>" value="<?=$_REQUEST[$f["CODE"]]?>">
                                <?break;
                                case 'AUTHOR_EMAIL':?>
                                <input type="email" required name="<?=$f["CODE"]?>" class="text" placeholder="<?=$f["HINT"]?$f["HINT"]:$f["NAME"]?>" value="<?=$_REQUEST[$f["CODE"]]?>">
                                <?break;
                                case 'RATING':?>
                                <?if($arParams["USE_CAPTCHA"] == "Y"):?>
                                    <div class="captcha-cell">
                                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="164" height="37" alt="CAPTCHA">
                                        <input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
                                        <input type="text" class="text" name="captcha_word" size="30" maxlength="50" value="" placeholder="<?=GetMessage('CAPCHA_TEXT')?>">
                                    </div>
                                    <?endif;?>
                                <div class="mark-box">
                                    <strong><?=GetMessage('ADD_RATE')?> </strong>
                                    <div class="rating-holder">
                                        <table align="center" class="bx_item_detail_rating">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="bx_item_rating">
                                                            <div class="bx_stars_container">
                                                                <div id="rating_form_vote_stars" class="bx_stars_bg"></div>
                                                                <div id="rating_form_vote_progr" class="bx_stars_progres" style="width: 100%;"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="rating_form_vote_inputId" name="<?=$f["CODE"]?>" value="<?=$_REQUEST[$f["CODE"]]?:5?>" />
                                    </div>
                                </div>
                                <?
                                    break;
                                default: break;
                                ?>
                                <?}?>
                        <?endforeach;?>
                </div>
                <div class="right">
                    <?foreach($arResult["FIELDS"] as $f):
                            if($f["CODE"] == "MESSAGE")continue;
                        ?>
                        <?switch($f["INPUT_TYPE"]){
                                case 'T':case 'H':?>
                                <textarea name="<?=$f["CODE"]?>" placeholder="<?=$f["HINT"]?>"><?=$_REQUEST[$f["CODE"]]?></textarea>
                                <?
                                    break;
                                default: break;
                                ?>
                                <?}?>
                        <?endforeach;?>
                </div>
            </div>
            <div class="row">
                <?foreach($arResult["FIELDS"] as $f):
                        if($f["CODE"] != "MESSAGE")continue;
                    ?>
                    <?switch($f["INPUT_TYPE"]){
                            case 'T':case 'H':?>
                            <div class="new-comment">
                                <textarea name="<?=$f["CODE"]?>" placeholder="<?=$f["HINT"]?>"><?=$_REQUEST[$f["CODE"]]?></textarea>
                            </div>
                            <?
                                break;
                            default: break;
                            ?>
                            <?}?>
                    <?endforeach;?>
            </div>
            <div class="avatar-block">
                <div class="row">
                    <p><?=GetMessage('ADD_AVA')?></p>
                    <div class="type-file">
                        <input type="file" name="AVATAR">
                        <em><span><?=GetMessage('ADD_REV_REV')?></span> ?</em>
                    </div>
                    <ul class="avatars">
                        <?
                            $dir = $templateFolder."/images/";
                            $scan = scandir($_SERVER["DOCUMENT_ROOT"].$dir);
                            for ($i=0; $i<count($scan); $i++) {
                                if($scan[$i] == '.' || $scan[$i] == '..'){
                                    unset($scan[$i]);
                                }
                            }

                            foreach($scan as $photo){
                            ?>
                            <li>
                                <a href="<?=$dir.$photo?>">
                                    <img src="<?=$dir.$photo?>" />
                                </a>
                            </li>
                            <?
                            }
                        ?>
                    </ul>
                    <input type="hidden" name="SERVER_AVATAR" value="" />
                </div>
            </div>
            <input type="hidden" name="ELEMENT_ID" value="<?=$arParams["ELEMENT_ID"]?>" />
            <input type="hidden" name="REPLY_ID" value="" />
            <input type="submit" class="button" name="submit" value="<?=GetMessage('ADD_REV_REVBUT')?>">
        </fieldset>
    </form>
</div>
<div class="popup success-popup" id="review-success">
    <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/img-face.png" />
    <h2><?=GetMessage('THANK')?></h2>
    <h3><?=GetMessage('SUCCES')?></h3>
    <p><?=GetMessage('RECALL_1')?> <a href="#recall" class='popup-open'><?=GetMessage('RECALL_2')?></a></p>
    <a href="#" class="btn-close">close</a>
</div>

<?
    $strObName = "rating_form_vote";
    $arJSParams = array(
        "progressId" => $strObName."_progr",
        "ratingId" => $strObName."_rating",
        "starsId" => $strObName."_stars",
        "inputId" => "rating_form_vote_inputId",
        "voteId" => 0,
        "voteSum" => 0,
        "voteCount" => 0,
        "voteRating" => 0,
        "voteValue" => 0
    );

    $templateData = array(
        'JS_OBJ' => $strObName,
        'ELEMENT_ID' => $arParams["ELEMENT_ID"]
    );
?>

<script type="text/javascript">
    BX.ready(function(){
            window.<?=$strObName;?> = new JCReviewVoteStars(<?=CUtil::PhpToJSObject($arJSParams, false, true);?>);
            window.<?=$strObName?>.setValue("100");
    });
</script>
<script type="text/javascript">
    BX.ready(
        BX.defer(function(){
                console.log(<? echo $templateData['JS_OBJ']; ?>, window.<? echo $templateData['JS_OBJ']; ?>);
                if (!!window.<? echo $templateData['JS_OBJ']; ?>)
                {
                    window.<? echo $templateData['JS_OBJ']; ?>.bindEvents();
                }
        })
    );
</script>
<script>
    $(function(){
            $('.avatars a').click(function(e){
                    e.preventDefault();
                    $('.avatars li').each(function(k, v){
                            $(v).removeClass('current');
                    });
                    $('input[name="SERVER_AVATAR"]').val($(this).attr('href'));
                    $(this).parent().addClass('current');
            });
            $('.avatars a:first').click();
    });
</script>