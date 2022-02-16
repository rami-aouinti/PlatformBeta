function addNewPost() {
    let url = `/new/post`
    let donnees = {
        "title": document.getElementById("myFormPost").elements["title"].value,
        "content": document.getElementById("myFormPost").elements["content"].value,
        "image": document.getElementById("exampleInputFile").value
    }
    let xhr = new XMLHttpRequest
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = xhr.responseText;
            var data = JSON.parse(response);
            var post = data['data'];
            console.log(post.user);
            $( "#post" )
                .append( '<div class="card card-frame"><div class="card-header d-flex">' +
                    '<p class="font-weight-normal my-auto">'  + '</p>' +
                    '<i class="material-icons position-relative ms-auto text-lg me-1 my-auto">date</i>' +
                    '<p class="text-sm my-auto"> Now</p></div>' +
                    '<div class="card-body">' +
                    '<h5>' + post.title + '</h5><p>' + post.content+ '</p></div>' +
                    '<div class="card-footer">' +
                    '<form>' +
                    '<div class="input-group input-group-outline mb-4">' +
                    '<label class="form-label">Comment</label>' +
                    '<input type="text" class="form-control">' +
                    '</div></form></div></div><br>' );
        }
        else {
            successSwal('Not Saved Bro')
        }
    };
    xhr.open("POST", url)
    xhr.send(JSON.stringify(donnees))
    $('#modal-form-post').modal('toggle');
}
