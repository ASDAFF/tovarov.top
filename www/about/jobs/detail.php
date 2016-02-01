<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
   
?>
<div class="contents">
	<div class="article-container">
		<?
		if($_REQUEST["AJAX"] == "Y") $APPLICATION->RestartBuffer();
		?>
		<div class="vacancy-popup" style="left: -220px; top:-380px;position: absolute;display: block!important;">
			
					<div class="holder">
						<div class="photo">
							<div class="image">
								<a href="#">
									<img alt="image" src="<?=SITE_TEMPLATE_PATH?>/images/img-person2.png">
								</a>
							</div>
						</div>
						<a href="#" class="btn-close">close</a>
						<div class="text-block">
							<?
							$ID = $APPLICATION->IncludeComponent(
								"bitrix:news.detail",
								"job",
								Array(
									"DISPLAY_DATE" => "Y",
									"DISPLAY_NAME" => "Y",
									"DISPLAY_PICTURE" => "Y",
									"DISPLAY_PREVIEW_TEXT" => "Y",
									"USE_SHARE" => "Y",
									"SHARE_HIDE" => "N",
									"SHARE_TEMPLATE" => "",
									"SHARE_HANDLERS" => array(""),
									"SHARE_SHORTEN_URL_LOGIN" => "",
									"SHARE_SHORTEN_URL_KEY" => "",
									"AJAX_MODE" => "N",
									"IBLOCK_TYPE" => "content",
									"IBLOCK_ID" => "15",
									"ELEMENT_ID" => "",
									"ELEMENT_CODE" => $_REQUEST["CODE"],
									"CHECK_DATES" => "Y",
									"FIELD_CODE" => Array("ID", "CREATED_BY"),
									"PROPERTY_CODE" => Array(),
									"META_KEYWORDS" => "KEYWORDS",
									"META_DESCRIPTION" => "DESCRIPTION",
									"BROWSER_TITLE" => "BROWSER_TITLE",
									"DISPLAY_PANEL" => "Y",
									"SET_TITLE" => "Y",
									"SET_STATUS_404" => "Y",
									"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
									"ADD_SECTIONS_CHAIN" => "Y",
									"ADD_ELEMENT_CHAIN" => "Y",
									"ACTIVE_DATE_FORMAT" => "d F, Y",
									"USE_PERMISSIONS" => "N",
									"CACHE_TYPE" => "A",
									"CACHE_TIME" => "3600",
									"CACHE_GROUPS" => "Y",
									"DISPLAY_TOP_PAGER" => "Y",
									"DISPLAY_BOTTOM_PAGER" => "Y",
									"PAGER_TITLE" => "Страница",
									"PAGER_TEMPLATE" => "",
									"PAGER_SHOW_ALL" => "Y",
									"AJAX_OPTION_JUMP" => "N",
									"AJAX_OPTION_STYLE" => "Y",
									"AJAX_OPTION_HISTORY" => "N"
								)
							);?>
						<!--form class="vacancy-form">
                <fieldset>
							<div class="buttons">
								<input type="hidden" name="ID" value="<?=$ID?>" />
								<div class="fileinputs">
									<input type="file" class="file">
									<div class="fakefile">
										<em href="#" class="button gray"><span>Прикрепить резюме</span></em>
									</div>
								</div>
								<button class="button"><span>Отправить</span></button>
							</div> 
						</div>
					</div>
				</fieldset>
			</form-->
            <script type="text/javascript">
            $(document).ready(function(){
                $('#vac_id').val('<?=$ID?>');
                var date =  new Date().toLocaleString();
                $('#vac_name').val($('.text-block h2').text()+' '+date);
               /* $('form.vacancy-form').on('submit',function(){
                    //console.log(encodeURI($(this).serialize()));
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data : encodeURI($(this).serialize()),
                        success:function(html){
                            console.log(html);
                        },
                        
                    });
                    return false;
                })*/
            })
            </script>
             <?include($_SERVER['DOCUMENT_ROOT'].SITE_DIR.'include/functions.php');
             $APPLICATION->IncludeComponent("bitrix:iblock.element.add.form", "add_resume", Array(
                        "IBLOCK_TYPE" => "requests",    // Тип инфоблока
                        "IBLOCK_ID" => "14",    // Инфоблок
                        "STATUS_NEW" => "N",    // Деактивировать элемент
                        "LIST_URL" => "",    // Страница со списком своих элементов
                        "USE_CAPTCHA" => "N",    // Использовать CAPTCHA
                        "USER_MESSAGE_EDIT" => "",    // Сообщение об успешном сохранении
                        "USER_MESSAGE_ADD" => "",    // Сообщение об успешном добавлении
                        "DEFAULT_INPUT_SIZE" => "30",    // Размер полей ввода
                        "RESIZE_IMAGES" => "N",    // Использовать настройки инфоблока для обработки изображений
                        "PROPERTY_CODES" => array(    // Свойства, выводимые на редактирование
                            0 => "NAME",
                            1 => findId('VACANCY_R'),
                            2 => findId('RESUME'),
                        ),
                        "PROPERTY_CODES_REQUIRED" => "",    // Свойства, обязательные для заполнения
                        "GROUPS" => array(    // Группы пользователей, имеющие право на добавление/редактирование
                            0 => "2",
                        ),
                        "STATUS" => "ANY",    // Редактирование возможно
                        "ELEMENT_ASSOC" => "CREATED_BY",    // Привязка к пользователю
                        "MAX_USER_ENTRIES" => "100000",    // Ограничить кол-во элементов для одного пользователя
                        "MAX_LEVELS" => "100000",    // Ограничить кол-во рубрик, в которые можно добавлять элемент
                        "LEVEL_LAST" => "Y",    // Разрешить добавление только на последний уровень рубрикатора
                        "MAX_FILE_SIZE" => "0",    // Максимальный размер загружаемых файлов, байт (0 - не ограничивать)
                        "PREVIEW_TEXT_USE_HTML_EDITOR" => "N",    // Использовать визуальный редактор для редактирования текста анонса
                        "DETAIL_TEXT_USE_HTML_EDITOR" => "N",    // Использовать визуальный редактор для редактирования подробного текста
                        "SEF_MODE" => "N",    // Включить поддержку ЧПУ
                        "CUSTOM_TITLE_NAME" => "",    // * наименование *
                        "CUSTOM_TITLE_TAGS" => "",    // * теги *
                        "CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",    // * дата начала *
                        "CUSTOM_TITLE_DATE_ACTIVE_TO" => "",    // * дата завершения *
                        "CUSTOM_TITLE_IBLOCK_SECTION" => "",    // * раздел инфоблока *
                        "CUSTOM_TITLE_PREVIEW_TEXT" => "",    // * текст анонса *
                        "CUSTOM_TITLE_PREVIEW_PICTURE" => "",    // * картинка анонса *
                        "CUSTOM_TITLE_DETAIL_TEXT" => "",    // * подробный текст *
                        "CUSTOM_TITLE_DETAIL_PICTURE" => "",    // * подробная картинка *
                        "SEF_FOLDER" => "/",    // Каталог ЧПУ (относительно корня сайта)
                        'AJAX_MODE'=>'Y',
                        "AJAX_OPTION_STYLE" => "N",
                        'AJAX_OPTION_JUMP' => "N" 
                    ),
                    false
                );?>
		</div>
		<?
		if($_REQUEST["AJAX"] == "Y") die();
		?> 
	</div>
	<?
		// включаемая область дл¤ раздела
		$APPLICATION->IncludeFile(SITE_DIR."include/parts/main-right-banners.php", Array(), Array(
			"MODE"      => "html",                                           // будет редактировать в веб-редакторе
			"NAME"      => "Баннеры",      // текст всплывающей подсказки на иконке
			"TEMPLATE"  => "section_include_template.php"                    // им¤ шаблона дл¤ нового файла
		));
	?>
</div>
<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>