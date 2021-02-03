/**
 * COMMUN JAVASCRIPT
 *
 * @package AfpaConnect Project
 * @subpackage javascript
 * @author @Afpa Lab Team - Aufrère Guillian && Campillo Lucas
 * @copyright  1920-2080 The Afpa Lab Team Group Corporation World Company
 * @version v1.0
 * 
 * INDEX
 * - GENERAL
 */

/**
 * --------------------------------------------------------------
 * REQUEST
 * --------------------------------------------------------------
 */

/**
 * XHR POST Request
 *
 * @param url
 * @param parameters
 * @param file
 * @return {*}
 */
let post = function (url, parameters, file = false) {
    return $.ajax({
        url: url,
        data: parameters,
        type: 'POST',
        processData: file === false,
        contentType: file === false,
    });
};

/**
 * XHR GET Request
 *
 * @param url
 * @param parameters
 * @return {*}
 */
let get = async function (url, parameters) {
    return $.ajax({
        url: url,
        data: parameters,
        type: 'GET',
    });
};
