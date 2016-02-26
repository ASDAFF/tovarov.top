<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//test_dump($arResult );
    if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y")
    {
        if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
        {
            if(strlen($arResult["REDIRECT_URL"]) > 0)
            {
                $APPLICATION->RestartBuffer();
            ?>
            <script type="text/javascript">
                window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
            </script>
            <?
                die();
            }

        }
    }

    $APPLICATION->SetAdditionalCSS($templateFolder."/style_cart.css");
    $APPLICATION->SetAdditionalCSS($templateFolder."/style.css");

    CJSCore::Init(array('fx', 'popup', 'window', 'ajax'));
?>

<a name="order_form"></a>

<div id="order_form_div" class="order-checkout">
    <NOSCRIPT>
        <div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
    </NOSCRIPT>

    <?
        if (!function_exists("getColumnName"))
        {
            function getColumnName($arHeader)
            {
                return (strlen($arHeader["name"]) > 0) ? $arHeader["name"] : GetMessage("SALE_".$arHeader["id"]);
            }
        }

        if (!function_exists("cmpBySort"))
        {
            function cmpBySort($array1, $array2)
            {
                if (!isset($array1["SORT"]) || !isset($array2["SORT"]))
                    return -1;

                if ($array1["SORT"] > $array2["SORT"])
                    return 1;

                if ($array1["SORT"] < $array2["SORT"])
                    return -1;

                if ($array1["SORT"] == $array2["SORT"])
                    return 0;
            }
        }
    ?>

    <div class="bx_order_make">
        <?
            if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
            {
                if(!empty($arResult["ERROR"]))
                {          
                    foreach($arResult["ERROR"] as $v)
                        echo ShowError($v);
                }
                elseif(!empty($arResult["OK_MESSAGE"]))
                {
                    foreach($arResult["OK_MESSAGE"] as $v)
                        echo ShowNote($v);
                }

                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
            }
            else
            {
                if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
                {
                    if(strlen($arResult["REDIRECT_URL"]) == 0)
                    {
                        include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
                    }
                }
                else
                {
                ?>
                <script type="text/javascript">
                    function applyCustomForm(){
                        $('.order-container input, .order-container select').styler();
                        $('.req').each(function(index, elem){
                                if ($(elem).val().trim() == ''){
                                    $(elem).css({'border-color':'red'});
                                    bOk = false;
                                }else{
                                    $(elem).css({'border-color':''});
                                }
                        })
                    }



                    function submitForm(val)
                    {
                        if(val != 'Y')
                            BX('confirmorder').value = 'N';

                        var orderForm = BX('ORDER_FORM');
                        BX.ajax.submitComponentForm(orderForm, 'order_form_content', true);

                        BX.addCustomEvent('onAjaxSuccess', function() {

                                applyCustomForm(orderForm);
                        });

                        BX.submit(orderForm);
                        BX.closeWait();

                        return true;
                    }

                    function SetContact(profileId)
                    {
                        BX("profile_change").value = "Y";
                        submitForm();
                    }
                </script>
                <?if($_POST["is_ajax_post"] != "Y")
                    {
                    ?>
                    <form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
                        <fieldset>
                            <?=bitrix_sessid_post()?>
                            <div id="order_form_content">
                                <?
                                }
                                else
                                {
                                    $APPLICATION->RestartBuffer();
                                }

                                if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
                                {     
                                    foreach($arResult["ERROR"] as $v)
                                    {
                                        if(strpos($v,GetMessage('SOA_TEMPL_ERROR_REG'))!==false) {
                                        ?>
                                        <div class="alert alert2">
                                            <a class="close" href="#">close</a>
                                            <div class="image-box">
                                                <img src="<?=SITE_TEMPLATE_PATH?>/images/ico02.png" alt="#" width="53" height="46">
                                            </div>
                                            <div class="text-box">
                                                <p><?=$v?></p>
                                            </div>
                                        </div>
                                        <?
                                        } 
                                    }

                                ?>
                                <script type="text/javascript">      
                                    top.BX.scrollToNode(top.BX('ORDER_FORM'));

                                </script>
                                <?
                                }
                                global $currentOrderStep;
                                $currentOrderStep = 0;
                            ?>

                            <?
                                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");
                            ?>

                            <?
                                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");
                            ?>


                            <?
                                if ($arParams["DELIVERY_TO_PAYSYSTEM"] == "p2d")
                                {
                                ?>
                                <div class="step">
                                    <div class="title">
                                        <div class="step-label">
                                            <div class="label-holder">
                                                <strong><?=++$currentOrderStep?></strong>
                                                <p><?=GetMessage('SOA_TEMPL_SHAG')?></p>
                                            </div>
                                        </div>
                                        <h2><?=GetMessage('SOA_TEMPL_PAYMENT')?></h2>
                                    </div>
                                    <div class="holder">
                                        <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");?>
                                    </div>
                                </div>
                                <div class="step">
                                    <div class="title">
                                        <div class="step-label">
                                            <div class="label-holder">
                                                <strong><?=++$currentOrderStep?></strong>
                                                <p><?=GetMessage('SOA_TEMPL_SHAG')?></p>
                                            </div>
                                        </div>
                                        <h2><?=GetMessage('SOA_TEMPL_DELIVER')?></h2>
                                    </div>
                                    <div class="holder">
                                        <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");?>
                                    </div>
                                </div>
                                <?
                                }
                                else
                                {
                                ?>
                                <div class="step">
                                    <div class="title">
                                        <div class="step-label">
                                            <div class="label-holder">
                                                <strong><?=++$currentOrderStep?></strong>
                                                <p><?=GetMessage('SOA_TEMPL_SHAG')?></p>
                                            </div>
                                        </div>
                                        <h2><?=GetMessage('SOA_TEMPL_DELIVER')?></h2>
                                    </div>
                                    <div class="holder">
                                        <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");?>
                                    </div>
                                </div>
                                <div class="step">
                                    <div class="title">
                                        <div class="step-label">
                                            <div class="label-holder">
                                                <strong><?=++$currentOrderStep?></strong>
                                                <p><?=GetMessage('SOA_TEMPL_SHAG')?></p>
                                            </div>
                                        </div>
                                        <h2><?=GetMessage('SOA_TEMPL_PAYMENT')?></h2>
                                    </div>
                                    <div class="holder">
                                        <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");?>
                                    </div>
                                </div>
                                <?
                                }
                            ?>
                            <?
                                //include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php");

                                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");

                                if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
                                    echo $arResult["PREPAY_ADIT_FIELDS"];
                            ?>

                            <?if($_POST["is_ajax_post"] != "Y")
                                {
                                ?>
                            </div>
                            <input type="hidden" name="confirmorder" id="confirmorder" value="Y">
                            <input type="hidden" name="profile_change" id="profile_change" value="N">
                            <input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
                            <div class="buttons"><a href="javascript:void();" onclick="submitForm('Y'); return false;" class="button btn-cart"><span><?=GetMessage("SOA_TEMPL_BUTTON")?></span></a></div>
                        </fieldset>
                    </form>
                    <?
                        if($arParams["DELIVERY_NO_AJAX"] == "N")
                        {
                        ?>
                        <div style="display:none;"><?$APPLICATION->IncludeComponent("bitrix:sale.ajax.delivery.calculator", "", array(), null, array('HIDE_ICONS' => 'Y')); ?></div>
                        <?
                        }
                    }
                    else
                    {
                    ?>
                    <script type="text/javascript">
                        top.BX('confirmorder').value = 'Y';
                        top.BX('profile_change').value = 'N';
                    </script>
                    <?
                        die();
                    }
                }
            }
        ?>
    </div>
</div>