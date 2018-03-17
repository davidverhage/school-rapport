$(document).ready(function () {
    // navigation click actions
    $('.page-scroll').on('click', function (event) {
        event.preventDefault();
        var sectionID = $(this).attr("data-id");
        scrollToID('#' + sectionID, 750);
    });
    // scroll to top action
    $('.scroll-top').on('click', function (event) {
        event.preventDefault();
        $('html, body').animate({scrollTop: 0}, 'slow');
    });
    // mobile nav toggle
    $('#nav-toggle').on('click', function (event) {
        event.preventDefault();
        $('#main-nav').toggleClass("open");
    });
});

// scroll function
function scrollToID(id, speed) {
    var offSet = 50;
    var targetOffset = $(id).offset().top - offSet;
    var mainNav = $('#main-nav');
    $('html,body').animate({scrollTop: targetOffset}, speed);
    if (mainNav.hasClass("open")) {
        mainNav.css("height", "1px").removeClass("in").addClass("collapse");
        mainNav.removeClass("open");
    }
}

if (typeof console === "undefined") {
    console = {
        log: function () {
        }
    };
}

if (typeof document == 'undefined' && typeof navigator == 'undefined') {
    var document = fabric.document;
    var navigator = fabric.window.navigator;
}

if (typeof(Event) === "undefined")
    var Event = {};
if (typeof(eventjs) === "undefined")
    var eventjs = Event;

function readURL(input) {
    if (!/(\.bmp|\.gif|\.jpg|\.jpeg|\.png)$/i.test(input.value)) {
        alert('INVALID FILE');
        document.getElementById('photo_file').value = '';
        return false;
    }
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img_loader').show();
            $('#photo_file').hide();
            var data_file = e.target.result;
            setSesn(data_file);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function guessImageMime(data) {
    if (data.charAt(0) == '/') {
        return "image/jpeg";
    } else if (data.charAt(0) == 'R') {
        return "image/gif";
    } else if (data.charAt(0) == 'i') {
        return "image/png";
    }
}

function setSesn(data) {
    var fileTyped = guessImageMime(data);
    console.log(fileTyped);
    $.ajax({
        type: "POST",
        url: "/dashboard/storeImage",
        data: {"file": data},
        cache: false,
        success: function (responseText) {
            $('#image_upload').attr('src', responseText);
            $('#img_loader').hide();
            $('#uploadtoDb').val(responseText);
        }
    });
}


$('#removeImage').on('click tap mouseup', function () {
    "use strict";
    var userID = $(this).attr('data-userId');
    var groupID = $(this).attr('data-userGroup');
    console.log(userID);
    $.ajax({
        type: "POST",
        url: "/dashboard/removeImage/" + userID + '/' + groupID,
        dataType: 'json',
        cache: false,
        success: function (responseText) {
            location.reload();
        }
    });
});

$('.clearRadio').on('click tap', function (e) {
    var groupInputName = $(this).attr('name');
    console.log(groupInputName);
    //$('input:radio[' + groupInputName +']:checked').prop('checked', false).checkboxradio("refresh");
    $('input:radio[name=' + groupInputName + ']:checked').each(function () {
        $(this).attr('checked', false);
        $(this).parent().removeClass("active");
    });
    e.preventDefault();
});
