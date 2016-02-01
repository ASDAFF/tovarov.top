<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    if (!empty($arResult["ORDER"]))
    {
    ?>
    <div class="success-order">
        <div class="success-message">
            <div class="holder">
                <span class="corner">&nbsp;</span>
                <div class="title">
                    <h2><?=GetMessage("SOA_TEMPL_ORDER_COMPLETE")?></h2>
                    <h3><?= GetMessage("SOA_TEMPL_ORDER_SUC", Array("#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"], "#ORDER_ID#" => $arResult["ORDER"]["ID"]))?></h3>
                </div>
                <p><?= GetMessage("SOA_TEMPL_ORDER_SUC1", Array("#LINK#" => $arParams["PATH_TO_PERSONAL"])) ?></p>

                <?
                    if (!empty($arResult["PAY_SYSTEM"]))
                    {
                    ?>
                    <div class="wallet">
                        <div class="img">
                            <div class="a-middle">
                                <?=CFile::ShowImage($arResult["PAY_SYSTEM"]["LOGOTIP"], 37, 42, "border=0", "", false);?>
                            </div>
                        </div>

                        <div>
                            <h4><?=GetMessage("SOA_TEMPL_PAY")?>: <?= $arResult["PAY_SYSTEM"]["NAME"] ?></h4>
                            <p>
                                <?
                                    if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
                                    {
                                        if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
                                        {
                                        ?>
                                        <script language="JavaScript">
                                            window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>');
                                        </script>
                                        <?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))))?>
                                        <?
                                            if (CSalePdf::isPdfAvailable() && CSalePaySystemsHelper::isPSActionAffordPdf($arResult['PAY_SYSTEM']['ACTION_FILE']))
                                            {
                                            ?><br />
                                            <?= GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y")) ?>
                                            <?
                                            }
                                        }
                                        else
                                        {
                                            if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
                                            {
                                                include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
                                            }
                                        }
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
                    <?
                    }
                ?>
            </div>
        </div>
    </div>
    <?
    }
    else
    {
    ?>
    <b><?=GetMessage("SOA_TEMPL_ERROR_ORDER")?></b><br /><br />

    <table class="sale_order_full_table">
        <tr>
            <td>
                <?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
                <?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
            </td>
        </tr>
    </table>
    <?
    }
?>
