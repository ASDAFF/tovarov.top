 <h3>Подписка на новости</h3>
                    <p class="box-text">Для тех, кто хочет быть в курсе всех новых скидок от Dresscode </p>
                    <form class="footer-search" name="subscribe_f" action="<?=SITE_DIR?>ajax/subscribe.php" method="post">
                        <fieldset>
                            <input type="email" required class="text" name="EMAIL" value="Введите ваш Email" />
                            <input type="hidden" name="backurl" value="<?=$APPLICATION->GetCurPage()?>" />
                            <input type="submit" class="submit" value="Подписатся" />
                        </fieldset>
                    </form>