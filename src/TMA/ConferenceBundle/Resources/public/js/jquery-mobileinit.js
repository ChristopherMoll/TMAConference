$(document).delegate('a.top', 'click', function () {
    $.mobile.silentScroll(0);
    return false;
});
//$(document).bind("mobileinit", function () {
//    $.mobile.ajaxEnabled = false;
//});