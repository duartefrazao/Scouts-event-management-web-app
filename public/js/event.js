let event_page = document.querySelector('.event-page');

let mapDOM = event_page.querySelector('.map');

/*loadMembers(5, event_page.querySelector(".organizer-container .member-container"));
let member_container = event_page.querySelectorAll(".member-container");
loadMembers(10, member_container[0]);
loadMembers(3, member_container[1]);
loadMembers(10, member_container[2]);
loadMembers(3, member_container[3]);*/


let confirm_button = document.querySelector(".confirm-presence");
let remove_button = document.querySelector(".deny-presence");
let members = document.querySelectorAll(".member-wrap");
let event_id = document.querySelector('.event-title').getAttribute('data-id');

function addEventListeners() {

    confirm_button.addEventListener('click', function (event) {
        newConfirmation(true, confirm_button.classList.contains('active'));
    });

    remove_button.addEventListener('click', function (event) {
        newConfirmation(false, remove_button.classList.contains('active'));
    });

}


function newConfirmation(status, previousSelected) {

    if (previousSelected) return;

    sendAjaxRequest('post', '/api/events/' + event_id + '/presence', {presence: status}, confirmationHandler);

}

function confirmationHandler() {

    console.log(this.responseText);

    let response = JSON.parse(this.responseText);

    //console.log(response);
}

initializeGMap(41.1780, -8.5980, mapDOM);
$("#location-map").css("width", "100%");
$("#map_canvas").css("width", "100%");

google.maps.event.trigger(map, "resize");
map.setCenter(myLatlng);

var textarea = document.querySelector('.input-description');

textarea.addEventListener('keydown', autosize);

function autosize(e) {
    if(e.keyCode ===13){
        storeComment();
        return ;
    } 
    var el = this;
    setTimeout(function () {
        el.style.cssText = 'height:auto; padding:0';
        el.style.cssText = 'box-sizing:content-box';
        el.style.cssText = 'height:' + el.scrollHeight + 'px';
    }, 0);
}

function storeComment(){

    if(textarea.value.length=== 0){
        return;
    }

    sendAjaxRequest('post', '/events/' + event_id + '/comments', {text: textarea.value}, commentReceiver);
}


function commentReceiver(){
    if(this.status === 200){
        let commentSection = document.querySelector('.event-comments');
        
        let response = JSON.parse(this.responseText);
        console.log(response);
        //TO-DO update comments that might be done simultaneously, neccessary?
 
        let newComment= document.createElement('div')
        newComment.classList.add('row');
        newComment.classList.add('col-11');

        newComment.innerHTML = 
        '<div class="col-12 event-comment "> <span class="comment-author">' + response.name + " | " +  response.comment.date +'</span><span class="comment-body">'+ response.comment.text +  '</span></div>';

        commentSection.insertBefore(newComment,commentSection.childNodes[4]);

        textarea.value="";
    }
}

/*let input_file_btn = document.querySelector('.input-file-btn');
let input_file_hidden = document.querySelector('.input-file-hidden');
input_file_btn.addEventListener('click', () => input_file_hidden.click());*/


function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}


function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();

    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
}


addEventListeners();
members.forEach(member => {
    if(member.getAttribute('data-id') == user)
        confirm_button.classList.add('active');
});