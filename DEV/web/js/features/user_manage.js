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
];

/**
 * Get users from API and fill table with.
 */
get('api/users')
    .then(users => {
        $(document).ready(() => {

            let htmlTable = constructTable(tableFields, users, $('#user_manage_actions'));

            let configuration = constructConfig(tableFields, [0, "asc"], "utilisateur");

            
            let table = $('#user_list')
                .html(htmlTable)
                .DataTable(configuration);

            $('#user_list tbody').on( 'click', 'tr', function() {
               fillUserManager(table.row(this).data()[0]);
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
 * @param userId
 */
let fillUserManager = function(userId) {
    let uManagerBox = $('.u_managment');
    let uManagerBoxForm = $('.u_managment__form');

    get('api/user?id='+userId)
    .then(data => {
        
        let user = data[0];

        // Fill user basic informations
        $('.u_managment__form').find('#uid').val(user['id_user'])
        $('.u_managment__form').find('#beneficiary').val(user['user_identifier'])
        $('.u_managment__form').find('#lastname').val(user['user_name'])
        $('.u_managment__form').find('#firstname').val(user['user_firstName'])
        $('.u_managment__form').find('#email').val(user['user_mailPerso'])
        $('.u_managment__form').find('#phone').val(user['user_phone'])
   
        fillRoleAppManager(userId);
        }     
    )
    .catch(err => {
        console.log(err)
    })

    // Show user managment form
    uManagerBox.show(150);

    // Listen form submiting
    uManagerBoxForm.on('submit', event => {
        event.preventDefault();
       
        let fd = new FormData();

        data = $('#u_managment__form').serializeArray();
        data.push({name: 'id', value: $('.u_managment__form').find('#uid').val()});
        fd.append('updated_user', JSON.stringify(data))
    // Fill user basic informations
        post("api/user/update",fd )
        .then(data => {
            //Fill applications and options fields and set user's role values.
            console.log(data);
         }     
        )
        .catch(err => {
            console.log(err)
        })
        //uManagerBox.hide();
    })
}

/**
 * Gets applications, roles and user's roles informations
 *
 * @param userId
 */
function fillRoleAppManager(userId) {

    get('api/roleapp?id='+userId)
    .then(data => {
        //Fill applications and options fields and set user's role values.
        fillApplicationsFields(data);
     }     
    )
    .catch(err => {
        console.log(err)
    })

 }

 /**
 * Fill user role edition section.
 *
 * @param data - Server Response divided in 3 parts : "apps", "roles", "user_roles"
 */
function fillApplicationsFields(data) {
   
    $(".applications").empty();
        
            data.apps.forEach(application => {  
            
            $(".applications").append(
            "<div class=\"form__field\"><label for=\"app_ticket\">"
             + application.app_name 
             + "</label> <select name=\"app_"+ application.id_application 
             + "\" id=" + application.id_application + "></select></div>")

             //fill Option fields
             fillOptionsField(data, application);

        });
}

/**
 * Fill user role edition section.
 *
 * @param data - Server Response 
 * @param application - Current Application which to apply options fields
 */
function fillOptionsField(data, application) {

             //Create None Option
             $("#" + application.id_application).append( 
                "<option id=\"none\" name=\"none\" value=\"0\">Aucun</option>")

            data.roles.forEach(role=> {

                // Assigns roles option for each application
                if (role.id_application == application.id_application) {
            
                    $("#" + application.id_application ).append( 
                        "<option id=" + role.role_name + "_"+ application.id_application  +
                        " name=" + role.role_name +  
                        " value=" + role.id_role +">"+role.role_name+"</option>");
                
                    //Assigns selected attribute to user's role 
                    assignUserRole(data, role, application);
                    
                }

            }); 
                  
}

/**
 * Fill user role edition section.
 *
 * @param data - Server Response 
 * @param application - Current Application to apply options fields
 * @param role - Role that will be check / add "selected" attribute if matches
 */
function assignUserRole(data, role, application) {

     //Assigns selected attribute to user's role    
     data.user_roles.forEach(user=> {
    
        if (user.id_role == role.id_role && user.id_application == application.id_application) {                            
            $("#"+ role.role_name + "_"+ application.id_application).attr("selected","selected")
        } 
    
    })

}