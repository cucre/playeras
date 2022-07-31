var $errorEnPeticion = 'Ocurrió un error en el sistema. Intente nuevamente.';

/* Devuelve TRUE en caso de que el valor sea un vacio */
function valIsEmpty(value, extra = '') {
    if (value !== null && $.type(value) !== 'undefined' && $.type(value) !== 'null')
        return ((value.length < 1 || $.trim((value).toString()).length < 1 || value === false || value.toString() === extra) ? true : false);
    else
        return true;
}

/**
 * Devolver Fecha con formato 2 caracteres
 * @param {type} $mounth
 */
function setDateStr($mes){
    var FechStr = ( $mes < 10 ) ? '0' + $mes : $mes;
    return FechStr;
}

/**
 * Asignar valor a un item
 * @param {type} $String
 * @param {type} $value
 * @returns {undefined}
 */
function truncateString(str, length) {
    return str.length > length ? str.substring(0, length - 3) + '...' : str;
}

/**
 * Asignar valor a un item
 * @param {type} $item
 * @param {type} $value
 * @returns {undefined}
 */
function setValue($item, $value) {
    $("#" + $item).val($value);
}

/**
 * Funcion que devuelve el valor de un item
 * @param {type} $item
 * @returns {jQuery}
 */
function getValue($item) {
    return $("#" + $item).val();
}

/**
 * Ordena un combo en base al texto de las opciones
 *
 * @param select    [objeto/elemento select]
 * @param order_asc [ordenamiento en forma ascendente]
 * @param refresh_plugin    [Actualiza plugin de combo si tiene la clase chosen o selectpicker]
 */
function sortSelect(select, order_asc = true, refresh_plugin = true) {
    let empty_option = false;
    let first_option = select.find("option").first();
    let option_selected = -1;
    if(valIsEmpty(first_option.val())){
        empty_option = true;
        select.find("option").first().remove();
    }

    select.find("option").sort(function(a, b) {
        if(option_selected == -1 && $(a).is(":selected"))
            option_selected = $(a).val();

        return order_asc ? a.textContent.localeCompare(b.textContent)
            : b.textContent.localeCompare(a.textContent);
    }).appendTo(select);

    if(empty_option){
        select.prepend(first_option[0]["outerHTML"]);
    }

    select.val( option_selected != -1 ? option_selected : select.find("option").first().val() );
}

/**
 * Obtiene la referencia al registro de un dataTable
 * @param {table} instancia datatable
 * @param {element}
 * @returns {row}
 */
function getRow (table, element) {
    let $parentRow = $( element ).parents('tr');

    if ( $parentRow.hasClass("child") ) {
        $parentRow = $( element ).closest("tr").prev()[0];
    }
    return table.row($parentRow);
}

/**
 * Obtiene row.data de un registro de dataTable
 * @param {row}
 * @returns {dataRow}
 */
function getDataRow (row) {
    return row.data();
}

/* Actualiza fila de datatable con los atributos/valores enviados (changes) y "refresca" la fila con los cambios*/
function datatableSetValuesAndRefreshRow(idTable, trElement, changes, drawType = true){
    $table = $("#"+idTable).DataTable();
    let row = $table.row(trElement);
    let $data = row.data();

    if(jQuery.type($data) == "object") {
        $.each(changes, function(attribute, value) {
            $data[attribute] = value;
        });
        row.invalidate();
        row.draw(drawType);
    }
}

//realiza conteo de elementos de un objeto, devuelve objeto con resumen y elementos validados
function countObjectElements($object) {
    let $result = {hasElements: false, totalElements: 0, elements: {}};

    if(typeof($object) === 'object') {
        $result.elements        = $object;
        $result.totalElements   = Object.keys($object).length;
        $result.hasElements     = $result.totalElements > 0;
    }

    return $result;
}

/**
 * Obtiene el valor del input del datepicker para hacer la comparación de las fechas por si las modifcan manualmente
 *
 * @param  date     Fecha en formato dd/mm/aaaa que se obtiene del input.
 *
 * @return Date     La fecha parseada para su comparación. 0 si el input es vacío.
 */
function convert_date(date) {
    if(valIsEmpty(date))
        return 0;

    var parts = date.split("/");

    return new Date(parts[2], parts[1] - 1, parts[0]);
}


/**
 * Descarga de archivos mediante el metodo POST
 *
 * @author Alfredo Martinez
 *
 * Basado en Codigo original: https://gist.githubusercontent.com/zynick/12bae6dbc76f6aacedf0/raw/b9249403a516e2a1867f1f5ca0d82cd637e0635f/download-file.js
 *
 * @example
 * -> Solo URL
 * downloadFilePOST('url/to/download.php')
 * -> URL, Params
 * downloadFilePOST('url/to/download_with_params.php', { param_1 : 'a', param_2 : 'b', ... })
 * -> Objeto de configuracion
 * downloadFilePOST({
 *      url     : 'url/to/download_with_params.php',
 *      params  : { param_1 : 'a', param_2 : 'b', ... },
 *      new_tab : false,
 *      ...
 * })
 *
 * @param Object options [Objeto JS de configuracion]
 *
 * @return void
 */
function downloadFilePOST(options, _params = false) {
    // Modal de carga

    // En caso de que el parametro de entrada options sea una cadena
    // se tomara como URL con la configuracion de descarga predeterminada
    if (isString(options)) {
        options = { url : options };

        // En caso de que el parametro de entrada _params sea un objeto
        // se tomara como parametros para el web service
        if (isObject(_params))
            options.params = _params;
    }

    // Configuracion default
    let options_default = {
        // Direccion de donde se ejecutara el proceso de desacarga en Back-End
        url              : false,
        // Indicador para abrir el blob en una nueva pestana
        new_tab          : false,
        // Nombre del archivo que se asignara al blob generado
        filename         : false,
        // Objeto (JSON) con parametros opcionales para el consumo de la funcion de descarga
        params           : {},
        // En caso de error un string para el mensaje personalizado opcional
        message_error    : null,
        // Opciones adicionales
        internal_params  : {},
        // Funcion en caso de exito del proceso (internal_params, params, filename) {}
        callback_success : function () {},
        // Funcion en caso de error del proceso (message_error, internal_params, params, filename) {}
        callback_error   : function (message_error, internal_params) {
            $(internal_params.alerts_container || `div#alerts-main`).setAlertDanger(message_error);
        }
    };

    // Merge de configuracion
    options = $.extend(options_default, options);

    // Se inicializa el flujo
    let xhr      = new XMLHttpRequest();
    let _success = false;

    // Configuracion de consumo HTTP
    xhr.open('POST', options.url, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    xhr.responseType = 'arraybuffer';

    // Proceso
    xhr.onload = function () {
        if (this.status === 200) {
            let disposition = xhr.getResponseHeader('Content-Disposition');

            // Si no se indica un filename en la configuracion.
            // De las cabeceras obtenidas de la respuesta se define el nombre del archivo
            if (!options.filename && disposition && disposition.indexOf('attachment') !== -1) {
                // Busqueda del nombre del archivo
                let matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(disposition);

                // Asignacion de nombre del archivo
                options.filename = (matches !== null && matches[1]) ? matches[1].replace(/['"]/g, '') : '_file_';
            }

            // Se obtiene el tipo de archivo desde las cabeceras
            const type = xhr.getResponseHeader('Content-Type');
            // Creacion de un objeto blob con la informacion obtenida de la respuesta en el navegador
            const blob = new Blob([this.response], { type: type });

            if (typeof window.navigator.msSaveBlob !== 'undefined') {
                // IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob
                // for which they were created. These URLs will no longer resolve as the data backing
                // the URL has been freed."
                window.navigator.msSaveBlob(blob, options.filename);
            } else {
                // Enlaces
                const window_url   = window.URL || window.webkitURL;
                const download_url = window_url.createObjectURL(blob);

                if (options.filename) {
                    // Descarga del archivo en una nueva pestana
                    if (options.new_tab) {
                        // Apertura de nueva pestana
                        let w = window.open(download_url, '_blank')
                            // Actualizacion de titulo de la nueva pestana
                            .onload = function () {
                            setTimeout(function () {
                                $(w.document).find(`html`).append(`<head><title>${ options.filename || 'Archivo' }</title></head>`);
                            }, 500);
                        }
                    }
                    // Se genera un link en el DOM para la descarga del archivo en la misma ventana
                    else {
                        // HTML5 a[download]
                        let a = document.createElement('a');

                        // Safari
                        if (typeof a.download === 'undefined')
                            window.location = download_url;
                        // General
                        else {
                            a.href      = download_url;
                            a.download  = options.filename;

                            document.body.appendChild(a);
                            a.click();
                        }
                    }
                } else
                    window.location = download_url;

                // Limpieza
                setTimeout(function () { window_url.revokeObjectURL(download_url); }, 100);
            }

            // Bandera de exito
            _success = true;
        } else {
            // Salida de mensaje de error del proceso
            try {
                options.message_error = options.message_error || $.parseJSON(arrayBufferToString(xhr.response)).message;
            } catch(err) {
                options.message_error = 'No se logró descargar el archivo, favor de intentarlo más tarde.';
            }

            // Bandera para resultado del proceso
            _success = false;
        }

        // Cuando la peticion este completa
        if (xhr.readyState === 4) {
            // Se oculta modal de carga

            /* Ejecucion de funcion callback */

            // Exito
            if (_success)
                options.callback_success(options.internal_params, options.params, options.filename);
            // Error
            else
                options.callback_error(options.message_error, options.internal_params, options.params, options.filename);
        }
    };

    // CONSUMO
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send($.param(options.params));
}

/* Conversion de un arrayBuffer a String en UTF-8 */
function arrayBufferToString(buffer) {
    let str = String.fromCharCode.apply(String, new Uint8Array(buffer));

    if(/[\u0080-\uffff]/.test(str))
        throw new Error('String seems to contain (still encoded) multibytes!');

    return str;
}

/**
 * Validacion de tipo de dato
 *
 * https://webbjocke.com/javascript-check-data-types/
 *
 */

// Returns if a value is a string
function isString(value) {
    return typeof value === 'string' || value instanceof String;
}

// Returns if a value is really a number
function isNumber(value) {
    return typeof value === 'number' && isFinite(value);
}

// Returns if a value is a function
function isFunction(value) {
    return typeof value === 'function';
}

// Returns if a value is an object
function isObject(value) {
    return value && typeof value === 'object' && value.constructor === Object;
}

// Returns if a value is null
function isNull(value) {
    return value === null;
}

// Returns if a value is undefined
function isUndefined(value) {
    return typeof value === 'undefined';
}

// Returns if a value is a boolean
function isBoolean(value) {
    return typeof value === 'boolean';
}

// Returns if a value is a regexp
function isRegExp(value) {
    return value && typeof value === 'object' && value.constructor === RegExp;
}

// Returns if value is an error object
function isError(value) {
    return value instanceof Error && typeof value.message !== 'undefined';
}

// Returns if value is a date object
function isDate(value) {
    return value instanceof Date;
}

// Returns if a Symbol
function isSymbol(value) {
    return typeof value === 'symbol';
}

//Valida solo numeros con 1 punto y maximo dos decimales
function filterFloat(evt, input) {
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value + chark;

    if(key >= 48 && key <= 57) {
        if(filter(tempValue) === false){
            return false;
        } else {
            return true;
        }
    } else {
        if(key == 8 || key == 13 || key == 0) {
            return true;
        } else if(key == 46) {
            if(filter(tempValue) === false) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}

function filter(__val__) {
    var preg = /^([0-9]+\.?[0-9]{0,2})$/;

    if(preg.test(__val__) === true) {
        return true;
    } else {
       return false;
    }
}