$(document).ready(function () {
    function postData(funcname, value, reload = false) {
        $.ajax({
            url: "/character/"+ charid +"/edit/" + funcname + "/" + value,
            type: "POST",
            processData: false,
            contentType: false,
            complete: function (result) {
                alert(result.responseJSON.message)
                if (reload) {
                    location.reload();
                }
            }
        });
    }

    $('#setkeyquestflag').click(function() {
        let keyquestflag = $('#keyquestflag').val();
        if (keyquestflag.length !== 16) {
            alert('The Keyquestflag needs to be exactly 8 Bytes (16 Hex numbers)');
            return
        }

        postData("setkeyquestflag", keyquestflag);
    });

    $('#setname').click(function() {
        let name = $('#name').val();
        if (name.length > 12) {
            alert('The name can only be 12 characters long!');
            return
        }

        postData("setname", name, true);
    });

    $('#setstylevouchers').click(function() {
        let stylevouchers = $('#stylevouchers').val();

        postData("setstylevouchers", stylevouchers);
    });

    $('#setzenny').click(function() {
        let zenny = $('#zenny').val();

        postData("setzenny", zenny);
    });

    $('#setgzenny').click(function() {
        let gzenny = $('#gzenny').val();

        postData("setgzenny", gzenny);
    });
});
