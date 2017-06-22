/**
 * Установява избраните кутийки като такива, които се въвъждат с Date Picker.
 * За да бъде една такава кутийка избрана тряваб CSS класа и да бъде datepicker.
 */
function setupDatePicker()
{
    jQuery(".datepicker").datepicker(
            {
                firstDay: "1",
                dateFormat: 'dd.mm.yy',
                showOtherMonths: true,
                selectOtherMonths: true,
                weekHeader: 'W',
                showWeek: true,
                showButtonPanel: false,
                numberOfMonths: 1,
                changeMonth: false,
                changeYear: true,
                autoSize: true,
//                buttonImage: 'data:image/png;base64,R0lGODlhEAAPAPQAAIyq7zlx3lqK5zFpznOe7/729fvh3/3y8e1lXt1jXO5tZe9zbLxeWfB6c6lbV/GDffKIgvKNh/OYkvSblvSinfWrp3dTUfawq/e1sf3r6v/8/P/9/f///////wAAAAAAACH5BAEAAB0ALAAAAAAQAA8AAAWK4GWJpDWN6KU8nNK+bsIxs3FdVUVRUhQ9wMUCgbhkjshbbkkpKnWSqC84rHA4kmsWu9lICgWHlQO5lsldSMEgrkAaknccQBAE4mKtfkPQaAIZFw4TZmZdAhoHAxkYg25wchABAQMDeIRYHF5gEkcSBo2YEGlgEEcQoI4SDRWrrayrFxCDDrW2t7ghADs=',
                buttonImage: 'data:image/png;base64,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',
                        buttonImageOnly: true,
                showOn: 'button',
                createButton: false
            });
    disabledDatePicker()
}

/**
 * Забранява редактирането на datepicker-ра на онези кутий които имат атрибут readonlydate
 */
function disabledDatePicker()
{
    jQuery("input[readonlydate]").each(
            function (i, v)
            {
                jQuery(v).datepicker("disable");
                jQuery(v).removeAttr("disabled");
            });
}

/**
 * Разрешава редактирането на datepicker-ра
 */
function enabledDatePicker()
{
    jQuery("input[readonlydate]").each(
            function (i, v)
            {
                jQuery(v).datepicker("enable");
                jQuery(v).removeAttr("readonlydate");
            });
}
/**
 * Проверява всички полета с дадено име и ако има грешка ги маркира.
 * @param classname име на класа на полето.
 * @param re регулярен израз за проверка.
 * @param f името на формата
 */
function checkField(classname, re, f)
{
    var ok = true;
    jQuery("." + classname, jQuery(f)).each(
            function (i, v)
            {
                v = jQuery(v)
                if (v.val() != null && v.val().length > 0 && !re.test(v.val()))
                {
                    ok = false;
                    v.addClass("ui-state-error");
                }
            });
    return ok;
}

/**
 * Валидира задължителните полеата. Това че са задължителни се отбелязва с
 * атрибута required със стойност Y.
 * @param f форма, полетата на която трябва да се проверят.
 */
function validateRequired(f)
{
    var ok = true;
    jQuery(" input[required], select[required]", jQuery(f)).each(//нещо не селекти както трябва в мозилата, при подаден контекст
//   jQuery("[required='Y']"/*, jQuery(f)*/).each( //нещо не селекти както трябва в мозилата, при подаден контекст
            function (i, v)
            {
                var n = v.getAttribute("name");
                v = jQuery(v)
                if (v.val() == null || v.val().length == 0)
                {
                    ok = false;
                    v.addClass("ui-state-error");
                }
                // един лов има стойност ако му е попълнено и ид-то
                v.siblings("input[name= '" + n + "_id']").each(
                        function (x, z)
                        {
                            if (z.getAttribute("value") == null || z.getAttribute("value").length == 0)
                            {
                                ok = false;
                                v.addClass("ui-state-error");
                            }
                        })
            });
    return ok;
}

/**
 * Валидира полетата в избрана форма. Проверява се дали са попълнени
 * задължителните полета и дали формата на стойността отговаря на поставените с
 * регулярен израз условия. Резултатът е boolean TRUE ако всичко е наред и
 * FALSE ако има поне една грешка. Той може да се използва за вземане на
 * решение дали формата да се submit-не или не.
 * @param f форма, полетата на която трябва да се проверят.
 */
function vallidateForm(f)
{
    jQuery("input", jQuery(f)).each(
            function (i, v)
            {
                v = jQuery(v);
                v.removeClass("ui-state-error");
            }
    );
    var ok = validateRequired(f);
    ok &= checkField("number", /^\d{0,}$/, f);
    ok &= checkField("datepicker", /^\d{2}\.\d{2}\.\d{4}$/, f);
    ok &= checkField("money", /^((\d{1,}|(,\d{3}))*(\.\d{2}))|(\d{0,})$/, f);
    ok &= checkField("hour", /^([0-1]?\d|2[0-3]):([0-5]?\d):([0-5]?\d)/, f);

    return ok;
}

/**
 * Закача LoV за всички кутии, които имат указана версия на номенклатура.
 */
function attachAjaxLoV()
{
    jQuery("input[mdclvid]").each(
            function (i, v)
            {
                new LOVAjaxPanel().initLOV(v.id);
            });
}

/**
 * Закача червена точка за кутийте, които имат указана стара стойност.
 */
function attachAjaxInputField()
{
    jQuery("input[redpoint]").each(
            function (i, v)
            {
                new ISISInputField().initField(v.id);
            });
}



/**
 * Използва се при подписване на структурните атрибути
 * Ако не е цъкнато че съответния атрибут се променя, то тогава
 * input полетата във таблицата не трбва да се подписват
 * Тази функция се грижи да маха атрибута signMe
 */
function removeStructureAttrSignMe(tableId)
{
    jQuery("#" + tableId + " tr td input[signMe]").each(
            function (i, v)
            {
                v = jQuery(v);
                v.removeAttr("signMe");
            });
}

function addStructureAttrSignMe(tableId)
{
    jQuery("#" + tableId + " tr td input[type='text']").each(
            function (i, v)
            {
                if (v.getAttribute("mdclvid") == null)
                {
                    // ако не е LoV по нормален начин
                    v.setAttribute("signMe", "");
                }
                else
                {
                    // ако е LoV по г***ян, подписва се нещо дето не се вижда,
                    // но е форматирано като за подпис; надяваме се че по същия начин
                    // ще се прави и при проверката в swing приложението
                    // брата дето се казва като този елемент със суфикс като за подпис
                    var n = v.getAttribute("name");
                    v = jQuery(v);
                    v.siblings("input[name= '" + n + "_signadjval']").each(
                            function (x, z)
                            {
                                z.setAttribute("signMe", "");
                            })
                }

            });
}

function setupMenu() {
    jQuery("tr[class='selected']").each(
            function (i, v)
            {
                x = v.offsetTop
                var curtop = 0
                if (v.offsetParent) {
                    do {
                        curtop += v.offsetTop;
                    } while (v = v.offsetParent);
                }
                jQuery("div[class='menu']").each(
                        function (i, vc)
                        {
                            vc.style.top = curtop + 'px';
                            vc.style.display = 'block';
                        });
            });
}