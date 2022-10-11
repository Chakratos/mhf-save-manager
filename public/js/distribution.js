$(document).ready(function () {
    let currentlyEditedItem = null;
    const table = $('#distributiontable').DataTable();
    $('select.form-control:not(#distributionItemsSelect)').select2({
        theme: 'bootstrap4',
    });

    $('#distributionDeadline').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
    });

    $('#distributionItemsSelect').on('dblclick','option',function() {
        $('#distributionItemTitle > b')[0].innerHTML = $(this).index()+1;
        $('#distributionItemTypeSelect').val($(this).data('type'));
        $('#distributionItemTypeSelect').trigger('change');
        if ($(this).data('type') <= 7 || $(this).data('type') == 15) {
            let typefancy = $('#distributionItemTypeSelect :selected').text().replace(/\s/g,'');
            $('#distribution' + typefancy + 'Select').val($(this).data('itemid'));
            $('#distribution' + typefancy + 'Select').trigger('change');
        } else if ($(this).data('type') == 8) {
            $('#distributionFurnitureInput').val($(this).data('itemid'));
        }
        $('#distributionAmount').val($(this).data('amount'));
        $('#distributionItemModal').modal('show');
    });

    $('#distributionItemTypeSelect').change(function() {
        $('#selectgroup').addClass('d-none');
        $('#selectgroup > div > span').addClass('d-none');

        if ($(this).val() <= 7 || $(this).val() == 15) {
            $('#selectgroup').removeClass('d-none');
            $('#distribution' + $('#distributionItemTypeSelect :selected').text().replace(/\s/g,'') + 'Select').next().removeClass('d-none');
        } else if ($(this).val() == 8) {
            $('#selectgroup').removeClass('d-none');
            $('#distributionFurnitureInput').removeClass('d-none');
        }
    });

    $('#delDistributionItem').click(function() {
        $('#distributionItemsSelect :selected').remove();
    });

    $('#addDistributionItem').click(function() {
        $('#distributionItemTitle > b')[0].innerHTML = "";
        $('#distributionItemTypeSelect').val(0);
        $('#distributionItemTypeSelect').trigger('change');
        $('#distributionLegsSelect').val("0000");
        $('#distributionLegsSelect').trigger('change');
        $('#distributionFurnitureInput').val("");
        $('#distributionAmount').val("");
        $('#distributionItemModal').modal('show');
    });

    $('#distributionSaveItem').click(function() {
        let index = $('#distributionItemTitle > b')[0].innerHTML;
        let amount = $('#distributionAmount').val() ? $('#distributionAmount').val() : 1;
        let added = false;

        if (index === "") {
            index = $('#distributionItemsSelect option').length+1;
            added = true;
        }

        let value = "0000";

        if ($('#distributionItemTypeSelect').val() <= 7 || $('#distributionItemTypeSelect').val() == 15) {
            value = $('#distribution' + $('#distributionItemTypeSelect :selected').text().replace(/\s/g,'') + 'Select').val();
        } else if ($('#distributionItemTypeSelect').val() == 8) {
            value = $('#distributionFurnitureInput').val();
        }

        let option = $(generateOption(
            $('#distributionItemTypeSelect').val(),
            value,
            amount,
            index
        ));

        if (added) {
            $('#distributionItemsSelect').append(option);
        } else {
            $('#distributionItemsSelect option').eq(index-1).before(option).remove();
        }

        $('#distributionItemModal').modal('hide');
    });

    $('#createDistribution').click(function() {
        $('#distributionTitle > b')[0].innerHTML = '';
        $('#distributionTypeSelect').val('0');
        $('#distributionTypeSelect').trigger('change');
        $('#distributionCharacterSelect').val('-1');
        $('#distributionCharacterSelect').trigger('change');
        $('#distributionTimesAcceptable').val(null);
        $('#distributionName').val(null);
        $('#distributionDesc').val(null);
        $('#distributionNameColor').val(null);
        $('#distributionDescColor').val(null);
        $('#distributionDeadline').val(null);
        $('#distributionMinHR').val(65535);
        $('#distributionMaxHR').val(65535);
        $('#distributionMinSR').val(65535);
        $('#distributionMaxSR').val(65535);
        $('#distributionMinGR').val(65535);
        $('#distributionMaxGR').val(65535);
        $('#distributionItemsSelect').empty();
        $('#distributionModal').modal('show');

    });

    $('#distributiontable').on('click', '.deleteDistribution', function () {
        let formdata = new FormData();
        let distId = $(this).attr('data-id');
        formdata.append("distribution", distId);

        if (!window.confirm("Are you sure you want to delete the entry with the ID : " + distId)) {
            return;
        }

        let rowToRemove = $(this).parents('tr');

        $.ajax({
            url: "/servertools/distributions/delete/" + distId,
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

    $('#distributiontable').on('click', '.duplicateDistribution', function () {
        let formdata = new FormData();
        let distId = $(this).attr('data-id');
        formdata.append("distribution", distId);

        if (!window.confirm("Are you sure you want to duplicate the entry with the ID : " + distId)) {
            return;
        }

        $.ajax({
            url: "/servertools/distributions/duplicate/" + distId,
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function (result) {
                location.reload();
            },
            error: function (result) {
                alert(result.responseJSON.message);
            }
        });
    });

    $('#distributiontable').on('click', '.editDistribution', function () {
        $('#distributionTitle > b')[0].innerHTML = $(this).data('id');
        $('#distributionTypeSelect').val($(this).data('type'));
        $('#distributionTypeSelect').trigger('change');
        $('#distributionCharacterSelect').val($(this).data('characterid') ? $(this).data('characterid') : '-1');
        $('#distributionCharacterSelect').trigger('change');
        $('#distributionTimesAcceptable').val($(this).data('timesacceptable'));
        $('#distributionName').val($(this).data('name'));
        $('#distributionDesc').val($(this).data('desc'));
        $('#distributionDeadline').val($(this).data('deadline'));
        $('#distributionMinHR').val($(this).data('minhr'));
        $('#distributionMaxHR').val($(this).data('maxhr'));
        $('#distributionMinSR').val($(this).data('minsr'));
        $('#distributionMaxSR').val($(this).data('maxsr'));
        $('#distributionMinGR').val($(this).data('mingr'));
        $('#distributionMaxGR').val($(this).data('maxgr'));
        $('#distributionNameColor').val($(this).data('namecolor'));
        $('#distributionDescColor').val($(this).data('desccolor'));
        $('#distributionItemsSelect').empty();

        $.each(DistributionItems[$(this).data('id')], function (i, item) {
            $('#distributionItemsSelect').append($(generateOption(item.type, item.itemId, item.amount, (parseInt(i)+1))));
        });
        $('#distributionModal').modal('show'); //distributionItemsSelect
    });

    function generateOption(type, id, amount, i)
    {
        typeFancy = $("#distributionItemTypeSelect option[value='" + type + "']").text().replace(/\s/g,'');
        let name = "";

        if (type <= 7 || type == 15) {

            name = " | " + $("#distribution" + typeFancy + "Select option[value='" + id + "']").text().replace(/\s/g,'');
        } else if (type == 8) {
            name = " | " + id;
        }

        return '<option data-type="' + type + '" data-itemid="' + id + '" data-amount="' + amount + '">' + i + ". " + amount + "x " + typeFancy + name + '</option>';
    }

    $('#colorsButton').tooltip({ trigger: 'click'});

    $('#distributionSave').click(function() {
        let id = $('#distributionTitle > b')[0].innerHTML;
        let type = $('#distributionTypeSelect').val();
        let characterId = $('#distributionCharacterSelect').val();
        let timesacceptable = $('#distributionTimesAcceptable').val();
        let name = '~C' + $('#distributionNameColor').val() + $('#distributionName').val();
        let desc = '~C' + $('#distributionDescColor').val() + $('#distributionDesc').val();
        let deadline = $('#distributionDeadline').val();
        let minhr = $('#distributionMinHR').val();
        let maxhr = $('#distributionMaxHR').val();
        let minsr = $('#distributionMinSR').val();
        let maxsr = $('#distributionMaxSR').val();
        let mingr = $('#distributionMinGR').val();
        let maxgr = $('#distributionMaxGR').val();

        let index = id ? id : Object.keys(DistributionItems).length

        DistributionItems[index] = {};

        $.each($('#distributionItemsSelect option'), function (i) {
            DistributionItems[index][i] = {type: $(this).data('type'), itemId: $(this).data('itemid'), amount: $(this).data('amount')}
        });

        let saveButton = $(this);
        saveButton.prop('disabled', true);
        if (minhr === "" || maxhr === "" || minsr === "" || maxsr === "" || mingr === "" || maxgr === "" || characterId === "" || name === "" || desc === "" || timesacceptable === "" || $('#distributionNameColor').val() === null || $('#distributionNameColor').val() === null) {
            alert("Please fill all fields with valid data!");
            saveButton.prop('disabled', false);
            return;
        }

        if (isNaN(id)) {
            id = '';
        }

        let data = {
            id: id,
            type: type,
            characterId: characterId,
            timesacceptable: timesacceptable,
            name: name,
            desc: desc,
            deadline: deadline,
            minhr: minhr,
            maxhr: maxhr,
            minsr: minsr,
            maxsr: maxsr,
            mingr: mingr,
            maxgr: maxgr,
            items: DistributionItems[index]
        };

        $.ajax({
            url: "/servertools/distributions/save",
            type: "POST",
            data: data,
        }).then(function(response) {
            location.reload();
            return;
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

            $('#distributionModal').modal('hide');
        }).catch(function(response) {
            alert(response.message);
            saveButton.prop('disabled', false);
        });
    });

    $('#importDistribution').click(function() {
        if (!window.confirm("This will overwrite every Distribution. Beware!")) {
            return;
        }

        $('#importDistributionInput').trigger('click');
    });

    $('#importDistributionInput').change(function() {
        let formdata = new FormData();
        if($(this).prop('files').length <= 0) {
            return;
        }

        let file =$(this).prop('files')[0];
        formdata.append("distributionCSV", file);

        $.ajax({
            url: "/servertools/distributions/import",
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
