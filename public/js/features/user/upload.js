let data = []

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
})

$('#upload_file').change( (e) => {
    e.preventDefault();
    let fileobj = $('#upload_file')[0].files[0]
    ajax_file_upload(fileobj);
});

$('body').on('click', '#btn-upload', (e) => {
    insert_user_bdd()
});

let upload_file = (e)=>  {
    e.preventDefault();
    fileobj = e.dataTransfer.files[0];
    ajax_file_upload(fileobj);
}

let insert_user_bdd = async () => {
    let fd = new FormData();
    fd.append('uploaded_user', JSON.stringify(data))
    fd.append('center' , $('#center').val())

    await post("user-add",fd,false)
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

let ajax_file_upload = async (fileobj) => {
    let fd = new FormData();
    fd.append("fileToUpload", fileobj)
    
    await post("users-uploaded",fd,false)
    .then( (resp)=> {
        let content = resp.content

        let dataHTML = "<table class='table-upload'>"

        $.each(content,(index,row) => {

            index !== 0 ? data[index-1] = {} : false
            dataHTML += "<tr>"
            
            $.each(row,(i,el) => {
                index !== 0 ? data[index-1][content[0][i].replaceAll(' ', '_').toLowerCase()] = el : false
                dataHTML += "<td>"+el+"</td>"
            })
            dataHTML += "</tr>"
            index !== 0 && JSON.stringify(data[index-1])
        });
        dataHTML += "</table>"
            
        $('#upload_confirm').html(dataHTML).append("<button id='btn-upload' class='btn-upload btn btn-secondary'>Valider</button>")       
        
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
