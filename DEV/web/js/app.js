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

console.log('APP')

/**
 * XHR POST Request
 * @param url
 * @param parameters
 * @param callback
 * @param file
 */
let post = function (url, parameters, callback, file= false) {
    $.ajax({
        url: url,
        data: parameters,
        type: 'POST',
        processData: file === false,
        contentType: file === false,
        success: resp => {
            callback(resp)
        },
        error: err => {
            callback(err)
        }
    });
}

/**
 * XHR GET Request
 * @param url
 * @param parameters
 * @param callback
 * @param file
 */
let get = function (url, parameters, callback, file= false) {
    $.ajax({
        url: url,
        data: parameters,
        type: 'GET',
        success: resp => {
            callback(resp)
        },
        error: err => {
            callback(err)
        }
    });
}