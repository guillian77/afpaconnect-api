/**
* USER MANAGE JAVASCRIPT
*
* @package AfpaConnect Project
* @subpackage javascript
* @author @Afpa Lab Team - Aufrère Guillian
* @copyright  1920-2080 The Afpa Lab Team Group Corporation World Company
* @version v1.0
*/

/**
 * Define table header fields.
 * @type {({orderable: boolean, name: string, show: boolean}|{orderable: boolean, name: string, show: boolean}|{orderable: boolean, name: string, show: boolean}|{orderable: boolean, name: string, show: boolean}|{orderable: boolean, name: string, show: boolean})[]}
 */
let tableFields = [
    { "name": "UID", "orderable": true, "show": true},
    { "name": "ID Centre", "orderable": false, "show": false},
    { "name": "N° de matricule", "orderable": true, "show": true},
    { "name": "Mot de passe", "orderable": false, "show": false},
    { "name": "Nom", "orderable": true, "show": true},
    { "name": "Prénom", "orderable": true, "show": true},
    { "name": "Mail pro", "orderable": false, "show": false},
    { "name": "Mail perso", "orderable": false, "show": false},
    { "name": "Portable", "orderable": false, "show": false},
    { "name": "Adresse", "orderable": false, "show": false},
    { "name": "Complément adresse", "orderable": false, "show": false},
    { "name": "Code postal", "orderable": false, "show": false},
    { "name": "Ville", "orderable": false, "show": false},
    { "name": "Pays", "orderable": false, "show": false},
    { "name": "Sexe", "orderable": false, "show": false},
    { "name": "Status", "orderable": true, "show": true},
    { "name": "Enregistré le", "orderable": false, "show": false},
    { "name": "Modifié le", "orderable": false, "show": false},
    { "name": "Action", "orderable": false, "show": true},
];

/**
 * Get users from API and fill table with.
 */
get('user/get', {})
    .then(users => {
        $(document).ready(() => {
            let htmlTable = constructTable(tableFields, users, $('#user_manage_actions'));

            let configuration = constructConfig(tableFields, [0, "asc"], "utilisateur");

            $('#user_list')
                .html(htmlTable)
                .DataTable(configuration);
        })
    })
    .catch(err => {
        let alert = document.createElement('div')
            alert.classList.add('alert');
            alert.classList.add('alert-danger');
            alert.innerHTML = JSON.parse(err.responseText)
        $('.action-buttons').before(alert)
    })


/**
 * Fill user edition section.
 *
 * @param user
 */
let fillUserManager = function(user) {
    let uManagerBox = $('.u_managment');
    let uManagerBoxForm = $('.u_managment__form');

    // Show user managment form
    uManagerBox.show(150);

    // Fill user basic informations
    $('.u_managment__form').find('#uid').val(user['id'])
    $('.u_managment__form').find('#beneficiary').val(user['beneficiary'])
    $('.u_managment__form').find('#lastname').val(user['lastname'])
    $('.u_managment__form').find('#firstname').val(user['firstname'])
    $('.u_managment__form').find('#email').val(user['email'])
    $('.u_managment__form').find('#phone').val(user['phone'])


    // Listen form submiting
    uManagerBoxForm.on('submit', event => {
        event.preventDefault();
        uManagerBox.hide();
    })
}
