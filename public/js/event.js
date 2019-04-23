let event_page = document.querySelector('.event-page');

let mapDOM = event_page.querySelector('.map');

let member_container = event_page.querySelectorAll(".member-container");
//loadMembers(10, member_container[0]);
//loadMembers(3, member_container[1]);
loadMembers(3, member_container[2]);
loadMembers(10, member_container[3]);
loadMembers(3, member_container[4]);


initializeGMap(41.1780, -8.5980, mapDOM);
$("#location-map").css("width", "100%");
$("#map_canvas").css("width", "100%");

google.maps.event.trigger(map, "resize");
map.setCenter(myLatlng);



var textarea = document.querySelector('.input-description');

textarea.addEventListener('keydown', autosize);
             
function autosize(){
  var el = this;
  setTimeout(function(){
    el.style.cssText = 'height:auto; padding:0';
    el.style.cssText = 'box-sizing:content-box';
    el.style.cssText = 'height:' + el.scrollHeight + 'px';
  },0);
}



let input_file_btn = document.querySelector('.input-file-btn');
let input_file_hidden = document.querySelector('.input-file-hidden');
input_file_btn.addEventListener('click', () => input_file_hidden.click());