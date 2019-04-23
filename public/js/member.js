function placeChildren(){
    let modalKids = document.querySelector("#manage-kids-faces");
    modalKids.innerHTML="";
    loadMembers(3,modalKids);
}

function addMembers(membersJSON, elemDOM){
    membersJSON.forEach(member => {
        let memberHTML = `
        <label>
            <img src="${member.picture.thumbnail}" class="rounded-circle" /> ${member.name.first}
        </label>`

        let memberDOM = document.createElement('div');
        memberDOM.classList.add('member-wrap');
        memberDOM.innerHTML = memberHTML;
        elemDOM.appendChild(memberDOM);
    });  
}


function loadMembers(numMembers, elemDOM){
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.status === 200 && this.readyState === 4){
            let response = JSON.parse(this.responseText);
            addMembers(response.results, elemDOM);
        }
    }
    
    xhr.open('GET', `https://randomuser.me/api/?results=${numMembers}`);
    xhr.send();
}


function addMembersFace(membersJSON, elemDOM){

    membersJSON.forEach(member => {
        let memberHTML = `
        <label>
            <img src="${member.picture.thumbnail}" class="rounded-circle" />
        </label>`

        let memberDOM = document.createElement('div');
        memberDOM.classList.add('member-wrap');
        memberDOM.innerHTML = memberHTML;
        elemDOM.appendChild(memberDOM);
    });    
}


function loadFaceMember(numMembers, elemDOM){
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.status === 200 && this.readyState === 4){
            let response = JSON.parse(this.responseText);
            addMembersFace(response.results, elemDOM);
        }
    }
    
    xhr.open('GET', `https://randomuser.me/api/?results=${numMembers}`);
    xhr.send();
}