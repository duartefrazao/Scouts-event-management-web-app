
$('#admin-tab .nav-tabs a').click(function (e) {
    // No e.preventDefault() here
    $(this).tab('show');
});

$('#users-choice  a').click(function (e) {
    // No e.preventDefault() here
    $(this).tab('show');
});

$('#section-choice  a').click(function (e) {
    // No e.preventDefault() here
    $(this).tab('show');
});


document.querySelectorAll("#admin-content .member-face").forEach(member => { loadFaceMember(1, member);});

let registrationRequests = document.querySelectorAll(".registration_name");

registrationRequests.forEach(function(register){
    let id = register.querySelector("input").value;

    register.addEventListener('click',function (){
        sendAjaxRequest('post', '/admin/registers/' + id, {},acceptedHandler);
    });
});


function acceptedHandler(){
    let response = this.responseText;
    console.log(response)
    if(this.status == 200)
    {
        elem = document.querySelector('[data-id="' + response + '"]');
        //TO-DO cena a dizer que foi bem sucedido
        elem.parentNode.removeChild(elem);
    }else{
        elem = document.querySelector('[data-id="' + response[0] + '"]');
        let div = 'Can\'t make registrations that include childs';
        elem.append(div);
    }
}

let pending_success = document.querySelectorAll('#pending-content .list-group-item .btn-success');
let pending_danger = document.querySelectorAll('#pending-content .list-group-item .btn-danger');

pending_success.forEach(user => {
    user.addEventListener('click', function () {
        let li = user.parentNode.parentNode;
        let parent = li.parentNode;
        li.classList.add('animate');
        $("body .alert-pending-user").remove();
        $('body').append("<div class='alert alert-success alert-dismissable alert-pending-user'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> O utilizador foi aceite!</div>");
        
        setTimeout(function(){
            li.style.display = "none";
            parent.removeChild(li);

        }, 500);
    })
}); 


pending_danger.forEach(user => {
    user.addEventListener('click', function () {
        let li = user.parentNode.parentNode;
        let parent = li.parentNode;
        li.classList.add('animate');
        $("body .alert-pending-user").remove();
        $('body').append("<div class='alert alert-primary alert-dismissable alert-pending-user'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> O utilizador não foi aceite!</div>");
        
        setTimeout(function(){
            li.style.display = "none";
            parent.removeChild(li);

        }, 500);
    })
}); 


let guardians_accept = document.querySelectorAll('#guardians-content .list-group-item .btn-success');
let guardians_refuse = document.querySelectorAll('#guardians-content .list-group-item .btn-danger');

guardians_accept.forEach(user => {
    user.addEventListener('click', function () {
        let li = user.parentNode.parentNode;
        let parent = li.parentNode;
        li.classList.add('animate');
        $("body .alert-pending-user").remove();
        $('body').append("<div class='alert alert-success alert-dismissable alert-pending-user'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> A troca foi autorizada!</div>");
        
        setTimeout(function(){
            li.style.display = "none";
            parent.removeChild(li);

        }, 500);
    })
}); 


guardians_refuse.forEach(user => {
    user.addEventListener('click', function () {
        let li = user.parentNode.parentNode;
        let parent = li.parentNode;
        li.classList.add('animate');
        $("body .alert-pending-user").remove();
        $('body').append("<div class='alert alert-primary alert-dismissable alert-pending-user'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> A troca não foi autorizada!</div>");
        
        setTimeout(function(){
            li.style.display = "none";
            parent.removeChild(li);

        }, 500);
    })
}); 

let manager_delete = document.querySelectorAll('#managers-content .list-group-item .btn-danger');

manager_delete.forEach(user => {
    user.addEventListener('click', function () {
        let li = user.parentNode.parentNode;
        let parent = li.parentNode;
        li.classList.add('animate');
        $("body .alert-pending-user").remove();
        $('body').append("<div class='alert alert-primary alert-dismissable alert-pending-user'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> O utilizador foi removido do cargo de Moderador!</div>");
        
        setTimeout(function(){
            li.style.display = "none";
            parent.removeChild(li);

        }, 500);
    })
}); 
