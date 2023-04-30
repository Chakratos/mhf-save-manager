$(document).ready(function () {
    const table = $('#gachaShopTable').DataTable();

    $('#createShop').click(function() {
        $('#gachaShopTitle > b')[0].innerHTML = '';
        $('#gachaShopName').val('');
        $('#gachaShopMinHR').val('');
        $('#gachaShopMinGR').val('');
        $('#gachaShopURLBanner').val('');
        $('#gachaShopURLFeature').val('');
        $('#gachaShopURLThumbnail').val('');
        $('#gachaShopRecommended').prop('checked', false);
        $('#gachaShopWide').prop('checked', false);
        $('#gachaShopHidden').prop('checked', false);
        $('#gachaShopModal').modal('show');
    });

    $('#gachaShopTable').on('click', '.editShop', function () {
        $('#gachaShopTitle > b')[0].innerHTML = $(this).data('id');

        $('#gachaShopTypeSelect').val($(this).data('gachatype'));
        $('#gachaShopName').val($(this).data('name'));
        $('#gachaShopMinHR').val($(this).data('minhr'));
        $('#gachaShopMinGR').val($(this).data('mingr'));
        $('#gachaShopRecommended').prop('checked', $(this).data('recommended') == '1');
        $('#gachaShopWide').prop('checked', $(this).data('wide') == '1');
        $('#gachaShopHidden').prop('checked', $(this).data('hidden') == '1');
        $('#gachaShopURLBanner').val($(this).data('url_banner'));
        $('#gachaShopURLFeature').val($(this).data('url_feature'));
        $('#gachaShopURLThumbnail').val($(this).data('url_thumbnail'));
        $('#gachaShopModal').modal('show');
    });

    $('#gachaShopSave').click(function() {
        let id = $('#gachaShopTitle > b')[0].innerHTML;
        let item = $('#roadshopItemSelect').find(':selected');
        let category = $('#roadshopCategorySelect').find(':selected');
        let cost = $('#gachaShopName').val();
        let grank = $('#gachaShopMinHR').val();
        let tradeQuantity = $('#gachaShopMinGR').val();
        let maximumQuantity = $('#gachaShopURLBanner').val();
        let roadFloors = $('#gachaShopURLFeature').val();
        let fatalis = $('#gachaShopURLThumbnail').val();

        let saveButton = $(this);
        saveButton.prop('disabled', true);
        if (item.length === 0 || category.length === 0 || cost === "" || grank === "" || tradeQuantity === "" || maximumQuantity === "" || roadFloors === "" || fatalis === "") {
            alert("Please fill all fields with valid data!");
            saveButton.prop('disabled', false);
            return;
        }

        if (isNaN(id)) {
            id = '';
        }

        let data = {
            id: id,
            item: item.val(),
            category: category.val(),
            cost: cost,
            grank: grank,
            tradeQuantity: tradeQuantity,
            maximumQuantity: maximumQuantity,
            roadFloors: roadFloors,
            fatalis: fatalis,
        };

        $.ajax({
            url: "/servertools/roadshop/save",
            type: "POST",
            data: data,
        }).then(function(response) {
            let button = $('.editShop[data-id="' + id + '"]');
            if (button.length > 0) {
                let cells = button.parents('tr').children('td');
                cells[1].innerHTML = category.text();
                cells[2].innerHTML = item.text();
                cells[3].innerHTML = cost;
                cells[4].innerHTML = grank;
                cells[5].innerHTML = tradeQuantity;
                cells[6].innerHTML = maximumQuantity;
                cells[7].innerHTML = roadFloors;
                cells[8].innerHTML = fatalis;
                saveButton.prop('disabled', false);
                table.row(button.parents('tr')).invalidate().draw(false);
            } else {
                location.reload()
                //table.row.add(['ID VOM RESPOONSE', category.text(), shop.text(), cost, grank, tradeQuantity, maximumQuantity, boughtQuantity, roadFloors, fatalis]).draw();
            }

            $('#gachaShopModal').modal('hide');
        }).catch(function(response) {
            alert(response.message);
            saveButton.prop('disabled', false);
        });
    });

    $('#gachaShopTable').on('click', '.deleteShop', function () {
        let formdata = new FormData();
        let itemId = $(this).attr('data-id');
        formdata.append("item", itemId);

        if (!window.confirm("Are you sure you want to delete the entry with the ID : " + itemId)) {
            return;
        }

        let rowToRemove = $(this).parents('tr');

        $.ajax({
            url: "/servertools/roadshop/delete/" + itemId,
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function (result) {
                table.row(rowToRemove).remove().draw();
            },
            error: function (result) {
                alert(result.responseJSON.message);
            }
        });
    });

    $('#importRoadShop').click(function() {
        if (!window.confirm("This will overwrite every Roadshop Item. Beware!")) {
            return;
        }

        $('#importRoadShopInput').trigger('click');
    });

    $('#importRoadShopInput').change(function() {
        let formdata = new FormData();
        if($(this).prop('files').length <= 0) {
            return;
        }

        let file =$(this).prop('files')[0];
        formdata.append("roadShopCSV", file);

        $.ajax({
            url: "/servertools/roadshop/import",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            error: function (result) {
                alert(result.responseJSON.message)
            },
            success: function () {
                location.reload();
            }
        });
    });
});
