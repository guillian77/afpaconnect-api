import {get, post} from "./ajax";

const TYPE_SUCCESS = 'type-success';
const TYPE_INFO = 'type-info';
const TYPE_WARNING = 'type-warning';
const TYPE_ERROR = 'type-error';

/**
 * Read all messages from server session.
 */
let read = async function ()
{
    return await get('/api/messages')
        .then(messages => {
            return messages.content;
        });
}

/**
 * Display messages.
 */
export let displayMessages = async function()
{
    let messages = await read();

    for (let index in messages) {
        let message = messages[index];

        let config = getMessageConfig(message)
            config.message = message.body;
            config.title = message.title;

        iziToast.show(config);
    }
}

/**
 * Make iziToast configuration for a message.
 *
 * @param message Le tableau contenant le message 0 => [title, body, type].
 *
 * @return {{backgroundColor: string, position: string, title: string, message: string, timeout: number}}
 */
let getMessageConfig = function(message)
{
    let params = {
        timeout: 4000,
        backgroundColor: '#90EE90',
        position: 'topRight',
        title: "",
        message: "",
    };

    switch (message.type) {
        case TYPE_SUCCESS:
            params.backgroundColor = '#198754';
            break;
        case TYPE_INFO:
            params.backgroundColor = '#0dcaf0';
            break;
        case TYPE_WARNING:
            params.backgroundColor = '#ffc107';
            params.timeout = 5500;
            break;
        case TYPE_ERROR:
            params.backgroundColor = '#dc3545';
            params.timeout = 5500;
            break;
    }

    return params;
}

/**
 * Add new message to session server storage.
 *
 * @param {String} title
 * @param {String} body
 * @param {String} type
 *
 * @return {Boolean}
 */
export let add = function (title, body, type = null)
{
    let parametersToSend = {
        'title': title,
        'body': body,
    };

    if (type !== null) {
        parametersToSend.type = type;
    }

    post('/api/message/create', parametersToSend)
}

/**
 * Construct message content to send.
 *
 * @param {String} code 
 * @param {String} successBody 
 *
 */
export let constructBodyMessage = function (code, successBody = null) 
{
    switch (code) {
        case 200 : add("Succès", successBody , "type-success");
                    break;
        case 204 : add("Oups...", "Il nous manque certaines informations... Veuillez remplir tous les champs.", "type-warning");
                    break;
        case 400:  add("Oups...", "Une erreur est survenue, veuillez reéssayer.", "type-error");
                    break;
        case 500:  add("Oups...", "Une erreur est survenue, veuillez contacter le service support d'AfpaConnect.", "type-error");
                    break;
        default:
            break;
    }
}

/**
 * Display an iziToast lib message directly from JS.
 *
 * @param {String} title Message title.
 * @param {String} body Message body content.
 * @param {String} type Type: type-success, type-error.
 */
export let display = function (title, body, type = "type-success")
{
    let config = getMessageConfig({type: type});
        config.message = body;
        config.title = title;

    iziToast.show(config);
}

