(function($) {
    const not_is_element_text = ':checkbox, :radio, select';

    /**
     * @author Alfredo Martinez
     */
    $.fn.getObjectDataTable = function(to_json = false) {
        let data = $(this).dataTable().fnGetData();

        return to_json ? JSON.stringify(data) : data;
    };

    /**
     * @author Alfredo Martinez
     */
    $.fn.getFormData = function() {
        const $tables = $(this).find(`table`);
        const data_array = $(this).find(`:input`).serializeArray();
        let form_data = new FormData();

        // DataTable
        if ($.fn.DataTable.isDataTable(this))
            form_data.append($(this).attr(`id`) || 'dt', $(this).getObjectDataTable(true));

        $tables.each(function() {
            form_data.append($(this).attr(`id`) || 'dt', $(this).getObjectDataTable(true));
        });

        // Inputs
        for (i = 0; i < data_array.length; i++)
            form_data.append(data_array[i].name, data_array[i].value);

        return form_data;
    };

    /**
     * Busqueda sobre contenedor por el atributo nombre con la capcidad de iterar niveles
     *
     * @author Alfredo Martinez
     */
    $.fn.fieldsByName = function(names = [], level = 0, exclude = 'd-none') {
        let container = this;

        for (i = 0; i < level; i++)
            container = container.end();

        return $(container)
            .find(names.map(name => `[name${ name.indexOf('*') > -1 ? '^' : '' }='${ name.replace('*', '') }']`).join())
            .not(exclude);
    };

    /**
     * Plugin para la posicion del cursor en un input (Extraido de internet):
     *
     * @author Alfredo Martinez
     *
     * { after:  n } -> El cursor se posiciona despues de dicha posicion numerica.
     * { start:  true } -> El cursor se posiciona al principio.
     * { last:   true } -> El cursor se posiciona al final.
     * { select: true } -> Selecciona el contenido del input
     */
    $.fn.setCursorPosition = function(t) {
        let s = $.extend({
                after: !1,
                start: !1,
                end: !0,
                select: !1
            }, t),
            n = $(this),
            r = n.val().length;

        n.focus(), s.after && (r = s.after), s.start && (r = 0), s.select || n[0].setSelectionRange(r, r), s.select && n[0].select()
    };

    /**
     * Conversion a mayusculas
     *
     * @author Alfredo Martinez
     */
    $.fn.allToUpperCase = function() {
        $.each($(this), function(index, element) {
            if (!$(element).is(not_is_element_text)) {
                $(element).on('input', function(e) {
                    e.preventDefault();
                    const cP = this.selectionStart; // Posicion actual del cursor en el input

                    // Se asgina el valor con UpperCase con la posicion de entrada del cursor
                    $(this).val($(this).val().toUpperCase()).setCursorPosition({ after: cP });
                });
            }
        });

        return this;
    };

    /**
     * Conversion a mayusculas
     *
     * @author Alfredo Martinez
     */
    $.fn.allToLowerCase = function() {
        $.each($(this), function(index, element) {
            if (!$(element).is(not_is_element_text)) {
                $(element).on('input', function(e) {
                    e.preventDefault();
                    const cP = this.selectionStart; // Posicion actual del cursor en el input

                    // Se asgina el valor con LowerCase con la posicion de entrada del cursor
                    $(this).val($(this).val().toLowerCase()).setCursorPosition({ after: cP });
                });
            }
        });

        return this;
    };

    /**
     * Solo valores alfabeticos con opcion de permitir caracteres adicionales mediante others
     *
     * @author Alfredo Martinez
     */
    $.fn.classOnlyAlphabetic = function(whitespace = false, others = '', specialAlpha = false) {
        $.each($(this), function(index, element) {
            if (!$(element).is(not_is_element_text)) {
                $(element).on('input', function(e) {
                    e.preventDefault();

                    const character = valIsEmpty(e.originalEvent) ? this.value : e.originalEvent.data;
                    const specialAlphaChars = specialAlpha ? 'ÁÉÍÓÚáéíóúÑñÜü' : '';

                    // ascci: [180: acento agudo, 168: diéresis]
                    if (character !== null && [180, 168].indexOf(character.charCodeAt(0)) === -1)
                        this.value = this.value.replace(new RegExp(`[^${ whitespace ? ' ' : '' }A-Za-z${ specialAlphaChars }${ others }]`, 'g'), '');
                });
            }
        });

        return this;
    };

    //simply functional
    $('.classUserCharacters').on('input', function () {
          this.value = this.value.replace(/[^0-9A-Za-z0-9\-_ÁÉÍÓÚáéíóúÑñÜü#$%&¿?¡!,/*+ ]/g,'');
    });
    //validacion caracteres generales (ej: campo observaciones)
    $('.classGeneralCharacters').on('input', function () {
        this.value = this.value.replace(/[^0-9A-Za-z0-9\-_ÁÉÍÓÚáéíóúÑñÜü#$%&¿?¡!.,/*+°() ]/g,'');
    });

    /* Solo valores alfanumericos con opcion de permitir caracteres adicionales mediante others */
    $.fn.classOnlyAlphanumeric = function(whitespace = false, others = '') {
        return $(this).classOnlyAlphabetic(whitespace, '0-9' + others);
    };

    /**
     * Limita el maximo de caracteres aceptados en el input
     *
     * @author Alfredo Martinez
     */
    $.fn.classMaxCharacters = function(max = 50) {
        this.on('input', function(e) {
            e.preventDefault();

            $(this).val(($(this).val().length > max ? $(this).val().slice(0, -($(this).val().length - max)) : $(this).val()));
        });

        return this;
    };

    /**
     * Mascara para solo caracteres validos de un email
     *
     * @author Alfredo Martinez
     */
    $.fn.classOnlyEmail = function() {
        $.each($(this), function(index, element) {
            if (!$(element).is(not_is_element_text)) {
                $(element).on('input', function(e) {
                    e.preventDefault();

                    this.value = this.value.replace(/[^a-zA-Z0-9@.!#$%&'*+-/=?^_`{|}~]/g, '');

                    // Se depuran posiciones de arrobas adicionales erroneos
                    for (let x = 1; x < (this.value.split('@').length - 1); x++)
                        this.value = this.value.substring(0, this.value.lastIndexOf('@'));
                });
            }
        });

        return this;
    };

    /**
     * Solo acepta la entrada de numeros enteros en un input, mediante el uso de la clase definida en el selector por Regex
     *
     * @author Alfredo Martinez
     */
    $.fn.classOnlyIntegers = function(others = '') {
        $.each($(this), function(index, element) {
            if (!$(element).is(not_is_element_text)) {
                $(element).on('input', function(e) {
                    e.preventDefault();
                    this.value = this.value.replace(new RegExp(`[^0-9${ others }]`, 'g'), '');
                });
            }
        });

        return this;
    };

    /* Realiza limpieza de un select */
    $.fn.emptySelect = function(prop_disable = false) {
        let varItem = $(this);

        varItem.empty().append($('<option></option>').attr('value', '').text('Seleccione una opción'));
        varItem.prop('disabled', prop_disable);

        return this;
    };

    $.fn.setSelectData = function(data, defval = null, change = null) {
        let varItem = $(this);
        let valExists = false;

        varItem.empty().append($('<option></option>').attr('value', '').text('Seleccione una opción'));

        let valorUnico = (Object.keys(data).length == 1);
        let selected = valorUnico ? 'selected' : '';

        $.each(data, function(key, value) {
            if (value.id != 'undefined' && !valIsEmpty(value.id))
                varItem.append($('<option></option>').attr('value', value.id).attr('data-clave', value.clave).text(value.descripcion).prop('selected', selected));
            else
                varItem.append($('<option></option>').attr('value', key).text(value).prop('selected', selected));

            if ((!valIsEmpty(defval) && (key == defval)) || valorUnico) {
                valExists = true;
            }
        });

        if (!valIsEmpty(defval) && valExists) {
            varItem.val(defval);
        } else if (valIsEmpty(selected)) {
            $(this).prop("selectedIndex", 0);
        }

        if ((valorUnico || !valIsEmpty(defval)) && !valIsEmpty(change) && valExists) {
            varItem.change();
        }

        return this;
    };
})(jQuery);