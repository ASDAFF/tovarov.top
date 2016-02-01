<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="history-table">
	<div class="head row">
			<div class="cell cell-1">#</div>
			<div class="cell cell-2"><?=GetMEssage('SPOL_T_F_DATE')?></div>
			<div class="cell cell-3"><?=GetMEssage('SPOL_T_PRICE')?></div>
			<div class="cell cell-4"><?=GetMEssage('SPOL_T_STATUS')?></div>
	</div>
	<?if($arResult["ORDERS"])foreach($arResult["ORDERS"] as $val):
        $colorClass = "";
        switch($val["ORDER"]["STATUS_ID"]){
            case 'Z': $colorClass = "red";break;
            case 'F': $colorClass = "green";break;
            case 'P': $colorClass = "red";break;
                default: break;
        }
        ?>
		<div class="row">
				<div class="cell cell-1"><b><?=$val["ORDER"]["ACCOUNT_NUMBER"]?></b></div>
				<div class="cell cell-2"><?=GetMessage('SPOL_T_F_FROM')?> <?=$val["ORDER"]["DATE_INSERT_FORMAT"]?></div>
				<div class="cell cell-3"><?=$val["ORDER"]["FORMATED_PRICE"]?></div>
				<div class="cell cell-4">
                <?if($val["ORDER"]["STATUS_ID"]=='P'):?>
                    <span class="red"><?=GetMEssage('SPOL_T_F_NONPAYED')?></span>
                    <a href="" onclick="window.open('<?=$arParams['PATH_TO_PAYMENT']?>?ORDER_ID=<?=urlencode(urlencode($val["ORDER"]["ID"]))?>');" class="pay-now"><?=GetMEssage('SPOL_T_F_PAYED')?></a>
                <?else:?>
                    <span class="<?=$colorClass?>">
                        <?=$arResult["INFO"]["STATUS"][$val["ORDER"]["STATUS_ID"]]["NAME"]?>
                    </span>
                <?endif;?>
                    <a href="#" class="btn-expand">expand</a>
				</div>
		</div>
        <div class="expander">
            <table class="exp-table">
                <tbody>
                <?
                foreach($val["BASKET_ITEMS"] as $vval)
                {
                    //echo'<pre>';print_r($vval);echo'</pre>';
                    ?>
                    <tr>
                        <td class="a-left">
                            <a href="<?=$vval["DETAIL_PAGE_URL"]?>">
                                <img src="<?=$arResult["PHOTOS"][$vval["PRODUCT_ID"]]?>" alt="<?=$vval["PRODUCT_ID"]?>" height="36">
                                <?=$vval["NAME"]?>
                            </a>
                        </td>
                        <td width="50"><em><?=$vval["QUANTITY"]?> <?=GetMessage('SPOL_T_F_SHT')?></em></td>
                        <td width="150"><span class="price"><?=$vval["PRICE"]?> <sup><?=GetMessage("CURRENCY_".$vval["CURRENCY"]."_TITLE")?></sup></span></td>
                    </tr>
                <?
                }
                ?>
                </tbody>
            </table>
        </div>
	<?endforeach;?>
</div>
<?if(strlen($arResult["NAV_STRING"]) > 0):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>