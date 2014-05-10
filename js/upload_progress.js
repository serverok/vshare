(function() {
    var bar = $(".bar");
    var percent = $(".percent");
    var status = $("#status");
    var upload_id = $("input#upload_id").val();

    $("form").ajaxForm({
        beforeSend: function() {
            status.empty();
            var percentVal = "0%";
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + "%";
            bar.width(percentVal)
            percent.html(percentVal);
            //console.log(percentVal, position, total);
            if (percentComplete > 98) {
                $("div#processing").show();
            }
        },
        success: function() {
            var percentVal = "100%";
            bar.width(percentVal);
            percent.html(percentVal);
        },
        complete: function(xhr) {
            if (isNaN(xhr.responseText)) {
                status.html(xhr.responseText);
            } else {
                document.location = baseurl +"/upload/success/" + xhr.responseText + "/" + upload_id + "/";
            }
        }
    });

})();