$(document).ready(function() {
    setResponsiveTable();
    $(window).resize(function() {
        setResponsiveTable();
    });
});

function setResponsiveTable() {
    //definisco variabili di base
    var siteWidth = $(document).width();
    //verifico la grandezza dello schermo e aggiungo la classe css
    if (siteWidth < 655) {
        $('#datatable').addClass("table-responsive");
    }
    else {
        $('#datatable').removeClass("table-responsive");
    }
}
