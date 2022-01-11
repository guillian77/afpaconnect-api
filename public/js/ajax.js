/**
 * --------------------------------------------------------------
 * REQUEST
 * --------------------------------------------------------------
 */

/**
 * XHR POST Request
 *
 * @param {String} url Path to call.
 * @param {Array, Object} parameters Data request parameters.
 * @param {boolean} isUpload Specify if request will be a file upload.
 * @return {*}
 */
export let post = function (url, parameters, isUpload = false) {
    if(!parameters) return false;

    let configuration = {
        url: url,
        data: parameters,
        type: 'POST',
        processData: true,
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8'
    }

    if (isUpload) {
        configuration.processData = false;
        configuration.contentType = false;
    }

    return $.ajax(configuration);
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