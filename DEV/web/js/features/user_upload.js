
let data = []

$('.select').change( () => {
    $( ".select" ).val() != "null" ? $(".drop_file_zone").show() : $(".drop_file_zone").hide()
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

    await post("api/user/add",fd,false)
        .then((response) => {
            $('#alert')
                .addClass('alert-success')
                .removeClass('alert-danger')
                .html(response)
                .show();

            $('html,body').animate({scrollTop: 0}, 'slow');
        })
        .catch((error) => {
            $('#alert')
                .addClass('alert-danger')
                .removeClass('alert-success')
                .html(error.responseJSON)
                .show();

            $('html,body').animate({scrollTop: 0}, 'slow');
        })
}

let ajax_file_upload = async (fileobj) => {
    let fd = new FormData();
    fd.append("fileToUpload", fileobj)

    await post("api/user/upload",fd,false)
    .then( (resp)=> {
        
        let parsedData = JSON.parse(resp)
        let dataHTML = "<table class='table-upload'>"

        $.each(parsedData,(index,row) => {

            index != 0 ? data[index-1] = {} : false
            dataHTML += "<tr>"
            
            $.each(row,(i,el) => {
                index != 0 ? data[index-1][parsedData[0][i].replaceAll(' ', '_')] = el : false
                dataHTML += "<td>"+el+"</td>"
            })

            dataHTML += "</tr>"
            index != 0 ? JSON.stringify(data[index-1]) : false
        });
        console.log(data)
        dataHTML += "</table>"
            
        $('#upload_confirm').html(dataHTML).append("<button id='btn-upload' class='btn-upload btn btn-secondary'>Valider</button>")
    
    })
    .catch((err) => {
        console.log(err)
        $('#error').html("Un problème est survenu lors de l'upload du fichier").show()
    })

}
