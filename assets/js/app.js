/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
const $ = require('jquery');
// any CSS you require will output into a single css file (app.css in this case)
require('../css/global.scss');
require('bootstrap');
// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();

    // wysyłanie maila z formularzy
        $(function () {
        $('#emailSend1').on('click', function (e) {
            e.preventDefault();
            var parName = $("#form1_parentName").val();
            var chiName = $("#form1_childName").val();
            var admName = $("#user").val();
            var term = $("#term").val();
            var hour = $("#hour").val();
            var email = $("#form1_parentEmail").val();
            var subject = 'Potwierdzenie';
            var emailBody = parName + ',%0APotwierdzam lekcję ' + chiName + ' w terminie: ' 
                + term + ' o godzinie: ' + hour + '. %0A%0ADziękuję. %0APozdrawiam ' + admName;
            window.location = 'mailto:' + email + '?subject=' + subject + '&body=' + emailBody;
        });
    });

    $(function () {
        $('#emailSend2').on('click', function (e) {
            e.preventDefault();
            var parName = $("#form2_parentName").val();
            var chiName = $("#form2_childName").val();
            var admName = $("#user").val();
            var term = $("#term").val();
            var hour = $("#hour").val();
            var email = $("#form2_parentEmail").val();
            var subject = 'Potwierdzenie';
            var emailBody = parName + ',%0APotwierdzam lekcję ' + chiName + ' w terminie: ' 
                + term + ' o godzinie: ' + hour + '. %0A%0ADziękuję. %0APozdrawiam ' + admName;
            window.location = 'mailto:' + email + '?subject=' + subject + '&body=' + emailBody;
        });
    });

    $(function () {
    $('#emailSend3').on('click', function (e) {
        e.preventDefault();
        var parName = $("#form3_parentName").val();
        var chiName = $("#form3_childName").val();
        var admName = $("#user").val();
        var term = $("#term").val();
        var hour = $("#hour").val();
        var email = $("#form3_parentEmail").val();
        var subject = 'Potwierdzenie';
        var emailBody = parName + ',%0APotwierdzam lekcję ' + chiName + ' w terminie: ' 
            + term + ' o godzinie: ' + hour + '. %0A%0ADziękuję. %0APozdrawiam ' + admName;
        window.location = 'mailto:' + email + '?subject=' + subject + '&body=' + emailBody;
    });
    });

    $(function () {
    $('#emailSend4').on('click', function (e) {
        e.preventDefault();
        var parName = $("#form4_parentName").val();
        var chiName = $("#form4_childName").val();
        var admName = $("#user").val();
        var term = $("#term").val();
        var hour = $("#hour").val();
        var email = $("#form4_parentEmail").val();
        var subject = 'Potwierdzenie';
        var emailBody = parName + ',%0APotwierdzam lekcję ' + chiName + ' w terminie: ' 
            + term + ' o godzinie: ' + hour + '. %0A%0ADziękuję. %0APozdrawiam ' + admName;
        window.location = 'mailto:' + email + '?subject=' + subject + '&body=' + emailBody;
    });
    });
    // end: wysyłanie maila z formularzy  
    
    // włączanie możliwości klikania w tabelach
    $('.clickable').on('click', function (e) {
      var id = $(this).attr("id");
      //alert(id);
      $(location).attr('href','/child/new/'+id);
    });
    $('.adminclickable').on('click', function (e) {
        var id = $(this).attr("id");
        //alert(id);
        $(location).attr('href','/admin/show/'+id);
    });
    $('.activate').on('click', function (e) {
        var id = $(this).attr("id");
        //alert(id);
        $(location).attr('href','/admin/activate/'+id);
    });
    //end: włączanie możliwości klikania w tabelach
    
    //wybór tygodnia (ajax)
    //admin
    $("#arrow_nextweek").on('click', function () {
        $.ajax({
            data: { },
            type: 'GET',
            url: '/admin/week2',
            dataType: 'json',
            success: function (result) {
                $('#test').html(result.template); 
            }
        });  
    });  

    $("#arrow_prevweek").on('click', function () {
        $.ajax({
            data: { },
            type: 'GET',
            url: '/admin',
            dataType: 'json',
            success: function (result) {
                $('#test').html(result.template);
            }
        });  
    });  
    //user
    $("#arrow_nextweek_u").on('click', function () {
        $.ajax({
            data: { },
            type: 'GET',
            url: '/lesson/week2',
            dataType: 'json',
            success: function (result) {
                $('#test').html(result.template); 
            }
        });  
    });  

    $("#arrow_prevweek_u").on('click', function () {
        $.ajax({
            data: { },
            type: 'GET',
            url: '/lesson',
            dataType: 'json',
            success: function (result) {
                $('#test').html(result.template);
            }
        });  
    });  
    //end: wybór tygodnia (ajax)
});




log('Hello Webpack Encore! Edit me in assets/js/app.js');
