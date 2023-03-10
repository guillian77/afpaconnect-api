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
export let constructTable = function(fields, data, actions = 0) {
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
        for(let key in row)
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
export let constructConfig = function(fields, order = [0, "asc"], name = "unknow") {
    let config = {
        "stateSave": false,
        "order": [order],
        "pagingType": "simple_numbers",
        "searching": true,
        "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "Tous"]],
        "language": {
            "info": "" + name + " _START_ ?? _END_ sur _TOTAL_ s??lectionn??es",
            "emptyTable": "Aucun " + name + "",
            "lengthMenu": "_MENU_ " + name + " par page",
            "search": "<i class='fas fa-search'></i>",
            "zeroRecords": "Aucun r??sultat de recherche",
            "paginate": {
                "previous": "Pr??c??dent",
                "next": "Suivant"
            },
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoEmpty":      "" + name + " 0 ?? 0 sur 0 s??lectionn??e",
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