$(document).ready(function () {
    $('#CharactersTable').DataTable();

    $('.backupChar').click(function() {
        $.post("/character/"+ $(this).attr('data-charid') +"/backup", function(data) {
            alert(data.message);
        });
    });

    $('.replaceChar').click(function() {
        let id = $(this).attr('data-charid');
        $('.replaceInput[data-charid="'+ id +'"').trigger('click');
    });

    $('.replaceInput').change(function() {
        let formdata = new FormData();
        if($(this).prop('files').length > 0)
        {
            file =$(this).prop('files')[0];
            formdata.append("replace", file);
        }

        jQuery.ajax({
            url: "/character/"+ $(this).attr('data-charid') +"/replace",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function (result) {
                alert(result.message)
            }
        });
    });

    $('.resetChar').click(function() {
        $.get("/character/"+ $(this).attr('data-charid') +"/reset", function(data) {
            alert(data.message);
            location.reload();
        });
    });
});
