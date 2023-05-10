var nestedModalObjects = {};

function openNestedModalWithData(nestedModalId, selectElement) {
    // Replace all "Modal" from the nested modal id instead of just the last one using regex object
    let mainModalSelectId = nestedModalId.replace(/Modal$/g, '');
    let selectedOption = $(selectElement).find(':selected');
    let itemId = selectedOption.val();
    let itemData = {};

    //If itemId is undefined, return
    if (!itemId) {
        return;
    }

    // Set the 'editing' flag to true
    $('#' + nestedModalId).data('editing', true);

    // Fill the nested modal with the data of the selected option if there is any. If not, its a second level nested modal and does neet to take the data from the father nested modal
    if (nestedModalObjects[mainModalSelectId] && nestedModalObjects[mainModalSelectId][itemId]) {
        itemData = nestedModalObjects[mainModalSelectId][itemId];
    } else {
        let currentModalName = mainModalSelectId.replace(/.*?Modal/g, '');
        let fatherDataName = nestedModalId.replace('Modal' + currentModalName + 'Modal', '');
        let fatherId = $('#' + fatherDataName).find(':selected').val();
        itemData = nestedModalObjects[fatherDataName][fatherId][currentModalName][itemId];
    }
    for (let fieldId in itemData) {
        let inputField = $('#' + nestedModalId).find('#' + nestedModalId + fieldId.replace(' ', ''));
        if (inputField.attr('type') === 'checkbox') {
            inputField.prop('checked', itemData[fieldId] === '1');
        } else if (inputField.is('select') && inputField.attr('size')) {
            inputField.empty();
            let optionData = itemData[fieldId];
            for (let option in optionData) {
                let newOption = $('<option></option>').text(getOptionText(optionData[option]));
                //Setting the value of the select element to the next free id in the select
                newOption.val(inputField.find('option').length);
                inputField.append(newOption);
                inputField.val(optionData.id);
            }
        } else {
            inputField.val(itemData[fieldId]);
        }
    }

    // Show the nested modal
    $('#' + nestedModalId).modal('show');
}

function getOptionText(itemData) {
    let fields = Object.keys(itemData);
    let text = '';

    for (let i = 0; i < Math.min(2, fields.length); i++) {
        if (i > 0) {
            text += ' - ';
        }
        if (i === 0 && !itemData[fields[i]]) {
            text += 'New';
        } else {
            text += itemData[fields[i]];
        }
    }

    return text;
}

function closeNestedModal(modalId) {
    // Clear all input fields in the nested modal
    let modal = $('#' + modalId);
    modal.find('input, select').val('');
    //Also clear the select element in the nested modal if it has the size attribute
    modal.find('select[size]').empty();

    modal.modal('hide');
}

function addItemToNestedModal(modalId) {
    // Open the nested modal for adding a new item
    $('#' + modalId).modal('show');
    // Set a flag to indicate adding a new item
    $('#' + modalId).data('editing', false);
}
function editItemInNestedModal(modalId) {
    // Get the selected option in the main modal
    let selectedOption = $('#' + modalId.replace(/Modal$/g, '')).find(':selected');
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
    modalId = modalId.replace(/Modal$/g, '');
    let selectedOption = $('#' + modalId).find(':selected');

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

    let mainModalSelectId = modalId.replace(/Modal$/g, '');
    let itemId = $('#' + mainModalSelectId).find(':selected').val();;

    let currentModalName = mainModalSelectId.replace(/.*?Modal/g, '');
    let fatherDataName = mainModalSelectId.replace('Modal' + currentModalName, '');
    let fatherId = $('#' + fatherDataName).find(':selected').val();



    // Get the field data from the nested modal, else if the field is a select element with the size attribute, do nothing
    $('#' + modalId).find('input, select').each(function () {
        let fieldId = $(this).attr('id').replace(modalId, '').replace('ItemModal', '');
        if ($(this).attr('type') === 'checkbox') {
            itemData[fieldId] = $(this).prop('checked') ? '1' : '0';
        } else if($(this).is('select') && $(this).attr('size')) {
            itemData[fieldId] = nestedModalObjects[fatherDataName][fatherId][fieldId];
        } else {
            itemData[fieldId] = $(this).val();
        }
    });

    // Count how many times "Modal" appears in the modal id
    let modalCount = modalId.match(/Modal/g).length;

    // Remove all instances of "Modal" in the modal id using regex object
    let nestedDataId = modalId.replace(/Modal$/g, '');

    if (!nestedModalObjects[nestedDataId] && modalCount <= 1) {
        nestedModalObjects[nestedDataId] = {};
    }



    if (isEditing) {
        // Editing an existing item

        if (modalCount <= 1) {
            nestedModalObjects[nestedDataId][itemId] = itemData;
        } else {
            nestedModalObjects[fatherDataName][fatherId][currentModalName][itemId] = itemData;
        }

        // Update the text of the selected option in the main modal's select element
        let selectedOption = $('#' + mainModalSelectId).find(':selected');
        selectedOption.text(getOptionText(itemData));
    } else {
        // Adding a new item
        //todo: redo nestedDataId as it points to: GachaShopEntriesModalItems instead of


        if (modalCount <= 1) {
            itemId = nestedModalObjects[nestedDataId].lastIndexOf(nestedModalObjects[nestedDataId].slice(-1)[0]);
            nestedModalObjects[nestedDataId][itemId] = itemData;
        } else {
            itemId = Math.max(...Object.keys(nestedModalObjects[fatherDataName][fatherId][currentModalName]).map(Number)) + 1;
            nestedModalObjects[fatherDataName][fatherId][currentModalName][itemId] = itemData;
        }

        // Add the new item to the main modal's select element
        let optionText = getOptionText(itemData);
        let option = $('<option>').val(itemId).text(optionText);
        $('#' + mainModalSelectId).append(option);
    }
    // Clear all input fields in the nested modal
    $('#' + modalId).find('input, select').val('');
    // Close the nested modal
    $('#' + modalId).modal('hide');
}

function deepRemoveWhitespaceFromKeys(obj) {
    if (typeof obj !== 'object' || obj === null) {
        return obj;
    }

    if (Array.isArray(obj)) {
        return obj.map(deepRemoveWhitespaceFromKeys);
    }

    return Object.keys(obj).reduce((acc, key) => {
        acc[key.replace(/\s+/g, '')] = deepRemoveWhitespaceFromKeys(obj[key]);
        return acc;
    }, {});
}
