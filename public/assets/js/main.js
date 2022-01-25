/*global $*/



$(document).ready(function () {
    "use strict";
	$('.btn-responsive-nav').on('click', function () {
        $(this).parents('.wrapper').toggleClass('sidebar-collapse');
    });
});

/*File Upload 
=========================*/
$(document).ready(function () {
    "use strict";
    $("#file1").on("change", function () {
        document.getElementById("progressBar").style.width = 0 + '%';
        document.getElementById("progressBar").innerHTML = 0 + '%';
        $('.total-upload').html('');
        $("#status").html('');
        $(this).next("p").text($(this).val());
    });
});

/* Toggle dropdown-menu
========================*/
$(document).ready(function () {
    "use strict";
    $(".treeview > a").on("click", function (e) {
        e.preventDefault();
        $(this).toggleClass('open').next('.treeview-menu').slideToggle();    
    });
});

/* Upload Progress Bar Script
 Script written by Adam Khoury @ DevelopPHP.com */
/* Video Tutorial: http://www.youtube.com/watch?v=EraNFJiY0Eg 
===============================*/
$(document).ready(function () {
    "use strict";
	function get_elment(el) {
        return document.getElementById(el);
    }
    function progressHandler(event) {
        get_elment("loaded_n_total").innerHTML = "<span class='total-upload'>Uploaded  "  + event.loaded + " bytes of " + event.total+"</span>";
        var percent = (event.loaded / event.total) * 100;
        var rounPercent = get_elment("progressBar").value = Math.round(percent);
        get_elment("progressBar").style.width = rounPercent + '%';
        get_elment("progressBar").innerHTML = rounPercent + '%';
        get_elment("status").innerHTML = Math.round(percent) + "% uploaded...";
    }
    function completeHandler(event) {
        get_elment("status").innerHTML = event.target.responseText;
        get_elment("progressBar").value = 0;
        $("#upload-btn").removeAttr("disabled");
    }
    function errorHandler(event) {
        get_elment("status").innerHTML = "Upload Failed";
        $("#upload-btn").removeAttr("disabled");
    }
    function abortHandler(event) {
        get_elment("status").innerHTML = "Upload Aborted";
    }
    function uploadFile() {
        var file = get_elment("file1").files[0],
            formdata = new FormData(),
            ajax = new XMLHttpRequest();
        formdata.append("file1", file);
	    
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "js/file_upload_parser.php");
        ajax.send(formdata);
    }
    
    $('#upload-btn').on('click', function () {
        uploadFile();
        $(this).attr("disabled", true);
    });
});




/* Date range picker and SummerNote Eitor Trigger Code
=======================================================*/
$(document).ready(function () {
    "use strict";
    $('.daterange').daterangepicker();
    
    
    $('.summernote').summernote({height: 150});
        //API:
        //var sHTML = $('.summernote').code(); // get code
        //$('.summernote').destroy(); // destroy
    
    
});

    
