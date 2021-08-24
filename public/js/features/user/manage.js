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
    { "name": "Mail1", "orderable": false, "show": false },
    { "name": "Mail2", "orderable": false, "show": false },
    { "name": "Portable", "orderable": false, "show": false },
    { "name": "Adresse", "orderable": false, "show": false },
    { "name": "Complément adresse", "orderable": false, "show": false },
    { "name": "Code postal", "orderable": false, "show": false },
    { "name": "Ville", "orderable": false, "show": false },
    { "name": "Pays", "orderable": false, "show": false },
    { "name": "Sexe", "orderable": false, "show": false },
    { "name": "Mesure", "orderable": false, "show": false },
    { "name": "Convention", "orderable": false, "show": false },
    { "name": "Status", "orderable": true, "show": true },
    { "name": "Activation Code", "orderable": false, "show": false },
    { "name": "Enregistré le", "orderable": false, "show": false },
    { "name": "Modifié le", "orderable": false, "show": false },
    { "name": "Roles", "orderable": false, "show": false },

];

let users = [];


/**
 * Get centers, financials and user roles from API and fill table with.
 */
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
            $('#error').html("Un problème est survenu lors du chargement des centres").show()
        })

    await get("api/financials",false)
        .then( (financials)=> {
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
            $('#error').html("Un problème est survenu lors du chargement des centres").show()
        })

    await get("api/apps/roles",false)
        .then( (apps)=> {

            apps = apps.content
            for (const [key, value] of Object.entries(apps)) {
   
                let app_field = document.createElement("div");
                    app_field.setAttribute('class','form__field form_field_app' )
                    app_field.id = value['id']
                $('#app_roles').append(app_field);


                let app_field_label = document.createElement("label");
                app_field_label.innerHTML = value['name'];
                app_field_label.className = "app_field";
                app_field.append(app_field_label);

                value['app_roles'].forEach(role => {

                    let app_field_option =  document.createElement("div");

                    let app_field_option_label = document.createElement("label");
                    app_field_option_label.setAttribute('for', 'app_field_options' + role.id);
                    app_field_option_label.innerHTML = role.name

                    let el = document.createElement("input");
                    el.type = 'checkbox';
                    el.id = 'app_field_options' + role.id;
                    el.name = 'app_role_' +value['id'] + '[]';
                    el.value = role.id;

                    app_field_option.append(el);
                    app_field_option.append(app_field_option_label);
                    app_field.append(app_field_option);
                });

            }
        })
        .catch((err) => {
            console.log(err)
            $('#error').html("Un problème est survenu lors du chargement des roles").show()
        })
})


/**
 * Get users from API and fill table with.
 */
axios.get('api/users')
    .then(resp => {
        $(document).ready(() => {
            users = resp.data.content;

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
    let uManagerBox = $('.u_managment');
    let uManagerBoxForm = $('.u_managment__form');
    // Show user managment form
    uManagerBox.show(150);

    // Fill user basic informations
    $('.u_managment__form').find('#uid').val(user['id'])
    $('.u_managment__form').find('#beneficiary').val(user['identifier'])
    $('.u_managment__form').find('#lastname').val(user['lastname'])
    $('.u_managment__form').find('#firstname').val(user['firstname'])
    $('.u_managment__form').find('#email').val(user['mail2'])
    $('.u_managment__form').find('#phone').val(user['phone'])
    $('.u_managment__form').find('#financial').val(user['financial_id'])
    $('.u_managment__form').find('#center').val(user['center_id'])

    $('.u_managment__form').find('#address').val(user['address'])
    $('.u_managment__form').find('#complementAddress').val(user['complementAddress'])
    $('.u_managment__form').find('#zip').val(user['zip'])
    $('.u_managment__form').find('#city').val(user['city'])
    $('.u_managment__form').find('#country').val(user['country'])
    $('.u_managment__form').find('#gender').val(user['gender'])

    $('#app_roles select').val(-1);
    //Fill user role information for each app
    $('.u_managment__form').find('#app_roles .form__field').each( (i, app) => {
        $('#' + app.id ).find('input').prop('checked', false);

        for (const [key, role] of Object.entries(user['roles'])) {
            if(role['pivot']['app_id'] == app.id) {
                console.log(role)
                console.log(app.id)
                $('#' + app.id ).find('input[value="' + role.id + '"]').prop('checked',true);
             }
        };
    });

    // Listen form submiting
    uManagerBoxForm.on('submit', (event) => {
        $('.u_managment__form').find('#uid').attr('disabled', false);
    })
}
