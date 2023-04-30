<?php


namespace MHFSaveManager\Controller;


use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\Distribution;
use MHFSaveManager\Service\ResponseService;

/**
 *
 */
abstract class AbstractController
{
    /**
     * @param $pageTitle
     * @param $itemName
     * @param $data
     * @param $actions
     * @param $modalFieldInfo
     * @return string
     */
    public static function generateDynamicTable(
        $pageTitle,
        $itemName,
        $data,
        $actions,
        $modalFieldInfo
    ): string {
        ob_start();
        include __DIR__ . '/../views/head.php';
        $head = ob_get_clean();
        include __DIR__ . '/../views/topnav.php';
        $topnav = ob_get_clean();
    
        $ucItemName = ucfirst($itemName);
        
        $output = "<html lang=\"en\">
<head>
    <title>{$pageTitle}</title>
    <link rel=\"stylesheet\" href=\"/css/char-edit.css\">
    " . $head . '
</head>
<body>' . $topnav;
        
        // Generate the modal
        $output .= <<<HTML
<div id="{$itemName}ItemModal" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{$itemName}ItemTitle">Editing {$itemName} Item: <b></b></h5>
            </div>
            <div class="modal-body">
HTML;
        
        foreach ($modalFieldInfo as $key => $field) {
            $idKey = str_replace(' ', '', $key);
            $output .= "<h6>{$key}:</h6>
        <div class=\"input-group mb-2\">";
            
            if ($field['type'] === 'Array') {
                $output .= "<select class=\"form-control\" id=\"{$itemName}{$idKey}\">";
                foreach ($field['options'] as $id => $option) {
                    $output .= sprintf('<option value="%s">%s</option>', $id, is_array($option) ? sprintf('[%s] %s', $id, $option['name']) : $option);
                }
                $output .= '</select>';
            } else {
                $inputType = $field['type'] === 'Int' ? 'number' : 'text';
                $disabled = !empty($field['disabled']) ? 'disabled="disabled"' : '';
                $placeholder = !empty($field['placeholder']) ? 'placeholder="' . $field['placeholder'] . '"' : '';
                $min = !empty($field['min']) ? 'min="' . $field['min'] . '"' : '';
                $max = !empty($field['max']) ? 'max="' . $field['max'] . '"' : '';
                $output .= "<input {$min} {$max} {$disabled} {$placeholder} type=\"{$inputType}\" class=\"form-control\" id=\"{$itemName}{$idKey}\">";
            }
            
            $output .= '</div>';
        }
        
        $output .= <<<HTML
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="{$itemName}Save">Save</button>
            </div>
        </div>
    </div>
</div>
HTML;
    
        $select2Init = '';
        $varAssignments = '';
        $varResets = '';
        $varLoading = '';
        $varChecks = '1==2';
        $varData = '';
        $varCellData = '';
    
        $i = 0;
        
        foreach ($modalFieldInfo as $key => $field) {
            $key = str_replace(' ', '', $key);
            $lcKey = strtolower($key);
            if ($field['type'] === 'Array') {
                $select2Init .= <<<JS
            $('#${itemName}${key}').select2({
                theme: 'bootstrap4'
            });
            JS;
            }
        
            if ($field['type'] === 'Array') {
                $varAssignments .= "let $key = $('#${itemName}$key').find(':selected');\n";
                $varResets .= "$('#${itemName}$key').val($('#${itemName}$key option:first').val());\n";
                $varResets .= "$('#${itemName}$key').trigger('change');\n";
                //$varLoading .= "$('#${itemName}$key').val($('#${itemName}$key option:contains(' + $(this).data('${lcKey}') + ')').val()).trigger('change');\n";
                $varLoading .= "$('#${itemName}$key').val($(this).data('${lcKey}')).trigger('change');\n";
                $varChecks .= "|| ${key}.length === 0";
                $varData .= "$lcKey: $key.val(),\n";
                $varCellData .= "cells[${i}].innerHTML = $key.text();\n";
            } else {
                $varAssignments .= "let $key = $('#${itemName}$key').val();\n";
                $varResets .= "$('#${itemName}$key').val('');\n";
                $varLoading .= "$('#${itemName}$key').val($(this).data('${lcKey}'));\n";
                $varChecks .= $key !== 'ID' ? " || ${key} === ''" : '';
                $varData .= "$lcKey: $key,\n";
                $varCellData .= "cells[${i}].innerHTML = $key;\n";
            }
            $i++;
        }

        // Generate the table
        $output .= "<div class=\"container\">
    <table id=\"{$itemName}table\" class=\"table table-striped table-bordered\" style=\"width:100%\">
        <thead>
        <tr>";
        
        foreach ($modalFieldInfo as $field => $type) {
            $output .= "<th>{$field}</th>";
        }
        
        $output .= '<th>Actions</th>
        </tr>
        </thead>
        <tbody>';
        
        foreach ($data as $row) {
            $output .= '<tr>';
            
            foreach ($modalFieldInfo as $field => $type) {
                if ($type['type'] === 'Array') {
                    $output .= "<td>{$row[$field]['name']}</td>";
                } else {
                    $output .= "<td>{$row[$field]}</td>";
                }
            }
            
            $output .= '<td>';
            $varEditData = '';
            
            foreach ($row as $key => $value) {
                if (is_array($value)) {
                    $varEditData .= sprintf('data-%s = "%s"', str_replace(' ', '', $key), $value['id']);
                } else {
                    $varEditData .= sprintf('data-%s = "%s"', str_replace(' ', '', $key), $value);
                }
                
            }
            
            $output .= "<button {$varEditData} class=\"edit{$itemName}Item btn btn-sm btn-outline-success\"><i class=\"fas fa-pencil\"></i></button>";
            $output .= "<button data-id=\"{$row['ID']}\" class=\"delete{$itemName}Item btn btn-sm btn-outline-danger\"><i class=\"fas fa-trash-can\"></i></button>";
            
            foreach ($actions as $action) {
                $output .= $action['callback']($row);
            }
            
            $output .= '</td>
            </tr>';
        }
        
        $output .= sprintf('</tbody>
    </table>
    <button id="create%1$sItem" class="btn btn-success">Create %1$s Item</button>
    <a class="btn btn-primary" href="/servertools/%2$s/export">Export</a>
    <button id="import%1$s" class="btn btn-warning">Import</button>
    <input type="file" id="import%1$sInput" style="display: none" accept=".csv">
    </div>
    ', $ucItemName, $itemName);
        
        $javascript = <<<JS
            $(document).ready(function () {
                const table = $('#${itemName}table').DataTable();
                
                ${select2Init}
                
                $('#create${ucItemName}Item').click(function() {
                    $('#${itemName}ItemTitle > b')[0].innerHTML = '';
                    ${varResets}
                    $('#${itemName}ItemModal').modal('show');
                });
            
                $('#${itemName}table').on('click', '.edit{$itemName}Item', function () {
                    $('#${itemName}ItemTitle > b')[0].innerHTML = $(this).data('id');
                    ${varLoading}
                    $('#${itemName}ItemModal').modal('show');
                });
            
                $('#${itemName}Save').click(function() {
                    ${varAssignments}
            
                    let saveButton = $(this);
                    saveButton.prop('disabled', true);
                    if (${varChecks}) {
                        alert('Please fill all fields with valid data!');
                        saveButton.prop('disabled', false);
                        return;
                    }
            
                    let data = {
                        ${varData}
                    }
            
                    $.ajax({
                        url: '/servertools/${itemName}/save',
                        type: 'POST',
                        data: data,
                    }).then(function(response) {
                        let button = $('.edit${itemName}Item[data-id="' + ID + '"]');
                        if (button.length > 0) {
                            let cells = button.parents('tr').children('td');
                            ${varCellData}
                            saveButton.prop('disabled', false);
                            table.row(button.parents('tr')).invalidate().draw(false);
                        } else {
                            location.reload()
                            //table.row.add(['ID VOM RESPOONSE', category.text(), shop.text(), cost, grank, tradeQuantity, maximumQuantity, boughtQuantity, roadFloors, fatalis]).draw();
                        }
            
                        $('#${itemName}ItemModal').modal('hide');
                    }).catch(function(response) {
                        alert(response.message);
                        saveButton.prop('disabled', false);
                    });
                });
            
                $('#${itemName}table').on('click', '.delete{$itemName}Item', function () {
                    let formdata = new FormData();
                    let itemId = $(this).attr('data-id');
                    formdata.append('item', itemId);
            
                    if (!window.confirm('Are you sure you want to delete the entry with the ID : ' + itemId)) {
                        return;
                    }
            
                    let rowToRemove = $(this).parents('tr');
            
                    $.ajax({
                        url: '/servertools/${itemName}/delete/' + itemId,
                        type: 'POST',
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
            
                $('#import${ucItemName}').click(function() {
                    if (!window.confirm('This will overwrite every Roadshop Item. Beware!')) {
                        return;
                    }
            
                    $('#import${ucItemName}Input').trigger('click');
                });
            
                $('#import${ucItemName}Input').change(function() {
                    let formdata = new FormData();
                    if($(this).prop('files').length <= 0) {
                        return;
                    }
            
                    let file =$(this).prop('files')[0];
                    formdata.append('${itemName}CSV', file);
            
                    $.ajax({
                        url: '/servertools/${itemName}/import',
                        type: 'POST',
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
            JS;
        
        $output .= sprintf('
    <script>
        $(document).ready(function () {
            $("#%stable").DataTable({
                "columnDefs": [
                    {"width": "20%%", "targets": 2},
                    {"width": "15%%", "targets": 1},
                ],
                language: {
                    %s
                }
            })
        });
    </script>
    <script>%s</script>
    </body>
</html>
', $itemName, $_SESSION['locale'] === 'ja_JP' ? '"url": "//cdn.datatables.net/plug-ins/1.12.1/i18n/ja.json"' : '', $javascript);
        
        return $output;
    }
    
    protected static function writeToFile($saveData, string $hexOffset, string $hexValue)
    {
        $handle = $saveData;
        $hexValue = strlen($hexValue) == 1 ? '0' . $hexValue : $hexValue;
        if (!is_resource($saveData)) {
            $handle = fopen('php://memory', 'br+');
            fwrite($handle, $saveData);
        }
        
        fseek($handle, hexdec($hexOffset));
        fwrite($handle, hex2bin($hexValue));
        rewind($handle);
        
        return $handle;
    }
    
    protected static function numberConvertEndian($number, $byteSize)
    {
        $hexChars = $byteSize * 2;
        $data = dechex((float)$number);
        
        $data = str_pad($data, $hexChars, '0', STR_PAD_LEFT);
        
        $unpack = unpack("H*", strrev(pack("H*", $data)));
        
        return strtoupper($unpack[1]);
    }
    
    protected static function stringToHex($string)
    {
        $output = "";
        foreach (mb_str_split($string) as $char) {
            $char = self::uniord($char);
            if ($char > 255) {
                $char = self::numberConvertEndian($char, 2);
            } else {
                $char = dechex($char);
            }
            $output .= sprintf("%02s", strtoupper($char));
        }
        
        return $output;
    }
    
    protected static function uniord($u)
    {
        $k = mb_convert_encoding($u, 'SJIS', 'UTF-8');
        $k1 = ord(substr($k, 0, 1));
        $k2 = ord(substr($k, 1, 1));
        
        return $k2 * 256 + $k1;
    }
    
    protected static function arrayOfModelsToCSVDownload($records, $name)
    {
        if (count($records)) {
            $handle = fopen('php://memory', 'w');
            
            /*
             * Really really smelly cheese to get names of protected properties!
             */
            fputcsv($handle, array_map(fn($value) => ltrim(substr($value, 2)), array_keys((array)$records[0])));
            foreach ($records as $record) {
                $data = (array)$record;
                foreach ($data as &$field) {
                    if ($field instanceof \DateTime) {
                        $field = $field->format('Y-m-d H:i');
                    } else {
                        if (is_resource($field)) {
                            $field = strtoupper(bin2hex(stream_get_contents($field)));
                        }
                    }
                }
                fputcsv($handle, $data);
            }
            rewind($handle);
            ResponseService::SendDownloadResource($handle, $name . '.csv');
        }
    }
    
    protected static function importFromCSV($uploadName, $model, $deleteQuery)
    {
        $lines = preg_split('/\r\n|\r|\n/', file_get_contents($_FILES[$uploadName]["tmp_name"]));
        $attributes = str_getcsv($lines[0]);
        unset($lines[0]);
        $em = EM::getInstance();
        foreach ($lines as $line) {
            if ($line == "") {
                continue;
            }
            
            $lineValues = str_getcsv($line);
            $item = new $model();
            foreach ($attributes as $key => $attribute) {
                $setter = "set" . implode('', array_map('ucfirst', explode('_', $attribute)));
                $item->$setter($lineValues[$key]);
            }
            $em->persist($item);
        }
        
        $em->createQuery($deleteQuery)->execute();
        $em->flush();
        
        ResponseService::SendOk();
    }
}
