$(document).ready(function () {
    $('.resetChar').click(function() {
        $.get("/character/"+ $(this).attr('data-charid') +"/reset", function(data) {
            alert(data.message);
            location.reload();
        });
    });
});
