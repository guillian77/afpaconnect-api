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
export let post = function (url, parameters, file = false) {

    if(!parameters) return false;

    let request =
        file ?
            $.ajax({
                url: url,
                data: parameters,
                type: 'POST',
                processData: false,
                contentType: false
            })
            :
            $.ajax({
                url: url,
                data: parameters,
                type: 'POST'
            })

    return request;
};

/**
 * XHR GET Request
 *
 * @param url
 * @param parameters
 * @param file
 * @return {*}
 */
export let get = async function (url, parameters, file = false) {
    return $.ajax({
        url: url,
        data: parameters,
        type: 'GET',
        processData: file,
        contentType: file,
    });
};