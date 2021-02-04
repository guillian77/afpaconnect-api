
let data = []

$('.select').change( () => {
    $( ".select" ).val() != "null" ? $(".drop_file_zone").show() : $(".drop_file_zone").hide()
})

$('#upload_file').change( (e) => {
    e.preventDefault();
    let fileobj = $('#upload_file')[0].files[0]
    ajax_file_upload(fileobj);
});

let upload_file = async (e)=>  {
    e.preventDefault();
    fileobj = e.dataTransfer.files[0];
    ajax_file_upload(fileobj);
}

let ajax_file_upload = async (fileobj) => {
    let fd = new FormData();
    fd.append("fileToUpload", fileobj)
    fd.append('center' , $('#center').val())
    post("user_upload_action",fd,(resp)=>{
        let parsedData = JSON.parse(resp)
        let dataHTML = "<table class='table-upload'>"

        $.each(parsedData,(index,row) => {
            data[index] = row
            dataHTML += "<tr>"
            $.each(row,(i,el) => {
                dataHTML += "<td>"+el+"</td>"
            })
            dataHTML += "</tr>"
        });

        dataHTML += "</table>"
            
        $('#upload_confirm').html(dataHTML).append("<button id='btn-upload' class='btn-upload btn btn-secondary'>Valider</button>")
    },true)
}


