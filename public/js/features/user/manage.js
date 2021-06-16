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
    { "name": "UID", "orderable": true, "show": true },
    { "name": "ID Centre", "orderable": false, "show": false },
    { "name": "ID Financeur", "orderable": false, "show": false },
    { "name": "N° de matricule", "orderable": true, "show": true },
    { "name": "Nom", "orderable": true, "show": true },
    { "name": "Prénom", "orderable": true, "show": true },
    { "name": "Mail pro", "orderable": false, "show": false },
    { "name": "Mail perso", "orderable": false, "show": false },
    { "name": "Portable", "orderable": false, "show": false },
    { "name": "Adresse", "orderable": false, "show": false },
    { "name": "Complément adresse", "orderable": false, "show": false },
    { "name": "Code postal", "orderable": false, "show": false },
    { "name": "Ville", "orderable": false, "show": false },
    { "name": "Pays", "orderable": false, "show": false },
    { "name": "Sexe", "orderable": false, "show": false },
    { "name": "Status", "orderable": true, "show": true },
    { "name": "Enregistré le", "orderable": false, "show": false },
    { "name": "Modifié le", "orderable": false, "show": false },
];

let users = [];

$(document).ready( async ()=> {
    await get("api/centers",false)
        .then( (centers)=> {
            centers = centers.content;
            centers.forEach(center => {
                let el = document.createElement("option");
                el.textContent = center.name;
                el.value = center.id;
                el.selected = $("#id_user_center").val() === el.value
                $('#center').append(el);
            });

        })
        .catch((err) => {
            console.log(err)
            $('#error').html("Un problème est survenu lors du chargement des centres").show()
        })

    await get("api/financials",false)
        .then( (financials)=> {
            console.log(financials)
            financials = financials.content;
            financials.forEach(financial => {
                let el = document.createElement("option");
                el.textContent = financial.name;
                el.value = financial.id;
                el.selected = $("#id_user_financial").val() === el.value
                $('#financial').append(el);
            });

        })
        .catch((err) => {
            console.log(err)
            $('#error').html("Un problème est survenu lors du chargement des centres").show()
        })
})


/**
 * Get users from API and fill table with.
 */
axios.get('api/users')
    .then(resp => {
        $(document).ready(() => {
            users = resp.data.content;
            console.log(users)

            let htmlTable = constructTable(tableFields, resp.data.content, $('#user_list'));

            let configuration = constructConfig(tableFields, [0, "asc"], "utilisateur");

            $('#user_list')
                .html(htmlTable)
                .DataTable(configuration);

            $('#user_list tr').on('click', (e) => {
                userUpdated = users.find(user => user.id === parseInt(e.currentTarget.firstChild.innerHTML));
                
                fillUserManager(userUpdated);            
            });

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
let fillUserManager = function (user) {
    console.log(user);
    let uManagerBox = $('.u_managment');
    let uManagerBoxForm = $('.u_managment__form');

    // Show user managment form
    uManagerBox.show(150);

    // Fill user basic informations
    $('.u_managment__form').find('#uid').val(user['id'])
    $('.u_managment__form').find('#beneficiary').val(user['identifier'])
    $('.u_managment__form').find('#lastname').val(user['lastname'])
    $('.u_managment__form').find('#firstname').val(user['firstname'])
    $('.u_managment__form').find('#email').val(user['mailPerso'])
    $('.u_managment__form').find('#phone').val(user['phone'])
    $('.u_managment__form').find('#financial').val(user['financial_id'])
    $('.u_managment__form').find('#center').val(user['center_id'])


    // Listen form submiting
    uManagerBoxForm.on('submit', (event) => {
        $('.u_managment__form').find('#uid').attr('disabled', false);
    })
}
