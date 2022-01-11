import {get, post} from "../../ajax";
import {constructBodyMessage} from "../../message";

let data = []
let addFormationForm = $('#showAdd')
let selectFormation = $('#formation')

$(document).ready( async ()=> {
    /*
     * Get centers.
     */
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

    /*
     * Get formations.
     */
    await get("api/formations",false)
        .then( (formations)=> {
            formations = formations.content;
            formations.forEach(formation => {
                let el = document.createElement("option");
                el.textContent = formation.name;
                el.value = formation.id;
                el.selected = $("#id_user_formation").val() === el.value
                selectFormation.append(el);
            });

        })
        .catch((err) => {
            $('#error').html("Un problème est survenu lors du chargement des formations").show()
        })
})

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
            
        $('#upload_confirm').html(dataHTML).after("<button id='btn-upload' class='btn-upload btn btn-secondary'>Valider</button>")
        
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
