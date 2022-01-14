import {get, post} from "../../ajax";
import {Api} from "../../Api";

let api = new Api();

let data = []
let addFormationForm = $('#showAdd')
let selectFormation = $('#formation')

$(document).ready( async () => {
    /*
     * Fill select with options came from API.
     */
    await api.getCenters()
        .then(centers => {
            fillSelectOptions('center', centers);
        });
    await api.getFormations()
        .then(formations => {
            fillSelectOptions('formation', formations);
        });
});

/*
 * ---------------------------------------------------------------
 * LISTENERS
 * ---------------------------------------------------------------
 */
$('#upload_file').change( (e) => {
    e.preventDefault();
    let fileobj = $('#upload_file')[0].files[0]
    ajaxFileUpload(fileobj);
});

$('body').on('click', '#btn-upload', (e) => {
    insertUserInBdd()
});

$('body').on('click', '#showAdd', (e) => {
    e.preventDefault()
    $('#addForm').toggle()
    addFormationForm.html() === "+" ? addFormationForm.html('-') : addFormationForm.html('+')
});

$('body').on('click', '#addFormation', (e) => {
    e.preventDefault()
    let nameFormation = $('#nameFormation')
    $('#addForm').toggle()
    addFormationForm.html() === "+" ? addFormationForm.html('-') : addFormationForm.html('+')
    let el = document.createElement("option");
    el.textContent = nameFormation.val();
    el.dataset.tag = $('#tagFormation').val();
    selectFormation.append(el)
    selectFormation.val(nameFormation.val())
});

$('.drop_file_zone').on('drop', event => {
    event.preventDefault();
    uploadFile(event.originalEvent);
});

/*
 * ---------------------------------------------------------------
 * FUNCTIONS
 * ---------------------------------------------------------------
 */
/**
 * Fill HTML select element with options.
 *
 * @param {String} target Target HTML select element.
 * @param {Array, Object} items Data to fill with.
 */
let fillSelectOptions = function (target, items)
{
    items.map((value, index) => {
        let selectToFill = $('#'+target);
        let selected = $('#id_user_'+target);

        let option = document.createElement("option");
        option.textContent = value.name;
        option.value = value.id;
        option.selected = selected.val() === option.value;
        selectToFill.append(option);
    });
}

/**
 * Create HTML select element from teacher list.
 */
let getOwnerSelect = function ()
{
    // Initialize HTML select element.
    let ownerSelect = document.createElement('select');
        ownerSelect.setAttribute('id', 'owner');

    // Create a function to make any options.
    let createOption = function (value, content) {
        let option = document.createElement("option");
            option.textContent = content;
            option.setAttribute('class', 'select')
            // option.classList.add('select')
            option.value = value;

        return option;
    }

    // Create an empty option.
    ownerSelect.append(createOption('-1', 'Aucun'));

    // Create HTML option element for any teachers.
    api.getTeachers()
        .then(teachers => {
            teachers.map(teacher => {
                let option = createOption(
                    teacher.id,
                    teacher.lastname + " " + teacher.firstname
                );
                ownerSelect.append(option);
            })
        });

    return ownerSelect;
}

/**
 * Upload a file.
 *
 * @param {Event} event Drop event.
 */
let uploadFile = (event)=>  {
    event.preventDefault();
    let fileObject = event.dataTransfer.files[0];
    ajaxFileUpload(fileObject);
}

/**
 * Send user to app to be saved inside DB.
 *
 * @returns {Promise<void>}
 */
let insertUserInBdd = async () => {

    let fd = new FormData();
    let formation = $('#formation option:selected')

    fd.append('uploaded_user', JSON.stringify(data))
    fd.append('center' , $('#center').val())
    fd.append('formation' , formation.val())
    fd.append('owner' , $('#owner').val())

    if (formation.data().length !== 0) {
        fd.append('formation_tag' , formation.data().tag)
    }

    await post("user-add",fd,true)
        .then((response) => {
            $('#alert')
                .addClass('alert-success')
                .removeClass('alert-danger')
                .html(response.message)
                .show();

            $('html,body').animate({scrollTop: 0}, 'slow');
        })
        .catch((error) => {
            $('#alert')
                .addClass('alert-danger')
                .removeClass('alert-success')
                .html(error.responseJSON.message)
                .show();

            $('html,body').animate({scrollTop: 0}, 'slow');
        })
}

/**
 * Upload file with POST AJAX method.
 *
 * @param {File} fileObject File contain user list.
 *
 * @returns {Promise<void>}
 */
let ajaxFileUpload = async (fileObject) => {
    let fd = new FormData();
    fd.append("fileToUpload", fileObject)
    
    await post("users-uploaded",fd,true)
    .then( (resp)=> {
        let content = resp.content

        let dataHTML = "<table class='table-upload'>"

        $.each(content,(index,row) => {

            index !== 0 ? data[index-1] = {} : false
            dataHTML += "<tr>"
            
            $.each(row,(i,el) => {
                let formatedContent = content[0][i]
                    .replaceAll('°', '')
                    .replaceAll("l'", "")
                    .replaceAll('é', 'e')
                    .replaceAll(' ', '_')
                    .toLowerCase()
                index !== 0 ? data[index-1][formatedContent] = el : false
                dataHTML += "<td>"+el+"</td>"
            })
            dataHTML += "</tr>"
            index !== 0 && JSON.stringify(data[index-1])
        });
        dataHTML += "</table>"
            
        $('#upload_confirm')
            .html(dataHTML)
            .after(getOwnerSelect())
            .after("<button id='btn-upload' class='btn-upload btn btn-secondary'>Valider</button>")
        
        $('#alert').hide()

    })
    .catch((error) => {
        $('#alert')
            .addClass('alert-danger')
            .removeClass('alert-success')
            .html(error.responseJSON.message)
            .show();

        $('html,body').animate({scrollTop: 0}, 'slow');
    })

}
