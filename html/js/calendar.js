window.onload = calcDate;

let calendar = document.querySelector("#calendar");

// let previousMonth = document.querySelector()

function calcDate() {
    var d = new Date();
    let meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    var month_name = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var month = d.getMonth(); //0-11
    var year = d.getFullYear(); //2014
    var curr_day = d.getDate();
    console.log(curr_day);
    var first_date = month_name[month] + " " + 1 + " " + year;
    //September 1 2014
    var tmp = new Date(first_date).toDateString();
    //Mon Sep 01 2014 ...
    var first_day = tmp.substring(0, 3); //Mon
    var day_name = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    var day_no = day_name.indexOf(first_day); //1
    var days = new Date(year, month + 1, 0).getDate(); //30
    //Tue Sep 30 2014 ...

    console.log(days);

    calendar.querySelector('.month-name').textContent = meses[month];

    setFirstDay(day_no, days);

    highlightCurrentDay(curr_day);

}

function highlightCurrentDay(day) {
    calendar.querySelector('.day [data-id="' + day + '"]').classList.add('current-day');
}

function setFirstDay(index, days) {

    let firstWeek = calendar.querySelector('[data-id="week-0"]');

    let firstDay = firstWeek.querySelector('[data-id="day-' + index + '"]');

    let week = firstWeek;

    let day = firstDay;

    let i = 0;

    while (i < days) {

        updateDay(day, i);

        if ((index + 1) % 6 == 0) {

            updateDay(day.nextElementSibling, ++i);

            week = week.nextElementSibling;
            day = week.firstElementChild;
        } else {
            day = day.nextElementSibling;
        }

        i++;
        index++;
    }

}

function updateDay(element, day) {

    element.classList.remove("text-muted");
    element.querySelector('h6 span').textContent = day + 1;
    element.querySelector('h6').setAttribute('data-id', day + 1);

}