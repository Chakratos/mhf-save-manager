$(document).ready(function () {
    function postData(funcname, value) {

    }
    $('#setkeyquestflag').click(function() {
        let keyquestflag = $('#keyquestflag').val();
        if (keyquestflag.length !== 16) {
            alert('The Keyquestflag needs to be exactly 8 Bytes (16 Hex numbers)');
            return
        }

        $.ajax({
            url: "/character/"+ charid +"/edit/setkeyquestflag/" + keyquestflag,
            type: "POST",
            processData: false,
            contentType: false,
            complete: function (result) {
                console.log(result);
                alert(result.responseJSON.message)
            }
        });
    });
});
