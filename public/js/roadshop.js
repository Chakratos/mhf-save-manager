$(document).ready(function () {
    const table = $('#roadshoptable').DataTable({
        "columnDefs": [
            { "width": "20%", "targets": 2 },
            { "width": "15%", "targets": 1 },
        ]
    });

    $('#roadshopItemSelect').select2({
        theme: 'bootstrap4',
    });

    $('#roadshopCategorySelect').select2({
        theme: 'bootstrap4',
    });
    $('#createRoadItem').click(function() {
        $('#roadShopItemTitle > b')[0].innerHTML = '';
        $('#roadshopItemSelect').val('0000');
        $('#roadshopItemSelect').trigger('change');
        $('#roadshopCategorySelect').val('0');
        $('#roadshopCategorySelect').trigger('change');
        $('#roadshopCost').val('');
        $('#roadshopGRank').val('');
        $('#roadshopTradeQuantity').val('');
        $('#roadshopMaximumQuantity').val('');
        $('#roadshopBoughtQuantity').val('');
        $('#roadshopRoadFloors').val('');
        $('#roadshopFatalis').val('');
        $('#roadShopItemModal').modal('show');
    });

    $('#roadshoptable').on('click', '.editRoadItem', function () {
        $('#roadShopItemTitle > b')[0].innerHTML = $(this).data('id');
        $('#roadshopItemSelect').val($(this).data('itemid'));
        $('#roadshopItemSelect').trigger('change');
        $('#roadshopCategorySelect').val($(this).data('categoryid'));
        $('#roadshopCategorySelect').trigger('change');
        $('#roadshopCost').val($(this).data('cost'));
        $('#roadshopGRank').val($(this).data('grank'));
        $('#roadshopTradeQuantity').val($(this).data('tradequantity'));
        $('#roadshopMaximumQuantity').val($(this).data('maximumquantity'));
        $('#roadshopBoughtQuantity').val($(this).data('boughtquantity'));
        $('#roadshopRoadFloors').val($(this).data('roadfloors'));
        $('#roadshopFatalis').val($(this).data('fatalis'));
        $('#roadShopItemModal').modal('show');
    });

    $('#roadshopSave').click(function() {
        let id = $('#roadShopItemTitle > b')[0].innerHTML;
        let item = $('#roadshopItemSelect').find(':selected');
        let category = $('#roadshopCategorySelect').find(':selected');
        let cost = $('#roadshopCost').val();
        let grank = $('#roadshopGRank').val();
        let tradeQuantity = $('#roadshopTradeQuantity').val();
        let maximumQuantity = $('#roadshopMaximumQuantity').val();
        let boughtQuantity = $('#roadshopBoughtQuantity').val();
        let roadFloors = $('#roadshopRoadFloors').val();
        let fatalis = $('#roadshopFatalis').val();

        let saveButton = $(this);
        saveButton.prop('disabled', true);
        if (item.length === 0 || category.length === 0 || cost === "" || grank === "" || tradeQuantity === "" || maximumQuantity === "" || boughtQuantity === "" || roadFloors === "" || fatalis === "") {
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
            boughtQuantity: boughtQuantity,
            roadFloors: roadFloors,
            fatalis: fatalis,
        };

        $.ajax({
            url: "/servertools/roadshop/save",
            type: "POST",
            data: data,
        }).then(function(response) {
            let button = $('.editRoadItem[data-id="' + id + '"]');
            if (button.length > 0) {
                let cells = button.parents('tr').children('td');
                cells[1].innerHTML = category.text();
                cells[2].innerHTML = item.text();
                cells[3].innerHTML = cost;
                cells[4].innerHTML = grank;
                cells[5].innerHTML = tradeQuantity;
                cells[6].innerHTML = maximumQuantity;
                cells[7].innerHTML = boughtQuantity;
                cells[8].innerHTML = roadFloors;
                cells[9].innerHTML = fatalis;
                saveButton.prop('disabled', false);
                table.row(button.parents('tr')).invalidate().draw();
            } else {
                location.reload()
                //table.row.add(['ID VOM RESPOONSE', category.text(), item.text(), cost, grank, tradeQuantity, maximumQuantity, boughtQuantity, roadFloors, fatalis]).draw();
            }

            $('#roadShopItemModal').modal('hide');
        }).catch(function(response) {
            alert(response.message);
            saveButton.prop('disabled', false);
        });
    });

    $('#roadshoptable').on('click', '.deleteRoadItem', function () {
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
