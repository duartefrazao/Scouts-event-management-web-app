let advanced_toggle = document.querySelector('.advanced-toggle');

let advanced_search = document.querySelector('.advanced-search');

let collapsed = true;

advanced_toggle.addEventListener('click', function(){

    console.log('yo');

    console.log(advanced_search.style.display);

        if(collapsed){
            advanced_search.style.display = "block";
            collapsed = false;
        }
        else{
            advanced_search.style.display = "none";
            collapsed = true;
        }


});