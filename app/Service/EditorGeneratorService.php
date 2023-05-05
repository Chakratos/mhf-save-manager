<?php


namespace MHFSaveManager\Service;


/**
 *
 */
class EditorGeneratorService
{
    /**
     * @param string $pageTitle
     * @param string $itemName
     * @param array $modalFieldInfo
     * @param array $data
     * @param array $actions
     * @return string
     */
    public static function generateDynamicTable(
        string $pageTitle,
        string $itemName,
        array $modalFieldInfo,
        array $fieldPositions,
        array $data,
        array $actions = []
    ): string {
        $pageLayout = self::createPageLayout($pageTitle, $itemName);
        $modal = self::generateModalBack($modalFieldInfo, $fieldPositions, $itemName);
        $table = self::generateTable($modalFieldInfo, $data, $actions, $itemName);
        $javascript = self::generateJavascript($modalFieldInfo, $itemName);
        
        return $pageLayout . $modal . $table . $javascript;
    }
    
    /**
     * @param string $pageTitle
     * @param string $itemName
     * @return string
     */
    private static function createPageLayout(string $pageTitle, string $itemName): string
    {
        ob_start();
        include __DIR__ . '/../views/head.php';
        $head = ob_get_clean();
        include __DIR__ . '/../views/topnav.php';
        $topnav = ob_get_clean();
    
        return sprintf('<html lang="en">
            <head>
                <title>%s</title>
                <link rel="stylesheet" href="/css/char-edit.css">
                %s
            </head>
            <body>%s', $pageTitle, $head, $topnav);
    }
    
    /**
     * @param array $modalFieldInfo
     * @param array $fieldPositions
     * @param string $itemName
     * @return string
     */
    public static function generateModalBack(array $modalFieldInfo, array $fieldPositions, string $itemName): string
    {
        $output = '';
    
        $modalSizeClass = '';
        if (count($fieldPositions) > 4) {
            $modalSizeClass = 'modal-xl';
        } elseif (count($fieldPositions) > 2) {
            $modalSizeClass = 'modal-lg';
        }
    
        // Generate the modal
        $output .= <<<HTML
            <div id="{$itemName}ItemModal" class="modal fade" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered {$modalSizeClass}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="{$itemName}ItemTitle">Editing {$itemName} Item: <b></b></h5>
                        </div>
                        <div class="modal-body">
            HTML;
    
        // Check for headline index and render it in a new row
        if (isset($fieldPositions['headline'])) {
            $key = $fieldPositions['headline'];
            $field = $modalFieldInfo[$key];
            $output .= '<div class="row">';
            $output .= '<div class="col">';
            $output .= self::generateFieldHTML($key, $field, $itemName);
            $output .= '</div>'; // Close the col
            $output .= '</div>'; // Close the row
        }
    
        $output .= '<div class="row">';
    
        foreach ($fieldPositions as $column) {
            if (!is_array($column)) {
                continue;
            }
            $output .= '<div class="col">';
        
            foreach ($column as $key) {
                $field = $modalFieldInfo[$key];
                $output .= self::generateFieldHTML($key, $field, $itemName);
            }
        
            $output .= '</div>'; // Close the column
        }
    
        $output .= '</div>'; // Close the row
    
        $output .= <<<HTML
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeNestedModal('{$itemName}ItemModal')">Close</button>
            <button type="button" class="btn btn-primary" id="{$itemName}Save">Save</button>
        </div>
    </div>
</div>
</div>
HTML;
    
        return $output;
    }
    
    /**
     * @param string $key
     * @param array $field
     * @param string $itemName
     * @return string
     */
    public static function generateFieldHTML(string $key, array $field, string $itemName): string
    {
        $idKey = str_replace(' ', '', $key);
        $output = '';
        $inputType = '';
        
        switch ($field['type']) {
            case 'Int':
                $inputType = 'number';
                break;
            case 'Hidden':
                $inputType = 'hidden';
                break;
            case 'Modal':
                $nestedModalFieldInfo = $field['modalFieldInfo'];
                $nestedFieldPositions = $field['fieldPositions'];
                $nestedModalName = "{$itemName}{$idKey}Modal";
                $output .= "<select size=\"7\" class=\"form-control\" id=\"{$itemName}{$idKey}\"></select>";
                $output .= "<div><button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"addItemToNestedModal('{$nestedModalName}ItemModal')\">+</button>";
                $output .= "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"removeItemFromNestedModal('{$nestedModalName}ItemModal')\">-</button></div>";
                $output .= self::generateModalBack($nestedModalFieldInfo, $nestedFieldPositions, $nestedModalName);
                break;
            default:
                $inputType = 'text';
                break;
        }
        
        if ($inputType !== 'hidden') {
            $output .= "<h6>{$key}:</h6>";
        }
        
        $output .= "<div class=\"input-group mb-2\">";
        
        if ($field['type'] === 'Array') {
            $output .= "<select class=\"form-control\" id=\"{$itemName}{$idKey}\">";
            foreach ($field['options'] as $id => $option) {
                $output .= sprintf('<option value="%s">%s</option>', $id, is_array($option) ? sprintf('[%s] %s', $id, $option['name']) : $option);
            }
            $output .= '</select>';
        } elseif ($field['type'] !== 'Modal') {
            $disabled = !empty($field['disabled']) ? 'disabled="disabled"' : '';
            $placeholder = !empty($field['placeholder']) ? 'placeholder="' . $field['placeholder'] . '"' : '';
            $min = !empty($field['min']) ? 'min="' . $field['min'] . '"' : '';
            $max = !empty($field['max']) ? 'max="' . $field['max'] . '"' : '';
            $output .= "<input {$min} {$max} {$disabled} {$placeholder} type=\"{$inputType}\" class=\"form-control\" id=\"{$itemName}{$idKey}\">";
        }
        
        $output .= '</div>';
        
        return $output;
    }
    
    /**
     * @param array $modalFieldInfo
     * @param array $data
     * @param array $actions
     * @param string $itemName
     * @return string
     */
    private static function generateTable(array $modalFieldInfo, array $data, array $actions, string $itemName): string {
        $ucItemName = ucfirst($itemName);
        
        // Generate the table
        $output = "<div class=\"container\">
    <table id=\"{$itemName}table\" class=\"table table-striped table-bordered\" style=\"width:100%\">
        <thead>
        <tr>";
    
        foreach ($modalFieldInfo as $field => $type) {
            if ($type['type'] !== 'Modal') {
                $output .= "<th>{$field}</th>";
            }
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
                } elseif ($type['type'] !== 'Modal') {
                    $output .= "<td>{$row[$field]}</td>";
                }
            }
        
            $output .= '<td>';
            $varEditData = '';
        
            foreach ($row as $key => $value) {
                if (is_array($value)) {
                    $varEditData .= sprintf(' data-%s="%s"', str_replace(' ', '', $key), $value['id']);
                } else {
                    $varEditData .= sprintf(' data-%s="%s"', str_replace(' ', '', $key), $value);
                }
            
            }
        
            $output .= "<button{$varEditData} class=\"edit{$itemName}Item btn btn-sm btn-outline-success\"><i class=\"fas fa-pencil\"></i></button>";
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
        
            return $output;
    }
    
    /**
     * @param array $modalFieldInfo
     * @param string $itemName
     * @return string
     */
    private static function generateJavascript(array $modalFieldInfo, string $itemName): string {
        $ucItemName = ucfirst($itemName);
        $output = '';
        
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
    
$javascript = <<<JS
    var nestedModalObjects = {};

    function closeNestedModal(modalId) {
        $('#' + modalId).modal('hide');
    }
    
    function addItemToNestedModal(modalId) {
        // Open the nested modal for adding a new item
        console.log(modalId);
        console.log($('#' + modalId));
        $('#' + modalId).modal('show');
        // Set a flag to indicate adding a new item
        $('#' + modalId).data('editing', false);
    }
    function editItemInNestedModal(modalId) {
        // Get the selected option in the main modal
        let selectedOption = $('#' + modalId.replace('Modal', '')).find(':selected');
        if (!selectedOption.length) {
            alert('Please select an item to edit.');
            return;
        }
        // Load the selected item's data into the nested modal
        let itemId = selectedOption.val();
        let itemData = nestedModalObjects[modalId][itemId];
        for (let key in itemData) {
            $('#' + modalId + key.replace(' ', '')).val(itemData[key]);
        }
        // Open the nested modal for editing an existing item
        $('#' + modalId).modal('show');
        // Set a flag to indicate editing an existing item
        $('#' + modalId).data('editing', true);
    }
    function removeItemFromNestedModal(modalId) {
        // Remove the selected item from the nested modal
        let selectElement = $('#' + modalId.replace('Modal', ''));
        let selectedOption = selectElement.find(':selected');
        if (!selectedOption.length) {
            alert('Please select an item to delete.');
            return;
        }
        let itemId = selectedOption.val();
        delete nestedModalObjects[modalId][itemId];
        selectedOption.remove();
    }
    function saveNestedModal(modalId) {
        // Save the changes made in the nested modal and update the main modal
        let isEditing = $('#' + modalId).data('editing');
        let itemData = {};
    
        // Get the field data from the nested modal
        $('#' + modalId).find('input, select').each(function () {
            let fieldId = $(this).attr('id').replace(modalId, '');
            itemData[fieldId] = $(this).val();
        });
    
        if (!nestedModalObjects[modalId]) {
            nestedModalObjects[modalId] = {};
        }
    
        let itemId;
        if (isEditing) {
            // Editing an existing item
            itemId = $('#' + modalId.replace('Modal', '')).find(':selected').val();
            nestedModalObjects[modalId][itemId] = itemData;
        } else {
            // Adding a new item
            itemId = Object.keys(nestedModalObjects[modalId]).length + 1;
            nestedModalObjects[modalId][itemId] = itemData;
            // Add the new item to the main modal's select element
            let option = $('<option>').val(itemId).text(itemData['ID'] + ' - ' + itemData['Name']);
            $('#' + modalId.replace('Modal', '')).append(option);
        }
    
        // Close the nested modal
        $('#' + modalId).modal('hide');
    }
    
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
                nestedObjects: nestedModalObjects
            }
    
            $.ajax({
                url: '/servertools/${itemName}/save',
                type: 'POST',
                data: data
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
}
