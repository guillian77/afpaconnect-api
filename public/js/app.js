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


import {add, displayMessages} from "./message";

$(document).ready( () => {

    displayMessages();

    $("#responsiveMenu").on('click', () => {
        $("#navbar").toggleClass("responsive");
        $("#menuIcon").toggleClass('fa-times').toggleClass('fa-bars');
    })

}
)

