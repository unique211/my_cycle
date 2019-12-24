$(document).ready(function() {
    $(".formhideshow").hide();
    $(".tablehideshow").show();
    $(document).on('click', '.btnhideshow', function() {
        $(".formhideshow").show();
        $(".tablehideshow").hide();
    });
    $(document).on('click', '.closehideshow', function() {
        $(".formhideshow").hide();
        $(".tablehideshow").show();
    });
});