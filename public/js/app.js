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

/**
 * --------------------------------------------------------------
 * REQUEST
 * --------------------------------------------------------------
 */

/**
 * XHR POST Request
 *
 * @param url
 * @param parameters
 * @param file
 * @return {*}
 */
let post = function (url, parameters, file = false) {

    if(!parameters) return false;

    request =  
    file ? 
    $.ajax({
        url: url,
        data: parameters,
        type: 'POST'
    })
        :
    $.ajax({
        url: url,
        data: parameters,
        type: 'POST',
        processData: file,
        contentType: file
    })    

    return request;
};

/**
 * XHR GET Request
 *
 * @param url
 * @param parameters
 * @param file
 * @return {*}
 */
let get = async function (url, parameters, file = false) {
    return $.ajax({
        url: url,
        data: parameters,
        type: 'GET',
        processData: file,
        contentType: file,
    });
};

/**
 * --------------------------------------------------------------
 * TABLES
 * --------------------------------------------------------------
 */

/**
 * Construct Table
 * @param {Array} fields Fieldsnames
 * @param {Array} data Data for fieldnames
 * @param {Array} actions Actions buttons
 */
let constructTable = function(fields, data, actions = 0) {
    let table = "";

    /**
     * Construct table header
     */
    table += '<thead class="thead-white">';
    table += "<tr>";
    // Loop fields inside table header
    fields.forEach(function(field) {
        if (field.show) {
            table += '<th> ' + field.name + '</th>';
        }
    });

    table += "</tr>";
    table += "</thead>";

    /**
     * Construct table body
     */
    table += "<tbody>";
    data.forEach(function(row) {
        table += "<tr>";

        /**
         * Data
         */
        var i = 0;
        for(key in row)
        {
            if (fields[i]['show']) {
                table += "<td>"+ row[key] + "</td>"
            }
            i++;
        }


        // transform object to array
        let rowToArray = Object.values(row);

        if (actions instanceof jQuery) // IF: "actions" is a instance of jQuery
        {
            actions.children().each( function(action) {
                $(this).attr('data-id', rowToArray[0]);
                table += this.outerHTML;
            });
        }
        else // ELSE: It's a simple JS array
        {
            actions.forEach(action => {
                // inject user ID into span
                btnTargeted = [action.slice(0, 5), ' data-id="' + rowToArray[0] + '" ', action.slice(5)].join('');
                table += btnTargeted;
            });
        }

        table += "</td>"
        table += "</tr>";
    });

    table += "</tbody>";

    return table;
}

/**
 * Construct config
 * @param {Array} fields Fields list
 * @param {Array} order Wich field order on
 * @param {String} name Name of data inside table
 * @return {Object}
 */
let constructConfig = function(fields, order = [0, "asc"], name = "unknow") {
    let config = {
        "stateSave": false,
        "order": [order],
        "pagingType": "simple_numbers",
        "searching": true,
        "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "Tous"]],
        "language": {
            "info": "" + name + " _START_ à _END_ sur _TOTAL_ sélectionnées",
            "emptyTable": "Aucun " + name + "",
            "lengthMenu": "_MENU_ " + name + " par page",
            "search": "<i class='fas fa-search'></i>",
            "zeroRecords": "Aucun résultat de recherche",
            "paginate": {
                "previous": "Précédent",
                "next": "Suivant"
            },
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoEmpty":      "" + name + " 0 à 0 sur 0 sélectionnée",
        },
        "columns": [],
        'retrieve': true,
        "responsive": true,
        "autoWidth": false
    }

    // Edit fields settings
    if (fields)
    {
        fields.forEach(field => {
            if (field.show)
            {
                let jsonString = '{ "orderable": ' + field['orderable'] + ' }';
                config.columns.push( JSON.parse(jsonString) );
            }
        });
    }
    return config;
}

/**
 * --------------------------------------------------------------
 * IZZY TOAST
 * --------------------------------------------------------------
 */


/**
 * Construct Toast
 * @param {int} code XHR status Code
 * @param {string} message Specific success message
 */
function statusCodeToast(code, message) {
    switch (code) {
        case 204:
            errorIzyToast('Oups...', 'Veuillez remplir tous les champs du formulaire !');
            break;
        case 200:
            successIzyToast('C\'est noté !', message);
            break;
        case 400:
            errorIzyToast('Oups...', 'Une erreur est survenue, veuillez reéssayer.');
            break;                 
        case 500:
            errorIzyToast('Oups...', 'Une erreur est survenue, veuillez contacter le support technique d\'AfpaConnect.');
        break;    
        default:
            break;
    }
}

/**
 * Error Toast
 * @param {string} errTitle title
 * @param {string} errContent message
 */
function errorIzyToast(errTitle, errContent) {
    iziToast.show({
        backgroundColor: '#FF7F7F ',
        timeout: 5000,
        position: 'topRight',
        title: errTitle,
        message: errContent,
        buttons: [
        ['<button>Fermer</button>', function (instance, toast) {
            instance.hide({
                transitionOut: 'fadeOutUp',
            }, toast, 'buttonName');
        }]],
    });
}

/**
 * Success Toast
 * @param {string} succTitle title
 * @param {string} succContent message
 */
function successIzyToast(succTitle, succContent) {
    iziToast.show({
        timeout: 4000,
        backgroundColor: '#90EE90',
        position: 'topRight',
        title: succTitle,
        message: succContent + " Patientez quelques secondes avant le rafraîchissement de la page", 
        buttons: [
            
            ['<button>Rafraichir maintenant</button>', function (instance, toast) {
                instance.hide({
                    transitionOut: 'fadeOutUp',
                    onClosing: function(instance, toast, closedBy){
                        location.reload() 
                    }
                }, toast, 'buttonName');
            }]
        ],
    });

    setTimeout(function(){ location.reload() }, 4000)
}

/**
 * --------------------------------------------------------------
 * MENU HEADER
 * --------------------------------------------------------------
 */


 function mobileMenuHeader() {
     
    $("#navbar").toggleClass("responsive");
    $("#menuIcon").toggleClass('fa-times').toggleClass('fa-bars');

  }

 