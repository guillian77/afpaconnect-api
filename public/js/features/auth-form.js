/*
|--------------------------------------------------------------------------
| DEFINE VARIABLES AND CONSTANTS
|--------------------------------------------------------------------------
|
| Select elements and hide non necessary fields.
|
*/
let authForm = document.querySelector('#auth-form');
let fields = document.querySelectorAll('input,label');

let firstnameEl = document.querySelector('#auth-form #auth-form__firstname');
let lastnameEl = document.querySelector('#auth-form #auth-form__lastname');
let passwordEl = document.querySelector('#auth-form #auth-form__password');
let passwordConfirmationEl = document.querySelector('#auth-form #auth-form__password_confirmation');
let submitEl = document.querySelector('#auth-form button');
let messageEl = document.querySelector('#auth-form #auth-form__message');

let formState = "init";

/*
|--------------------------------------------------------------------------
| DEFINE FUNCTIONS
|--------------------------------------------------------------------------
|
*/
/**
 * Provide full URL with specified target page.
 *
 * @param {String} path
 *
 * @returns {string}
 */
let urlProvider = function (path)
{
    return "route.php?page=" + path + "&bJSON=1";
}

/**
 * Verify user exist and state from a username.
 *
 * @returns {{firstname: string, code: number, lastname: string}}
 */
let authVerify = async function()
{
    let url = urlProvider(configuration.verify);

    let err = false;

    let resp = await axios.get(url)
        .then( function(resp) {
            return {
                'firstname': "Guillian",
                'lastname': "Aufrère",
                'code': 0
            };
        })
        .catch(err => {
            err = true;
            return err
        })

    if (err) {
        return {
            code: 0
        }
    }

    return resp;
}

/**
 * Fill user fields with user data.
 *
 * @param userData
 */
let fillUserFields = function(userData)
{
    firstnameEl.style.display = "block";
    firstnameEl.value = userData.lastname;

    lastnameEl.style.display = "block";
    lastnameEl.value = userData.firstname;
}

/*
|--------------------------------------------------------------------------
| CODE LOGIC
|--------------------------------------------------------------------------
|
*/
fields.forEach((field, index) => {
    if (index > 1) { field.style.display = "none"; }
});


/*
 * Await for form submission.
 */
authForm.addEventListener('submit', async function (e) {
    e.preventDefault();

    /**
     * Steps to authenticate user with AfpaConnect API.
     *
     * CASE 1. verify-login - user exist
     *      is activated -> Ask password (LOGIN).
     *      is not activated -> Ask password and password confirmation (REGISTER).
     * In any cases, show firstname and lastname to user.
     *
     * CASE 2. verify login - user not exist in AfpaConnect API.
     *      Show an error message with a mail.
     */
    let user = await authVerify();

    if (user.code === 101) { // USER_REGISTERED
        fillUserFields(user)

        passwordEl.style.display = "block";

        messageEl.innerHTML = "Vous pouvez vous connectez."

        authForm.setAttribute('action', configuration.login)
    } else if (user.code === 102) { // USER_NOT_REGISTERED
        fillUserFields(user)

        passwordEl.style.display = "block";
        passwordConfirmationEl.style.display = "block";

        messageEl.innerHTML = "Vous devez finaliser votre inscription sur nos services."

        authForm.setAttribute('action', configuration.register)
    } else if (user.code === 100) { // USER_NOT_FOUND
        messageEl.innerHTML = "Aucun compte n'a été trouvé avec votre nom d'utilisateur. Veuillez contacter l'administrateur."

        submitEl.style.display = "none";
        authForm.setAttribute('disable', 'disable');
    } else {
        messageEl.innerHTML = "Impossible de contacter le service d'identification.";

        submitEl.style.display = "none";
        authForm.setAttribute('disable', 'disable');
    }
});
