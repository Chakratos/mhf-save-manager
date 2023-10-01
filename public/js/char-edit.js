$(document).ready(function () {
    updateSlideIndex('#itemboxPagination');
    updateSlideIndex('#equipboxPagination');

    function updateSlideIndex(carouselId) {
        var total = $(carouselId + ' .carousel-item').length;
        var currentIndex = $(carouselId + ' div.carousel-item.active').index() + 1;
        $(carouselId + ' #slidetext').html(currentIndex + '/'  + total);

        $(carouselId).on('slid.bs.carousel', function () {
            currentIndex = $(carouselId + ' div.carousel-item.active').index() + 1;
            var text = currentIndex + '/' + total;
            $(carouselId + ' #slidetext').html(text);
        });
    }

    function postData(funcname, value, reload = false, alertResponse = true, data = {}) {
        return $.ajax({
            url: value === null ? "/character/"+ charid +"/edit/" + funcname : "/character/"+ charid +"/edit/" + funcname + "/" + value,
            type: "POST",
            data: data,
            complete: function (result) {
                if (alertResponse) {
                    alert(result.responseJSON.message)
                }
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
            alert('The name can only be 12 characters long! (Or 6 Japanese ones)');
            return
        }

        postData("setname", '', true, false, {'name': name});
    });

    $('#setstylevouchers').click(function() {
        let stylevouchers = $('#stylevouchers').val();

        postData("setstylevouchers", stylevouchers, false, true);
    });

    $('#resetdailyguild').click(function() {
        postData("setdailyguild", "0", false, true);
    });

    $('#setzenny').click(function() {
        let zenny = $('#zenny').val();

        postData("setzenny", zenny);
    });

    $('#setgzenny').click(function() {
        let gzenny = $('#gzenny').val();

        postData("setgzenny", gzenny);
    });

    $('#setcp').click(function() {
        let cp = $('#cp').val();

        postData("setcp", cp);
    });

    $('#setgcp').click(function() {
        let gcp = $('#gcp').val();

        postData("setgcp", gcp);
    });

    $('#setnpoints').click(function() {
        let npoints = $('#npoints').val();

        postData("setnetcafepoints", npoints);
    });

    $('#setfrontierpoints').click(function() {
        let frontierpoints = $('#frontierpoints').val();

        postData("setfrontierpoints", frontierpoints);
    });

    $('#setkouryou').click(function() {
        let kouryou = $('#kouryou').val();

        postData("setkouryoupoint", kouryou);
    });

    $('#setgachatrial').click(function() {
        let gachatrial = $('#gachatrial').val();

        postData("setgachatrial", gachatrial);
    });

    $('#setgachaprem').click(function() {
        let gachaprem = $('#gachaprem').val();

        postData("setgachapremium", gachaprem);
    });

    $('#resetloginboost').click(function() {
        postData("resetloginboost", null, false, true);
    });

    $('#itemboxSlotItem').select2({
        theme: 'bootstrap4',
    });

    $('.itembox-item').click(function() {
        $('#itemboxSlotEditTitle > b')[0].innerHTML = $(this).data('slot');
        $('#itemboxSlotQuantity').val($(this).data('quantity'));
        $('#itemboxSlotItem').val($(this).data('id'));
        $('#itemboxSlotItem').trigger('change');
        $('#itemboxSlotEdit').modal('show');
    });

    $('#itemboxSlotSave').click(function() {
        var button = $(this);
        button.prop("disabled", true);
        console.log(button);
        let item = $('#itemboxSlotItem').find(':selected');
        let quantity = $('#itemboxSlotQuantity').val();
        let slot = $('#itemboxSlotEditTitle > b')[0].innerHTML;

        if (item.length === 0 || quantity === "" || slot === "") {
            button.prop("disabled", false);
            alert("Please fill all fields with valid data!");
            return;
        }

        postData('item/itembox', slot, false, false,
            {
                item_id: item.val(),
                item_quantity: quantity
            }
        ).then(function(response) {
            $('.item-col[data-slot="' + slot +'"]>img').attr('src', '/img/item/'+item.data('icon')+item.data('color')+'.png')
            $('.item-col[data-slot="' + slot +'"]>span')[0].innerHTML = '<b>[x' + quantity + ']</b> ' + item.text()
            $('#itemboxSlotEdit').modal('hide');
            button.prop("disabled", false);
        }).catch(function(response) {
            alert(response.message);
            button.prop("disabled", false);
        });
    });
});

