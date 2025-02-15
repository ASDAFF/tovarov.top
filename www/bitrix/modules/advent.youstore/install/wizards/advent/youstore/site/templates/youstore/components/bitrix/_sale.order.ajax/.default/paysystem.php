<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

        <script type="text/javascript">
            function changePaySystem(param)
            {
                if (BX("account_only") && BX("account_only").value == 'Y') // PAY_CURRENT_ACCOUNT checkbox should act as radio
                {
                    if (param == 'account')
                    {
                        if (BX("PAY_CURRENT_ACCOUNT"))
                        {
                            BX("PAY_CURRENT_ACCOUNT").checked = true;
                            BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
                            BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');

                            // deselect all other
                            var el = document.getElementsByName("PAY_SYSTEM_ID");
                            for(var i=0; i<el.length; i++)
                                el[i].checked = false;
                        }
                    }
                    else
                    {
                        BX("PAY_CURRENT_ACCOUNT").checked = false;
                        BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
                        BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
                    }
                }
                else if (BX("account_only") && BX("account_only").value == 'N')
                {
                    if (param == 'account')
                    {
                        if (BX("PAY_CURRENT_ACCOUNT"))
                        {
                            BX("PAY_CURRENT_ACCOUNT").checked = !BX("PAY_CURRENT_ACCOUNT").checked;

                            if (BX("PAY_CURRENT_ACCOUNT").checked)
                            {
                                BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
                                BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
                            }
                            else
                            {
                                BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
                                BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
                            }
                        }
                    }
                }

                submitForm();
            }
        </script>
<div class="pay-method">
	<?
		if ($arResult["PAY_FROM_ACCOUNT"] == "Y")
		{
			$accountOnly = ($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y") ? "Y" : "N";
			?>
			<input type="hidden" id="account_only" value="<?=$accountOnly?>" />
			<a href="javascript:void(0)" class="item <?if($arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y") echo "active"?>" onclick="changePaySystem('account');" >
                <input type="hidden" name="PAY_CURRENT_ACCOUNT" value="N">
                <strong>
                    <img alt="image" src="<?=$templateFolder?>/images/logo-default-ps.gif" />
                </strong>
                <em class="tooltip">
                    <span>&nbsp;</span>
                    <?=GetMessage("SOA_TEMPL_PAY_ACCOUNT")?>
                    <b><?=$arResult["CURRENT_BUDGET_FORMATED"]?></b>
                </em>

                <?/*<label for="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT_LABEL"  class="<?if($arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y") echo "selected"?>">
                    <input type="checkbox" class="hidden" name="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT" value="Y"<?if($arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y") echo " checked=\"checked\"";?>>
                    <div class="bx_logotype">
                        <span style="background-image:url(<?=$templateFolder?>/images/logo-default-ps.gif);"></span>
                    </div>
                    <div class="bx_description">
                        <strong><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT")?></strong>
                        <p>
                            <div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT1")." <b>".$arResult["CURRENT_BUDGET_FORMATED"]?></b></div>
                            <? if ($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y"):?>
                                <div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT3")?></div>
                            <? else:?>
                                <div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT2")?></div>
                            <? endif;?>
                        </p>
                    </div>
                </label>*/?>
			</a>
			<?
		}

		uasort($arResult["PAY_SYSTEM"], "cmpBySort"); // resort arrays according to SORT value

		foreach($arResult["PAY_SYSTEM"] as $arPaySystem)
		{
			if (strlen(trim(str_replace("<br />", "", $arPaySystem["DESCRIPTION"]))) > 0 || intval($arPaySystem["PRICE"]) > 0)
			{
				if (count($arResult["PAY_SYSTEM"]) == 1)
				{
					?>

					<a class="javascript:void(0)" class="item <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo "active";?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
                        <input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
                        <input type="radio"
                            id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
                            name="PAY_SYSTEM_ID"
                            class="hidden"
                            value="<?=$arPaySystem["ID"]?>"
                            <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
                            onclick="changePaySystem();"
                            />
                        <strong>
                            <?
                            if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
                                $imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
                            else:
                                $imgUrl = $templateFolder."/images/logo-default-ps.gif";
                            endif;
                            ?>
                            <img src="<?=$imgUrl?>" />
                        </strong>
                        <?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
                            <em class="tooltip">
                                <span>&nbsp;</span>
                                <?=$arPaySystem["PSA_NAME"];?>
                                <p>
                                    <?
                                    if (intval($arPaySystem["PRICE"]) > 0)
                                        echo str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), GetMessage("SOA_TEMPL_PAYSYSTEM_PRICE"));
                                    else
                                        echo $arPaySystem["DESCRIPTION"];
                                    ?>
                                </p>
                            </em>
                        <?endif;?>

                        <?/*
                        <label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
                            <?
                            if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
                                $imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
                            else:
                                $imgUrl = $templateFolder."/images/logo-default-ps.gif";
                            endif;
                            ?>
                            <div class="bx_logotype">
                                <span style="background-image:url(<?=$imgUrl?>);"></span>
                            </div>
                            <div class="bx_description">
                                <?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
                                    <strong><?=$arPaySystem["PSA_NAME"];?></strong>
                                <?endif;?>
                                <p>
                                    <?
                                    if (intval($arPaySystem["PRICE"]) > 0)
                                        echo str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), GetMessage("SOA_TEMPL_PAYSYSTEM_PRICE"));
                                    else
                                        echo $arPaySystem["DESCRIPTION"];
                                    ?>
                                </p>
                            </div>
                        </label>
                        */?>
					</a>
					<?
				}
				else // more than one
				{
                    ?>
                        <a class="item <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo "active";?>" href="javascript:void(0)" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
                            <input type="radio"
                                id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
                                name="PAY_SYSTEM_ID"
                                class="hidden"
                                value="<?=$arPaySystem["ID"]?>"
                                <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
                                onclick="changePaySystem();" />

                            <strong>
                                <?
                                if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
                                    $imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
                                else:
                                    $imgUrl = $templateFolder."/images/logo-default-ps.gif";
                                endif;
                                ?>
                                <img src="<?=$imgUrl?>" />
                            </strong>
                            <?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
                                <em class="tooltip">
                                    <span>&nbsp;</span>
                                    <?=$arPaySystem["PSA_NAME"];?>
                                    <p>
                                        <?
                                        if (intval($arPaySystem["PRICE"]) > 0)
                                            echo str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), GetMessage("SOA_TEMPL_PAYSYSTEM_PRICE"));
                                        else
                                            echo $arPaySystem["DESCRIPTION"];
                                        ?>
                                    </p>
                                </em>
                            <?endif;?>
                            <?/*
                            <label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" >
                                <?
                                if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
                                    $imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
                                else:
                                    $imgUrl = $templateFolder."/images/logo-default-ps.gif";
                                endif;
                                ?>
                                <div class="bx_logotype">
                                    <span style='background-image:url(<?=$imgUrl?>);'></span>
                                </div>
                                <div class="bx_description">
                                    <?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
                                        <strong><?=$arPaySystem["PSA_NAME"];?></strong>
                                    <?endif;?>
                                    <p>
                                        <?
                                        if (intval($arPaySystem["PRICE"]) > 0)
                                            echo str_replace("#PAYSYSTEM_PRICE#", SaleFormatCurrency(roundEx($arPaySystem["PRICE"], SALE_VALUE_PRECISION), $arResult["BASE_LANG_CURRENCY"]), GetMessage("SOA_TEMPL_PAYSYSTEM_PRICE"));
                                        else
                                            echo $arPaySystem["DESCRIPTION"];
                                        ?>
                                    </p>
                                </div>
                            </label>
                            */?>
                        </a>
                    <?
				}
			}

			if (strlen(trim(str_replace("<br />", "", $arPaySystem["DESCRIPTION"]))) == 0 && intval($arPaySystem["PRICE"]) == 0)
			{
				if (count($arResult["PAY_SYSTEM"]) == 1)
				{
					?>
                        <a class="item <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo "active";?>" href="javascript:void(0)" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
                            <input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
                            <input type="radio"
                                id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
                                name="PAY_SYSTEM_ID"
                                class="hidden"
                                value="<?=$arPaySystem["ID"]?>"
                                <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
                                onclick="changePaySystem();"
                                />
                            <strong>
                                <?
                                if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
                                    $imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
                                else:
                                    $imgUrl = $templateFolder."/images/logo-default-ps.gif";
                                endif;
                                ?>
                                <img src="<?=$imgUrl?>" />
                            </strong>
                            <?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
                                <em class="tooltip">
                                    <span>&nbsp;</span>
                                    <?=$arPaySystem["PSA_NAME"];?>
                                </em>
                            <?endif;?>

                            <?/*
                            <label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" >
                            <?
                                if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
                                    $imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
                                else:
                                    $imgUrl = $templateFolder."/images/logo-default-ps.gif";
                                endif;
                            ?>
                            <div class="bx_logotype">
                                <span style='background-image:url(<?=$imgUrl?>);'></span>
                            </div>
                            <?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
                                <div class="bx_description">
                                    <div class="clear"></div>
                                    <strong><?=$arPaySystem["PSA_NAME"];?></strong>
                                </div>
                            <?endif;?>
                            */?>
                        </a>
				    <?
				}
				else // more than one
				{
				?>
					<a class="item <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo "active";?>" href="javascript:void(0)" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
                        <input type="radio"
                            id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>"
                            name="PAY_SYSTEM_ID"
                            class="hidden"
                            value="<?=$arPaySystem["ID"]?>"
                            <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>
                            onclick="changePaySystem();" />

                        <strong>
                            <?
                            if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
                                $imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
                            else:
                                $imgUrl = $templateFolder."/images/logo-default-ps.gif";
                            endif;
                            ?>
                            <img src="<?=$imgUrl?>" />
                        </strong>
                        <?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
                            <em class="tooltip">
                                <span>&nbsp;</span>
                                <?=$arPaySystem["PSA_NAME"];?>
                            </em>
                        <?endif;?>
                        <?/*
                        <label for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
                            <?
                            if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
                                $imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
                            else:
                                $imgUrl = $templateFolder."/images/logo-default-ps.gif";
                            endif;
                            ?>
                            <div class="bx_logotype">
                                <span style='background-image:url(<?=$imgUrl?>);'></span>
                            </div>
                            <?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
                                <div class="bx_description">
                                    <div class="clear"></div>
                                    <strong>
                                        <?if ($arParams["SHOW_PAYMENT_SERVICES_NAMES"] != "N"):?>
                                            <?=$arPaySystem["PSA_NAME"];?>
                                        <?else:?>
                                            <?="&nbsp;"?>
                                        <?endif;?>
                                    </strong>
                                </div>
                            <?endif;?>
                        </label>
                        */?>
					</a>
				<?
				}
			}
		}
	?>
</div>