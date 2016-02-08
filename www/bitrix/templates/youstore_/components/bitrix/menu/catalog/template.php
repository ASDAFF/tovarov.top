<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $this->setFrameMode(true); ?>
<? if (!empty($arResult)): ?>
    <ul id="nav">
        <?
        //setlocale(LC_ALL, 'ru_RU.CP1251');
        $prevLevel = 0;
        foreach ($arResult as $arItem):
        if ($arItem['DEPTH_LEVEL'] == 1) {
            $arItem["TEXT"] = strtoupper($arItem["TEXT"]);
            $counter=0;
        }//."[".$arItem["DEPTH_LEVEL"]."]";  */
        ?>
        <? if ($prevLevel > $arItem["DEPTH_LEVEL"]): ?>
            <?
            switch ($prevLevel) {
                case 3:
                    switch ($arItem["DEPTH_LEVEL"]) {
                        case 2:
                            echo "</ul></div><!--.col-->";
                            break;
                        case 1:
                            echo "</ul></div><!--.col--></div></div><!--.drop-->";
                            break;
                    }
                    break;
                case 2:
                    echo "</div></div><!--.drop-->";
                    break;
                default:
                    break;
            }
            ?>
        <? endif ?>

        <? if ($arItem["DEPTH_LEVEL"] == 2): ?>
            <div class="col" <?= (($counter++ % 5) == 0) ? "style='clear:both'" : "" ?>>
            <a href="<?= $arItem['LINK'] ?>" class="col-title"><?= $arItem["TEXT"] ?></a>
            <? else: ?>
            <li <? if ($arItem["SELECTED"]): ?>class="active"<? endif ?>><a
                    href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                <? endif ?>
                <? if ($arItem["IS_PARENT"]): ?>
                <? if ($arItem["DEPTH_LEVEL"] == 1): ?>
                <div class="drop">
                    <div class="columns">
                        <? else: ?>
                        <ul class="sub-menu">
                            <? endif ?>
                            <? else: ?>
                            <? if ($arItem["DEPTH_LEVEL"] == 1 || $arItem["DEPTH_LEVEL"] == 3): ?>
                                </li>
                            <? else: ?>
                    </div>
                    <? endif ?>
                    <? endif ?>
                    <?
                    $prevLevel = $arItem["DEPTH_LEVEL"];
                    endforeach; ?>
                    <?
                    switch ($prevLevel) {
                        case 3:
                            echo "</ul></div><!--.col--></div></div><!--.drop--></li>";
                            break;
                            break;
                        case 2:
                            echo "</div></div><!--.drop-->";
                            break;
                        default:
                            break;
                    }
                    ?>
    </ul>
<? endif ?>