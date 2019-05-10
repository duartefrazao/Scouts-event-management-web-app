function placeChildren() {
    let modalKids = document.querySelector("#manage-kids-faces");
    modalKids.innerHTML = "";
    if (modalKids != null) {

        console.log('/api/users/' + user + '/wards')

        sendAjaxRequest('GET', '/api/users/' + user + '/wards', null, addChildren);

    }
    //loadMembers(3, modalKids);
}

function addMembers(membersJSON, elemDOM) {
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


function addChildren() {
    let modalKids = document.querySelector("#manage-kids-faces");

    let kids = JSON.parse(this.responseText);

    console.log(kids);

    kids.forEach(kid => {

        let memberHTML = `
        <label data-id="${kid.id}">
            ${kid.name.split(" ")[0]}
        </label>`

        let memberDOM = document.createElement('div');
        memberDOM.classList.add('member-wrap', 'm-1');
        memberDOM.innerHTML = memberHTML;
        modalKids.appendChild(memberDOM);
    });
}

function loadMembers(numMembers, elemDOM) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            let response = JSON.parse(this.responseText);
            addMembers(response.results, elemDOM);
        }
    }

    xhr.open('GET', `https://randomuser.me/api/?results=${numMembers}`);
    xhr.send();
}


function addMembersFace(membersJSON, elemDOM) {

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


function loadFaceMember(numMembers, elemDOM) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            let response = JSON.parse(this.responseText);
            addMembersFace(response.results, elemDOM);
        }
    }

    xhr.open('GET', `https://randomuser.me/api/?results=${numMembers}`);
    xhr.send();
}