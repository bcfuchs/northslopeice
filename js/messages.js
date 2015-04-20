;! function ($) {
    $(document).ready(function () {

      // override default alert action
      var tracker_alert = function (m,t) {
    if (typeof t == 'undefined') {
        t = "alert-info";
    }

    $($('#alert-modal .alert-body').get(0)).html(m);
    $('#alert-modal').attr( "class","");
    $('#alert-modal').addClass("alert "+t);
    console.log(t);
    console.log("alert button....")

    $('#alert-modal').css({
      width: $(window).width(),
      position: "fixed",
      bottom: "-10px"
          });
    $("#back-button").toggle();
    $('#alert-modal').slideDown(500, function () {
      
      setTimeout(function () {
        
        $('#alert-modal').fadeOut(1000, function () {
          $("#back-button").toggle();
            });

          }, 2000);
        });

      }
      window.alert = tracker_alert;
      window.tracker_msg = tracker_alert;
  });
}(jQuery);