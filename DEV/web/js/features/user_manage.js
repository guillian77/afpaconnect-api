/**
* COMMUN JAVASCRIPT
*
* @package AfpaConnect Project
* @subpackage javascript
* @author @Afpa Lab Team - Aufrère Guillian
* @copyright  1920-2080 The Afpa Lab Team Group Corporation World Company
* @version v1.0
*
* INDEX
* - GENERAL
*/

/**
 * Fill user manager
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


    // Listen form submitting
    uManagerBoxForm.on('submit', event => {
        event.preventDefault();
        uManagerBox.hide();
    })
}

/**
 * Fill HTML table with associative array of data
 * @param {*} table Table element selector
 * @param users
 */
let fillTable = function(table, users) {
    let tableBody = $(table + ' tbody');

    $.each(users, (i, user) => {
        let tr = document.createElement('tr');
        tr.dataset.id = i;
        tr.id = "user-" + i;
        tr.addEventListener('click', evt => {fillUserManager(users[i])})
        tableBody.append(tr)
        $.each(user, (key, value) => {
            let td = document.createElement('td');
            td.innerHTML = value;
            tr.append(td)
        })
    })
}

let getUsers = async function() {
    let users = await post('user_manage')
        .then(resp => {
            // console.log(resp)
            return resp
        })
        .catch(err => {
            // console.log(err)
            return err
        })

    fillTable('#user_list', users)
}

const configuration = {
    "stateSave": false,
    "order": [[2, "asc"]],
    "pagingType": "simple_numbers",
    "searching": true,
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tous"]],
    "language": {
        "info": "Utilisateurs _START_ à _END_ sur _TOTAL_ sélectionnées",
        "emptyTable": "Aucun utilisateur",
        "lengthMenu": "_MENU_ Utilisateurs par page",
        "search": "Rechercher : ",
        "zeroRecords": "Aucun résultat de recherche",
        "paginate": {
            "previous": "Précédent",
            "next": "Suivant"
        },
        "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoEmpty": "Utilisateurs 0 à 0 sur 0 sélectionnée",
    },
    "columns": [
        {// UID
            // "data": "id",
            "orderable": false,
            "visible": false
        },
        {// BENEFICIARY
            // "data": "beneficiary",
            "orderable": true
        },
        {// LASTNAME
            // "data": "lastname",
            "orderable": false
        },
        {// FIRSTNAME
            // "data": "firstname",
            "orderable": true
        },
        {// EMAIL
            // "data": "email",
            "orderable": false,
            "visible": false
        },
        {// PHONE
            // "data": "phone",
            "orderable": false,
            "visible": false
        }
    ],
    'retrieve': true
};

$(document).ready(function () {
    getUsers();
    $('#user_list').DataTable(configuration);
})