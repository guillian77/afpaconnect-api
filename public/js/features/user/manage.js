/**
 * USER MANAGE JAVASCRIPT
 *
 * @package AfpaConnect Project
 * @subpackage javascript
 * @author Aufrère Guillian - Campillo Lucas - Moreaux Eloïse
 */

import {post} from "../../ajax";
import {constructTable, constructConfig} from "../../table";
import {display} from "../../message";
import {Api} from "../../Api";
import {Select} from "../../Select";
import {User} from "../../User";

const api = new Api();
const select = new Select();

/**
 * Define table header fields.
 * @type {({orderable: boolean, name: string, show: boolean}|{orderable: boolean, name: string, show: boolean}|{orderable: boolean, name: string, show: boolean}|{orderable: boolean, name: string, show: boolean}|{orderable: boolean, name: string, show: boolean})[]}
 */
let tableFields = [
    { "name": "ID", "orderable": true, "show": true },
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
    { "name": "Type", "orderable": true, "show": true },
    { "name": "Enregistré le", "orderable": false, "show": false },
    { "name": "Modifié le", "orderable": false, "show": false },
    { "name": "Roles", "orderable": false, "show": false },
];

let users = [];
let centers = null;
let financials = null;

/**
 * Get centers, financials and user roles from API and fill table with.
 */
$(document).ready( async () => {
    buildTable();
})

/**
 * Build DataTable table from users.
 */
let buildTable = function ()
{
    api.getUsers()
        .then(usersFromApi => {
            users = usersFromApi;

            let userListElement = $('#user_list');
                userListElement.html('');

            let htmlTable = constructTable(tableFields, usersFromApi, userListElement);

            let configuration = constructConfig(
                tableFields,
                [0, "asc"],
                "utilisateur"
            );

            let dataTable = userListElement
                .html(htmlTable)
                .DataTable(configuration)
                .on('draw', () => {
                    listenUserRows();
                });

            dataTable.draw();

        })
        .catch(error => {
            console.error(error)
            let alert = document.createElement('div')
                alert.classList.add('alert');
                alert.classList.add('alert-danger');
                alert.innerHTML = JSON.parse(error.responseText)
            $('.action-buttons').before(alert)
        });
}

/**
 * Load edit form data from API.
 */
let loadEditFormData = async function ()
{
    /*
     * Load centers.
     */
    select
        .setTarget($('#center'))
        .setSelected($("#id_user_center").val());

    if (!centers) {
        centers = await api.getCenters()
            .then(centers => {
                select.addOptions(centers);
                return centers;
            })
            .catch((err) => {
                console.log(err)
                $('#error')
                    .html("Un problème est survenu lors du chargement des centrers.")
                    .show()
            });
    }

    /*
     * Load financials.
     */
    select
        .setTarget($('#financial'))
        .setSelected($("#id_user_financial").val());

    if (!financials) {
        financials = await api.getFinancials()
            .then(financials => {
                select.addOptions(financials);
                return financials;

            })
            .catch((err) => {
                console.log(err)
                $('#error').html("Un problème est survenu lors du chargement des financeurs").show()
            });
    }

    /*
     * Get Roles availables for any apps.
     */
    await api.getAppsRoles()
        .then(apps => {
            let appsRolesElement = $('#app_roles');

            // Reset HTML before.
            appsRolesElement.html('');

            // For any apps.
            for (const [key, app] of Object.entries(apps)) {
                // Create an app field.
                let app_field = document.createElement("div");
                    app_field.setAttribute('class','form__field form_field_app' );
                    app_field.id = "app_roles_"+app['id'];
                    app_field.dataset.id = app['id'];
                appsRolesElement.append(app_field);

                // Create an app label.
                let app_field_label = document.createElement("label");
                    app_field_label.innerHTML = app['name'];
                    app_field_label.className = "app_field";
                    app_field.append(app_field_label);

                // Append app roles inside app field.
                app['app_roles'].forEach(role => {
                    let app_field_option =  document.createElement("div");

                    let app_field_option_label = document.createElement("label");
                    app_field_option_label.setAttribute('for', 'app' + app['id'] +'_field_options' + role.id);
                    app_field_option_label.innerHTML = role.name

                    let inputElement = document.createElement("input");
                    inputElement.type = 'checkbox';
                    inputElement.id = 'app_'+ app['id'] +'field_options' + role.id;
                    inputElement.name = 'app_role_' +app['id'] + '[]';
                    inputElement.value = role.id;

                    app_field_option.append(inputElement);
                    app_field_option.append(app_field_option_label);
                    app_field.append(app_field_option);
                });
            }
        })
        .catch((err) => {
            console.log(err)
            $('#error').html("Un problème est survenu lors du chargement des roles.").show()
        });
}

/**
 * Add listener on every user row.
 */
let listenUserRows = function ()
{
    let rows = document.querySelectorAll('#user_list tr');

    rows.forEach(row => {
        // Get row listener.
        let rowListener = row.getAttribute('listener');

        // Check if there is not a listener yet.
        if (!rowListener) {
            row.addEventListener('click', event => {
                let userId = +event.currentTarget.firstChild.innerHTML;
                let userUpdated = users.find(user => user.id === userId);

                loadEditFormData()
                    .then(() => {
                        fillUserManager(userUpdated);
                    });
            });
        }
    });
}

/**
 * Fill user edition section and await form submission.
 *
 * @param userToUpdate
 */
let fillUserManager = function (userToUpdate) {
    let user = new User(userToUpdate);
    let userAppsRoles = user.getRoles();

    let userManageElement = $('.u_managment');
    let editFormElement = $('#user_edit_form');
    let submitElement = editFormElement.find('.form__submit');

    // Show user managment form
    userManageElement.show(150);

    let idElement = editFormElement.find('#id');
    let beneficiaryElement = editFormElement.find('#beneficiary');
    let lastnameElement = editFormElement.find('#lastname');
    let firstnameElement = editFormElement.find('#firstname');
    let emailElement = editFormElement.find('#email');
    let phoneElement = editFormElement.find('#phone');
    let centerElement = editFormElement.find('#center');
    let addressElement = editFormElement.find('#address');
    let complementAddressElement = editFormElement.find('#complementAddress');
    let zipElement = editFormElement.find('#zip');
    let cityElement = editFormElement.find('#city');
    let countryElement = editFormElement.find('#country');
    let genderElement = editFormElement.find('#gender');

    idElement.val(user.getId());
    beneficiaryElement.val(user.getIdentifier());
    lastnameElement.val(user.getLastname());
    firstnameElement.val(user.getFirstname());
    emailElement.val(user.getMail2());
    phoneElement.val(user.getPhone());
    centerElement.val(user.getCenter_id());
    addressElement.val(user.getAddress());
    complementAddressElement.val(user.getComplementAddress());
    zipElement.val(user.getZip());
    cityElement.val(user.getCity());
    countryElement.val(user.getCountry());
    genderElement.val(user.getGender());

    firstnameElement.focusout(() => {
        if (firstnameElement.val().length < 2 || firstnameElement.val().length > 255) {
            firstnameElement
                .addClass('error')
                .prop('title', 'Le prénom doit-être compris entre 2 et 255 caractères.')
            submitElement.attr('disabled', true);
        } else {
            firstnameElement.removeClass('error');
            submitElement.attr('disabled', false);
        }
    });

    // Fill user roles on any apps.
    userAppsRoles.forEach(role => {
        let roleId = role.id;
        let appId = role.pivot.app_id;

        let target = $('#app_roles_'+appId)
            .find('input[value="' + roleId + '"]');
        target.prop('checked', true)
    });

    // Listen for form submitting.
    editFormElement.submit(event => {
        event.preventDefault();

        // Enable user ID.
        editFormElement
            .find('#id')
            .attr('disabled', false);

        postUser(editFormElement, userManageElement)
            .then(() => {
                buildTable();
            })
    });
}

/**
 * Send updated user to API.
 *
 * @param {Object, jQuery} form The user form.
 * @param {jQuery} manageBox The edit section.
 */
let postUser = async function (form, manageBox)
{
    let userSerialized = form.serialize();
    let username = $("#firstname").val()+ " " + $("#lastname").val();

    await post('/user-edit', userSerialized)
        .then((resp, statusMessage, header) => {
            display('Succès', "L'utilisateur " + username + " a bien été mis à jour.");
        })
        .catch((error)=> {
            console.error(error);
            display('Erreur', "Impossible de mettre à jour l'utilisateur " + username);
        })
        .done(()=> {
            manageBox.hide();
        });
}
