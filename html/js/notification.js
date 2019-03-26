$('.popover-dismiss').popover({
  trigger: 'focus'
})


$(function () {
  // Enables popover
  $("#notifications-toggle").popover({
    html: true,
    content: function () {
      return $("#notifications-toggle-content").html();
    },
    template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div><div class="popover-footer"> <a href="../pages/notifications.html"> Vê todas </a></div></div>'
  });
});