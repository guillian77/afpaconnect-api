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

console.log('test');

let users = [
    {id: 15, beneficiary: "4616545748", lastname: "Campillo", firstname: "Lucas", email: "test@test.fr", phone: "0615171309"},
    {id: 16, beneficiary: "4616545748", lastname: "Aufrère", firstname: "Guillian", email: "test@test.fr", phone: "0615171309"},
    {id: 17, beneficiary: "4616545748", lastname: "Melheb", firstname: "Younes", email: "test@test.fr", phone: "0615171309"},
    {id: 18, beneficiary: "4616545748", lastname: "Doe", firstname: "John", email: "test@test.fr", phone: "0615171309"},
    {id: 19, beneficiary: "4616545748", lastname: "Patrick", firstname: "Jean", email: "test@test.fr", phone: "0615171309"},
    {id: 20, beneficiary: "4616545748", lastname: "Robert", firstname: "Potiron", email: "test@test.fr", phone: "0615171309"},
    {id: 21, beneficiary: "4616545748", lastname: "Robert", firstname: "Potiron", email: "test@test.fr", phone: "0615171309"},
    {id: 22, beneficiary: "4616545748", lastname: "Robert", firstname: "Potiron", email: "test@test.fr", phone: "0615171309"},
    {id: 23, beneficiary: "4616545748", lastname: "Robert", firstname: "Potiron", email: "test@test.fr", phone: "0615171309"},
];

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

/**
 * Fill HTML table with associative array of data
 * @param {*} table Table element selector
 * @param {*} data  Data
 */
let fillTable = function(table, data)
{
    let tableBody = $(table + ' tbody');
    data.forEach((user, i) => {
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
    });
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
            "orderable": false,
            "visible": false
        },
        {// BENEFICIARY
            "orderable": true
        },
        {// FIRSTNAME
            "orderable": true
        },
        {// LASTNAME
            "orderable": false
        },
        {// EMAIL
            "orderable": false,
            "visible": false
        },
        {// PHONE
            "orderable": false,
            "visible": false
        }
    ],
    'retrieve': true
};

$(document).ready(function() {
    fillTable('#user_list', users);
    $('#user_list').DataTable(configuration);
})