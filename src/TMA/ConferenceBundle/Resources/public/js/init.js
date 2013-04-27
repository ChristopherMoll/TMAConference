$(document).on("pageinit", "#top", function(){
    $("#agendalist").listview({
        autodividers: true,
        autodividersSelector: function (li) {
            var out = li.attr('date');
            return out;
        }
    }).listview('refresh');
});