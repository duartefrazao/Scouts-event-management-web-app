$('#home-container .nav-tabs a').click(function (e) {

    $(this).tab('show');
});



$('#calendar-toggle .nav-tabs a').click(function (e) {

    $(this).tab('show');
});

let nots = document.querySelectorAll('.message-box');
nots.forEach(notification =>{
    setTimeout(removeNotification.bind(notification), 2000);
});

function removeNotification(){
    //this.style.transition="all 1s linear ";
    //this.parentNode.removeChild(this);
}