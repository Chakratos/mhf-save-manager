$(document).ready(function () {
    $('.backupChar').click(function() {
        $.post("/character/"+ $(this).attr('data-charid') +"/backup/" + $(this).attr('data-binary'), function(data) {
            location.reload();
        });
    });

    $('.backupCharDecompressed').click(function() {
        $.post("/character/"+ $(this).attr('data-charid') +"/backupdecomp/" + $(this).attr('data-binary'), function(data) {
            location.reload();
        });
    });

    $('.uploadChar').click(function() {
        if (confirm('You are going to overwrite multiple Savedata fields for this character!\n\nThis only works Backups named according to the field it replaces, for example "savedata.bin" will replace savedata etc.')) {
            $('.uploadCharInput').trigger('click');
        }
    });

    $('.uploadCharInput').change(function() {
        if($(this).prop('files').length <= 0) {
            return;
        }

        let formdata = new FormData();
        let files = $(this).prop('files');

        for (let i = 0; i < files.length; i++) {
            formdata.append("files[]", files[i]);
        }

        $.ajax({
            url: "/character/" + $(this).attr('data-charid') + "/charupload",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            error: function (result) {
                alert(result.message)
            },
            success: function (result) {
                alert('The following saves where applied:' + '\n' + result.message.found.join('\n'));
            }
        });
    });

    $('.uploadBinaryButton').click(function() {
        let binary = $(this).attr('data-binary');
        $('.uploadBinaryInput[data-binary="'+ binary +'"').trigger('click');
    });

    $('.uploadBinaryInput').change(function() {
        let formdata = new FormData();
        if($(this).prop('files').length <= 0) {
            return;
        }

        let file =$(this).prop('files')[0];
        formdata.append("uploadBinary", file);
        formdata.append("binaryName", $(this).attr("data-binary"));


        $.ajax({
            url: "/character/" + $(this).attr('data-charid') + "/upload",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            error: function (result) {
                alert(result.message)
            },
            success: function () {
                location.reload();
            }
        });
    });

    $('.resetChar').click(function() {
        $.get("/character/"+ $(this).attr('data-charid') +"/reset", function(data) {
            location.reload();
        });
    });

    $('.applyBackup').click(function() {
        let formdata = new FormData();
        let selected = $('#select' + $(this).attr('data-binary') + 'Backup').val();
        if (selected == null) {
            return
        }
        formdata.append("replace", selected);

        $.ajax({
            url: "/character/"+ $(this).attr('data-charid') +"/replace/" + $(this).attr('data-binary'),
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function (result) {
                alert(result.message)
            }
        });
    });

    $('.compressEntry').click(function() {
        let formdata = new FormData();
        let selected = $('#select' + $(this).attr('data-binary') + 'Backup').val();
        if (selected == null) {
            return
        }
        formdata.append("entry", selected);
        formdata.append("decomp", 0);

        $.ajax({
            url: "/character/"+ $(this).attr('data-charid') +"/compressentry/" + $(this).attr('data-binary'),
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function (result) {
                location.reload();
            }
        });
    });

    $('.renameEntry').click(function() {
        let formdata = new FormData();
        let selected = $('#select' + $(this).attr('data-binary') + 'Backup').val();
        if (selected == null) {
            alert('Please select a backup first!');
            return;
        }
        let newName = prompt("Please enter the new name", "New name.bin");

        if (newName == null || newName == "") {
            return;
        }

        formdata.append("entry", selected);
        formdata.append("newName", newName);

        $.ajax({
            url: "/character/"+ $(this).attr('data-charid') +"/renameentry/" + $(this).attr('data-binary'),
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function (result) {
                location.reload();
            }
        });
    });

    $('.decompEntry').click(function() {
        let formdata = new FormData();
        let selected = $('#select' + $(this).attr('data-binary') + 'Backup').val();
        if (selected == null) {
            return
        }
        formdata.append("entry", selected);
        formdata.append("decomp", 1);

        $.ajax({
            url: "/character/"+ $(this).attr('data-charid') +"/compressentry/" + $(this).attr('data-binary'),
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function (result) {
                location.reload();
            }
        });
    });

    $('.deleteEntry').click(function() {
        let formdata = new FormData();
        let selected = $('#select' + $(this).attr('data-binary') + 'Backup').val();
        if (selected == null) {
            return
        }
        formdata.append("entry", selected);

        if (!window.confirm("Are you sure you want to delete: " + "\r\n" + selected)) {
            return;
        }

        $.ajax({
            url: "/character/"+ $(this).attr('data-charid') +"/deleteentry/" + $(this).attr('data-binary'),
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function (result) {
                location.reload();
            }
        });
    });

    $('.downloadBackup').click(function() {
        let binary = $(this).attr('data-binary');
        let selected = $('#select' + binary + 'Backup').val();
        if (selected == null) {
            return
        }

        window.location = "/character/" + $(this).attr('data-charid') + "/backup/" + binary + "/" + encodeURIComponent(selected);
    });
});
