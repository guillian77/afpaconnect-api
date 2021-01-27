const url = "http://localhost:8000/afpaconnect/index.php";
let content = {
    app : 'ticket',
    token : 'lgrbezubujhzbf',
    payload : {
        username : "lucas.campillo@hotmail.fr",
        password : "ezfbezfbezbfhef"
    }
};

content = JSON.stringify(content);

// axios.post(url, JSON.stringify(content), {headers: {'Content-Type': 'application/json'}})
//     .then(resp => {
//         console.log(resp);
//         document.querySelector('body').innerHTML = resp.data;
//     });

$.ajax({
    // "dataType" : 'application/json',
    "contentType": "application/json",
    "type" : "POST",
    "url" :  url,
    "data" : content,
    "success" : function(resp) {
        console.log(resp)
        $('body').html(resp);
    },
    "error" : function(err) {
        // console.log(err)
        // $('body').html(err.responseText);
    }
});