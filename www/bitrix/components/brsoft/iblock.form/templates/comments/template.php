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
<div class="brsoft-review-container">
    <form action="<?=$APPLICATION->GetCurPage(false)?>" method="POST" class="review-form" enctype="multipart/form-data">
		<h2><?=GetMessage("BRSOFT_FC_ADD_REVIEW")?></h2>
        <fieldset>
			<?if(strlen($arResult["OK_MESSAGE"]) > 0) echo"<p>".$arResult["OK_MESSAGE"]."</p>";?>
            <?=bitrix_sessid_post();?>
            <div class="row">
                <div class="left">
                    <?foreach($arResult["FIELDS"] as $f):?>
                        <?switch($f["CODE"]){
                            case 'NAME':
                            case 'AUTHOR_EMAIL':?>
                                 <input type="text" name="<?=$f["CODE"]?>" class="text <?if(array_key_exists ($f["CODE"],$arResult["ERROR_MESSAGE"])):?>error<?endif?>" placeholder="<?=$f["HINT"]?>" value="<?=$_REQUEST[$f["CODE"]]?>">
                            <?break;
                            default: break;
                        }?>
                    <?endforeach;?>
					<?if($arParams["USE_CAPTCHA"] == "Y"):?>
						<div class="captcha-cell">
							<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="164" height="37" alt="CAPTCHA">
							<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
							<input type="text" class="text" name="captcha_word" size="30" maxlength="50" value="">
						</div>
					<?endif;?>

					<div class="avatar-block">
						<div class="row">
							<p><?=GetMessage("BRSOFT_FC_ADD_AVATAR")?></p>
							<div class="type-file">
								<input type="file" name="AVATAR">
								<em><?=GetMessage("BRSOFT_FC_ADD_AVATAR_HELP")?></em>
							</div>
						</div>
					</div>
					<input type="hidden" name="ELEMENT_ID" value="<?=$arParams["ELEMENT_ID"]?>" />
					<input type="submit" class="button" name="submit" value="<?=GetMessage("BRSOFT_FC_SEND")?>">
                </div>
                <div class="right">
					<?foreach($arResult["FIELDS"] as $f):
						if($f["CODE"] != "MESSAGE")continue;
						?>
						<?switch($f["INPUT_TYPE"]){
						case 'T':case 'H':?>
							<textarea name="<?=$f["CODE"]?>" class="<?if(array_key_exists ($f["CODE"],$arResult["ERROR_MESSAGE"])):?>error<?endif?>" placeholder="<?=$f["HINT"]?>"><?=$_REQUEST[$f["CODE"]]?></textarea>
							<?
							break;
							default: break;
						}?>
					<?endforeach;?>
                </div>
            </div>
        </fieldset>
    </form>
</div>