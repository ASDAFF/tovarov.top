<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(false);

/*if (!empty($arResult["ERRORS"])):?>
	<?ShowError(implode("<br />", $arResult["ERRORS"]))?>
<?endif;*/
if (strlen($arResult["MESSAGE"]) > 0):?>
	<script type="text/javascript">
    $(document).ready(function(){
       
      $('.ajax-tmp').bPopup().close();
    //  $('.b-modal __b-popup1__').click(); 
     jQuery('#resume-success').bPopup({
                                    closeClass: 'btn-close',
                                    modalColor: '#fff'
                            });
    })
    </script>
<?endif?>

<form name="iblock_add" class="vacancy-form" action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
<fieldset>
<div class="buttons">
	<?=bitrix_sessid_post()?>
	<?if ($arParams["MAX_FILE_SIZE"] > 0):?><input type="hidden" name="MAX_FILE_SIZE" value="<?=$arParams["MAX_FILE_SIZE"]?>" /><?endif?>
	
		<?if (is_array($arResult["PROPERTY_LIST"]) && !empty($arResult["PROPERTY_LIST"])):?>
	
			<?foreach ($arResult["PROPERTY_LIST"] as $propertyID):?>
				
		
					
						<?
						if (intval($propertyID) > 0)
						{
							if (
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "T"
								&&
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] == "1"
							)
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "S";
							elseif (
								(
									$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "S"
									||
									$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "N"
								)
								&&
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] > "1"
							)
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "T";
						}
						elseif (($propertyID == "TAGS") && CModule::IncludeModule('search'))
							$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "TAGS";

						if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y")
						{
							$inputNum = ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0) ? count($arResult["ELEMENT_PROPERTIES"][$propertyID]) : 0;
							$inputNum += $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE_CNT"];
						}
						else
						{
							$inputNum = 1;
						}

						if($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"])
							$INPUT_TYPE = "USER_TYPE";
						else
							$INPUT_TYPE = $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"];
						switch ($INPUT_TYPE):
							case "USER_TYPE":
								for ($i = 0; $i<$inputNum; $i++)
								{
									if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["~VALUE"] : $arResult["ELEMENT"][$propertyID];
										$description = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["DESCRIPTION"] : "";
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
										$description = "";
									}
									else
									{
										$value = "";
										$description = "";
									}
									echo call_user_func_array($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"],
										array(
											$arResult["PROPERTY_LIST_FULL"][$propertyID],
											array(
												"VALUE" => $value,
												"DESCRIPTION" => $description,
											),
											array(
												"VALUE" => "PROPERTY[".$propertyID."][".$i."][VALUE]",
												"DESCRIPTION" => "PROPERTY[".$propertyID."][".$i."][DESCRIPTION]",
												"FORM_NAME"=>"iblock_add",
											),
										));
								?><br /><?
								}
							break;
							
						

							case "S":
							case "N":
								for ($i = 0; $i<$inputNum; $i++)
								{
									if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];

									}
									else
									{
										$value = "";
									}
								?>
								<input type="hidden" <?if($propertyID==$arResult['VACANCY_ID']):?>id='vac_id'<?elseif($propertyID=='NAME'):?>id="vac_name"<?endif;?> name="PROPERTY[<?=$propertyID?>][<?=$i?>]" size="25" value="<?=1090?>" />
                            <?
								}
							break;

							case "F":
								for ($i = 0; $i<$inputNum; $i++)
								{
									$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									?>
                                    <div class="fileinputs">
                                    <input type="hidden" name="PROPERTY[<?=$propertyID?>][<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>]" value="<?=$value?>" />
                                    <input class="file" type="file" size="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]?>"  name="PROPERTY_FILE_<?=$propertyID?>_<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>" />
                                    <div class="fakefile">
                                        <em href="#" class="button gray"><span><?=GetMessage('ADD_RESUME')?></span></em>
                                    </div>
                                </div>
						
									<?

									if (!empty($value) && is_array($arResult["ELEMENT_FILES"][$value]))
									{
										?>
					<input type="checkbox" name="DELETE_FILE[<?=$propertyID?>][<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>]" id="file_delete_<?=$propertyID?>_<?=$i?>" value="Y" /><label for="file_delete_<?=$propertyID?>_<?=$i?>"><?=GetMessage("IBLOCK_FORM_FILE_DELETE")?></label><br />
										<?

										if ($arResult["ELEMENT_FILES"][$value]["IS_IMAGE"])
										{
											?>
					<img src="<?=$arResult["ELEMENT_FILES"][$value]["SRC"]?>" height="<?=$arResult["ELEMENT_FILES"][$value]["HEIGHT"]?>" width="<?=$arResult["ELEMENT_FILES"][$value]["WIDTH"]?>" border="0" /><br />
											<?
										}
										else
										{
											?>
					<?=GetMessage("IBLOCK_FORM_FILE_NAME")?>: <?=$arResult["ELEMENT_FILES"][$value]["ORIGINAL_NAME"]?><br />
					<?=GetMessage("IBLOCK_FORM_FILE_SIZE")?>: <?=$arResult["ELEMENT_FILES"][$value]["FILE_SIZE"]?> b<br />
					[<a href="<?=$arResult["ELEMENT_FILES"][$value]["SRC"]?>"><?=GetMessage("IBLOCK_FORM_FILE_DOWNLOAD")?></a>]<br />
											<?
										}
									}
								}

							break;
							
						endswitch;?>
					
			<?endforeach;?>
			<?/*if($arParams["USE_CAPTCHA"] == "Y" && $arParams["ID"] <= 0):?>
				<tr>
					<td><?=GetMessage("IBLOCK_FORM_CAPTCHA_TITLE")?></td>
					<td>
						<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
						<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
					</td>
				</tr>
				<tr>
					<td><?=GetMessage("IBLOCK_FORM_CAPTCHA_PROMPT")?><span class="starrequired">*</span>:</td>
					<td><input type="text" name="captcha_word" maxlength="50" value=""></td>
				</tr>
			<?endif*/?>
		
		<?endif?>
		            <button type="submit"  class="button"><span><?=GetMessage("IBLOCK_FORM_SUBMIT")?></span></button>
                    
					<input type="hidden" name="iblock_submit" value="<?=GetMessage("IBLOCK_FORM_SUBMIT")?>" />
					<?if (strlen($arParams["LIST_URL"]) > 0):?>
						<input type="submit" name="iblock_apply" value="<?=GetMessage("IBLOCK_FORM_APPLY")?>" />
						<input
							type="button"
							name="iblock_cancel"
							value="<? echo GetMessage('IBLOCK_FORM_CANCEL'); ?>"
							onclick="location.href='<? echo CUtil::JSEscape($arParams["LIST_URL"])?>';"
						>
					<?endif?>
                    </div>
			</fieldset>
</form>
<div class="popup success-popup" id="resume-success">
    <img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/img-face.png">
    <h2><?=GetMessage('THANK')?></h2>
    <h3><?=GetMessage('OK_TEXT')?></h3>
    <a href="#" class="btn-close">close</a>
  </div>
</div>