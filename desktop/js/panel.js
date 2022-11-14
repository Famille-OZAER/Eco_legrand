hideall();
verifParam();


$(".mainnav li.bt_dashboard").addClass('active');

var ecq = $('#conso_ecq').val();
var datesynchro = $('#datesynchro').val();

// chargement du dashboard
//alert('chargement');
loadingDash(ecq, datesynchro, ismobile, stylecss);

checkerror();
$('#conso_dashboard').show();

$('#conso_ecq').on('change', function() {
    var ecq = $(this).val();
    $(".mainnav li.active").click();
    //loadingDash(ecq); // chargement du dashboard
});

function hideall() {

    $('#conso_dashboard').hide();
    //$('#conso_tab').hide();
    $('#conso_outil').hide();
    //$('#conso_graph').hide();
    //$('#conso_graph_cat').hide();
    $('#conso').hide();
    //$('#conso_table').hide();
    $('.mainnav li').removeClass('active');
    $('.btn-group').hide();
}

$('.bt_graph_cat').on('click', function() {
    hideall();
    var ecq = $('#conso_ecq').val();
    refreshGraphCat(ecq);
    //showGraph();
    $('.bt_graph_cat').addClass('active');
    $('#conso_graph_cat').show();

});

$('.bt_temperature').on('click', function() {
    hideall();
    getDateMysql();
    showTemperature();
    $('.bt_temperature').addClass('active');
    $('#conso_temperature').show();
});

$('.bt_graph').on('click', function() {
    hideall();
    refreshGraph();
    $('.bt_graph').addClass('active');
    $('#conso_graph').show();
});

$('.bt_tab').on('click', function() {
    hideall();
    showTab();
    $('.bt_tab').addClass('active');
    $('#conso_tab').show();
});

$('.bt_dashboard').on('click', function() {
    hideall();
    //alert('bt_dashboard');
    var ecq = $('#conso_ecq').val();
    loadingPie(ecq); // chargement des statistiques
    loadingDash(ecq); // chargement du dashboard
    $('.bt_dashboard').addClass('active');
    $('#conso_dashboard').show();
    $(window).resize();
    /*Change les couleurs si le theme est different du defaut*/
    changeColorTheme(stylecss);
});



$('.bt_backup').on('click', function() {
    hideall();
    $('.bt_backup').addClass('active');
    $('#conso_backup').show();
});

$('.bt_outil').on('click', function() {
    hideall();
    getDateMysql();
    $('.bt_outil').addClass('active');
    $('#conso_outil').show();
});



$('.bt_conso').on('click', function() {
    hideall();
    $('.bt_conso').addClass('active');
    $('#conso').show();
});

$('.bt_synthese').on('click', function() {

    hideall();
    refreshSynthese();
    $('.bt_synthese').addClass('active');
    $('#conso_synthese').show();
});

$('.bt_table').on('click', function() {
    hideall();
    $('.bt_table').addClass('active');
    $('#conso_table').show();
    showTeleinfo();

});

$('.bt_correcteur').on('click', function() {
    hideall();
    $('.bt_correcteur').addClass('active');
    $('#conso_correcteur').show();
});

$('.dtimepicker').datetimepicker({
    lang: 'fr',
    format: 'Y-m-d',
    timepicker: false,
    step: 15
});

$('.dtimepickerTime').datetimepicker({
    lang: 'fr',
    timepicker: true,
    step: 5
});