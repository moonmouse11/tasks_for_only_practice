<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>
<?=$arResult["FORM_NOTE"]?>
<?if ($arResult["isFormNote"] != "Y")
{
?>
<?=$arResult["FORM_HEADER"]?>

<div class="contact-form">
    <div class="contact-form__head">
        <div class="contact-form__head-title">Связаться</div>
        <div class="contact-form__head-text">Наши сотрудники помогут выполнить подбор услуги и&nbsp;расчет цены с&nbsp;учетом
            ваших требований
        </div>
    </div>
    <form class="contact-form__form" action="/" method="POST">
        <div class="contact-form__form-inputs">
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
		if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'){
			echo $arQuestion["HTML_CODE"];}
		else{

        switch ($FIELD_SID) :
            case "SIMPLE_QUESTION_269": ?>
                <div class="input contact-form__input">
                    <label class="input__label" for="medicine_name">
                        <div class="input__label-text"><?=$arQuestion["CAPTION"]?>
                            <? if ($arQuestion["REQUIRED"] == "Y") echo $arResult["REQUIRED_SIGN"]; ?>
                        </div>
                        <input class="input__input" type="<?=$arQuestion["STRUCTURE"]["0"]["FIELD_TYPE"] ?>" id="medicine_name" 
			    name="<?= "form_" . $arQuestion["STRUCTURE"]["0"]["FIELD_TYPE"] . "_" . $arQuestion["STRUCTURE"]["0"]["QUESTION_ID"] ?>"  
                            value="" require="">
                        <div class="input__notification">Поле должно содержать не менее 3-х символов</div>
                    </label>
                 </div>
                <?
                break;
            case "SIMPLE_QUESTION_457": ?>
                <div class="input contact-form__input">
                    <label class="input__label" for="medicine_email">
                        <div class="input__label-text"><?=$arQuestion["CAPTION"]?>
                            <? if ($arQuestion["REQUIRED"] == "Y") echo $arResult["REQUIRED_SIGN"]; ?>
                        </div>
                        <input class="input__input" type="<?=$arQuestion["STRUCTURE"]["0"]["FIELD_TYPE"] ?>" id="medicine_email"
			    name="<?= "form_" . $arQuestion["STRUCTURE"]["0"]["FIELD_TYPE"] . "_" . $arQuestion["STRUCTURE"]["0"]["QUESTION_ID"] ?>"
                            value="" require="">
                        <div class="input__notification">Неверный формат почты</div>
                    </label>
                </div>
            <?
                break;
            case "SIMPLE_QUESTION_258": ?>
                <div class="input contact-form__input">
                    <label class="input__label" for="medicine_company">
                        <div class="input__label-text"><?=$arQuestion["CAPTION"]?>
                            <? if ($arQuestion["REQUIRED"] == "Y") echo $arResult["REQUIRED_SIGN"]; ?>
                        </div>
                        <input class="input__input" type="<?=$arQuestion["STRUCTURE"]["0"]["FIELD_TYPE"] ?>" id="medicine_name"
			    name="<?= "form_" . $arQuestion["STRUCTURE"]["0"]["FIELD_TYPE"] . "_" . $arQuestion["STRUCTURE"]["0"]["QUESTION_ID"] ?>"
                            value="" require="">
                        <div class="input__notification">Поле должно содержать не менее 3-х символов</div>
                    </label>
                </div>
                <?
                break;
            case "SIMPLE_QUESTION_434": ?>
                <div class="input contact-form__input">
                    <label class="input__label" for="medicine_phone">
                        <div class="input__label-text"><?=$arQuestion["CAPTION"]?>
                            <? if ($arQuestion["REQUIRED"] == "Y") echo $arResult["REQUIRED_SIGN"];?>
                        </div>
                        <input class="input__input" type="<?=$arQuestion["STRUCTURE"]["0"]["FIELD_TYPE"] ?>" id="medicine_phone"
                            data-inputmask="'mask': '+79999999999', 'clearIncomplete': 'true'" maxlength="12" x-autocompletetype="phone-full"
			    name="<?= "form_" . $arQuestion["STRUCTURE"]["0"]["FIELD_TYPE"] . "_" . $arQuestion["STRUCTURE"]["0"]["QUESTION_ID"] ?>"
                            value="" required="">
                   </label>
                </div>
            </div>
                <?
                break;
            case "SIMPLE_QUESTION_210": ?>
                <div class="contact-form__form-message">
                    <div class="input">
                        <label class="input__label" for="medicine_message">
                            <div class="input__label-text"><?=$arQuestion["CAPTION"]?>
                                <? if ($arQuestion["REQUIRED"] == "Y") echo $arResult["REQUIRED_SIGN"];?>
                            </div>
                            <textarea class="input__input" type="<?=$arQuestion["STRUCTURE"]["0"]["FIELD_TYPE"] ?>" id="medicine_message"
                                name="<?= "form_" . $arQuestion["STRUCTURE"]["0"]["FIELD_TYPE"] . "_" . $arQuestion["STRUCTURE"]["0"]["QUESTION_ID"] ?>"
                                value=""></textarea>
                            <div class="input__notification"></div>
                        </label>
                    </div>
                </div>
                <?
                break;
            default:
                break;
            endswitch;
            }
	}
	?>
        <div class="contact-form__bottom">
            <div class="contact-form__bottom-policy">Нажимая &laquo;Отправить&raquo;, Вы&nbsp;подтверждаете, что
                ознакомлены, полностью согласны и&nbsp;принимаете условия &laquo;Согласия на&nbsp;обработку персональных
                данных&raquo;.
            </div>
            <button class="form-button contact-form__bottom-button" data-success="Отправлено"
                    data-error="Ошибка отправки" <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" 
                    value="<?=htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == '' ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
                <div class="form-button__title">Оставить заявку</div>
            </button>
        </div>
    </form>
</div>
<?=$arResult["FORM_FOOTER"]?>
<?
} 
