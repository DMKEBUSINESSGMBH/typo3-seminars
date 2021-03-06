/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/*
 * This file provides some JavaScript functions for the seminars front-end
 * editor and the registration form.
 *
 * @package TYPO3
 * @subpackage tx_seminars
 *
 * @author Saskia Metzler <saskia@merlin.owl.de>
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 * @author Niels Pardon <mail@niels-pardon.de>
 */

var TYPO3 = TYPO3 || {};
TYPO3.seminars = {};

/**
 * Marks the current attachment as deleted if the confirm becomes submitted.
 *
 * @param {String} listItemId
 *        ID of the list item with the attachment to delete, must not be empty
 * @param {String} confirmMessage
 *        localized confirm message for whether really to mark an attachment for
 *        deletion
 */
function markAttachmentAsDeleted(listItemId, confirmMessage) {
	var listItem = document.getElementById(listItemId);
	var deleteButton = document.getElementById(listItemId + "_button");

	if (confirm(confirmMessage)) {
		document.getElementById("tx_seminars_pi1_seminars_delete_attached_files").value
			+= "," + listItem.firstChild.nodeValue;
		listItem.setAttribute("class", "deleted");
		deleteButton.disabled = true;
	}
}

/**
 * Collects the names from the first/last name field pairs and compiles/inserts
 * them into the human-readable "additional attendees" field and the machine-readable
 * "structured attendees" field.
 */
function compileNames() {
	var humanReadableField = $("tx_seminars_pi1_registration_editor_attendees_names");
	var machineReadableField = $("tx_seminars_pi1_registration_editor_structured_attendees_names");

	if (!humanReadableField || !machineReadableField) {
		 return;
	}

	var firstNames = $$("#tx_seminars_pi1_registration_editor_separate_names "
		+ ".tx_seminars_pi1_registration_editor_first_name");
	var lastNames = $$("#tx_seminars_pi1_registration_editor_separate_names "
		+ ".tx_seminars_pi1_registration_editor_last_name");
	var positions = $$("#tx_seminars_pi1_registration_editor_separate_names "
		+ ".tx_seminars_pi1_registration_editor_position");
	var eMailAddresses = $$("#tx_seminars_pi1_registration_editor_separate_names "
		+ ".tx_seminars_pi1_registration_editor_attendee_email");

	if (firstNames.length != lastNames.length) {
		return;
	}

	var humanReadableNames = "";
	var machineReadableNames = [];

	var numberOfLines = firstNames.length;

	for (var i = 0; i < numberOfLines; i++) {
		var firstName = firstNames[i].value.strip();
		var lastName = lastNames[i].value.strip();

		if ((firstName.empty()) && (lastName.empty())) {
			continue;
		}

		var position = "";
		if (i < positions.length) {
			position = positions[i].value.strip();
		}

		var eMailAddress = "";
		if (i < eMailAddresses.length) {
			eMailAddress = eMailAddresses[i].value.strip();
		}

		var fullName = (firstName + " " + lastName).strip();
		if (!humanReadableNames.empty()) {
			humanReadableNames += "\r\n";
		}
		humanReadableNames += fullName;

		if (!position.empty()) {
			humanReadableNames += ", " + position;
		}
		if (!eMailAddress.empty()) {
			humanReadableNames += ", " + eMailAddress;
		}

		machineReadableNames[i] = [firstName, lastName, position, eMailAddress];
	}

	humanReadableField.value = humanReadableNames;
	machineReadableField.value = machineReadableNames.toJSON();
}

/**
 * Restores the separate name fields from the hidden field with the names
 * in a JSON-encoded array.
 */
function restoreSeparateNameFields() {
	var machineReadableField = $("tx_seminars_pi1_registration_editor_structured_attendees_names");

	if (!machineReadableField || machineReadableField.value.empty()
		|| !machineReadableField.value.isJSON()) {
		return;
	}

	var firstNames = $$("#tx_seminars_pi1_registration_editor_separate_names "
		+ ".tx_seminars_pi1_registration_editor_first_name");
	var lastNames = $$("#tx_seminars_pi1_registration_editor_separate_names "
		+ ".tx_seminars_pi1_registration_editor_last_name");
	var positions = $$("#tx_seminars_pi1_registration_editor_separate_names "
		+ ".tx_seminars_pi1_registration_editor_position");
	var eMailAddresses = $$("#tx_seminars_pi1_registration_editor_separate_names "
		+ ".tx_seminars_pi1_registration_editor_attendee_email");

	if (firstNames.length != lastNames.length) {
		return;
	}

	var allNames = machineReadableField.value.evalJSON(true);
	var numberOfNames = Math.min(firstNames.length, allNames.length);

	for (var i = 0; i < numberOfNames; i++) {
		firstNames[i].value = allNames[i][0];
		lastNames[i].value = allNames[i][1];
		if (positions[i]) {
			positions[i].value = allNames[i][2];
		}
		if (eMailAddresses[i]) {
			eMailAddresses[i].value = allNames[i][3];
		}
	}
}

/**
 * Adds or drops name fields to match the number of selected seats.
 */
function fixNameFieldsNumber() {
	var neededNameLines = getNumberOfNeededNameFields();
	var nameLines = $$("#tx_seminars_pi1_registration_editor_separate_names "
		+ ".tx_seminars_pi1_registration_editor_name_line");

	if (nameLines.length < neededNameLines) {
		var nameLineTemplate =
			$$("#tx_seminars_pi1_registration_editor_name_template "
				+".tx_seminars_pi1_registration_editor_name_line")[0];
		var nameLinesContainer =
			$("tx_seminars_pi1_registration_editor_separate_names");

		for (var i = nameLines.length; i < neededNameLines; i++) {
			nameLinesContainer.appendChild(nameLineTemplate.cloneNode(true));
		}
	} else if (nameLines.length > neededNameLines) {
		for (var i = nameLines.length; i > neededNameLines; i--) {
			nameLines[i - 1].remove();
		}
	}
}

/**
 * Gets the number of needed name fields.
 *
 * @return {Number} the number of needed name fields, will be >= 0
 */
function getNumberOfNeededNameFields() {
	var seatsSelector = $("tx_seminars_pi1_registration_editor_seats");
	if (!seatsSelector) {
		return 0;
	}

	var seats = parseInt(seatsSelector.value);

	var myselfSelector
		= $("tx_seminars_pi1_registration_editor_registered_themselves");
	var selfSeat;
	if (myselfSelector) {
		selfSeat = myselfSelector.checked ? 1 : 0;
	} else {
		selfSeat = 1;
	}

	return seats - selfSeat;
}

/**
 * Updates an auxiliary record after it has been edited in the FE editor.
 *
 * @param {String} htmlId
 *        the HTML ID of the auxiliary record checkbox label to update, must not
 *        be empty
 * @param {String} title the title of the auxiliary record, must not be empty
 */
function updateAuxiliaryRecordInEditor(htmlId, title) {
	var label = $(htmlId);
	if (!label) {
		return;
	}

	label.innerHTML = title;
}

/**
 * Appends an auxiliary record as a checkbox so that it is available for
 * selection in the FE editor.
 *
 * @param {Number} uid the UID of the record to add, must be > 0
 * @param {String} title the title of the record, must not be empty
 * @param {String} htmlName
 *        the relevant part of the IDs and names for the selection elements,
 *        e.g. "place", "speaker" or "tutor".
 * @param {Array} buttonData the data of the edit button of the record
 */
function appendAuxiliaryRecordInEditor(uid, title, htmlName, buttonData) {
	// FIXME: gibt es dafür was im Wrapper??
	var container = $$("#tx_seminars_pi1_seminars_" + htmlName + " tbody")[0];
	if (!container) {
		return;
	}
	var nextOptionNumber
		= $$("#tx_seminars_pi1_seminars_" + htmlName + " input").length;

	var id = "tx_seminars_pi1_seminars_" + htmlName + "_" + nextOptionNumber;
	var input = new Element("input", {
		"id": id, "type": "checkbox", "value": uid,
		"name" :
			"tx_seminars_pi1_seminars[" + htmlName + "][" + nextOptionNumber + "]",
		"class" : "tx-seminars-pi1-event-editor-checkbox"
	});
	var labelId = "tx_seminars_pi1_seminars_" + htmlName + "_label_" + uid;
	var label = new Element("label", {"for": id, "id": labelId});
	label.appendChild(document.createTextNode(title));

	var button = new Element(
		"input",
		{
			"type": "button",
			"name": buttonData.name,
			"value": buttonData.value,
			"id": buttonData.id,
			"class": "tx-seminars-pi1-event-editor-edit-button"
		}
	);

	var tableRow = new Element("tr");
	var tableColumnLeft = new Element("td");
	var tableColumnRight = new Element("td");

	tableColumnLeft.appendChild(input);
	tableColumnLeft.appendChild(label);
	tableColumnRight.appendChild(button);
	tableRow.appendChild(tableColumnLeft);
	tableRow.appendChild(tableColumnRight);

	container.appendChild(tableRow);
}

/**
 * Appends a place so that it is available for selection in the FE editor.
 *
 * @param {Number} uid the UID of the place to add, must be > 0
 * @param {String} title the title of the place, must not be empty
 * @param {Array} buttonData the data of the edit button of the place
 */
function appendPlaceInEditor(uid, title, buttonData) {
	appendAuxiliaryRecordInEditor(uid, title, "place", buttonData);
}

/**
 * Appends a speaker so that it is available for selection in the FE editor.
 *
 * @param {Number} uid the UID of the speaker to add, must be > 0
 * @param {String} title the name of the speaker, must not be empty
 * @param {Array} buttonData the data of the edit button of the speaker
 */
function appendSpeakerInEditor(uid, title, buttonData) {
	appendAuxiliaryRecordInEditor(uid, title, "speakers", buttonData);
	appendAuxiliaryRecordInEditor(uid, title, "leaders", buttonData);
	appendAuxiliaryRecordInEditor(uid, title, "partners", buttonData);
	appendAuxiliaryRecordInEditor(uid, title, "tutors", buttonData);
}

/**
 * Appends a checkbox so that it is available for selection in the FE editor.
 *
 * @param {Number} uid the UID of the checkbox to add, must be > 0
 * @param {String} title the title of the checkbox, must not be empty
 * @param {Array} buttonData the data of the edit button of the checkbox
 */
function appendCheckboxInEditor(uid, title, buttonData) {
	appendAuxiliaryRecordInEditor(uid, title, "checkboxes", buttonData);
}

/**
 * Appends a target group so that it is available for selection in the FE editor.
 *
 * @param {Number} uid the UID of the target group to add, must be > 0
 * @param {String} title the title of the target group, must not be empty
 * @param {Array} buttonData the data of the edit button of the target group
 */
function appendTargetGroupInEditor(uid, title, buttonData) {
	appendAuxiliaryRecordInEditor(uid, title, "target_groups", buttonData);
}

/**
 * Clears the selection of the search widget.
 */
function clearSearchWidgetFields() {
	var prefix = 'tx_seminars_pi1';
	var textElements = ['sword', 'search_age', 'price_from', 'price_to'];
	for (var i = 0; i < textElements.length; i++) {
		var textElement = document.getElementById(prefix + '_' + textElements[i]);
		if (textElement) {
			textElement.value = null;
		}
	}

	var suffixes = ['from_day', 'from_month', 'from_year', 'to_day', 'to_month',
		'to_year', 'event_type', 'language', 'country', 'city', 'place', 'date',
		'organizer', 'categories'
	];

	for (var i = 0; i < suffixes.length; i++) {
		var suffix = suffixes[i];
		var element = document.getElementById(prefix + '-' + suffix);
		if (element) {
			for (var j = 0; j < element.options.length; j++) {
				element.options[j].selected = false;
			}
		}
	}
}

/**
 * Converts the links that have a data-method="post" to JavaScript-powered on-the-fly forms.
 */
TYPO3.seminars.convertActionLinks = function() {
	var linkElements = document.querySelectorAll('a[data-method]');
	for (var i = 0; i < linkElements.length; i++) {
		linkElements[i].onclick = TYPO3.seminars.executeLinkAction;
	}
};

/**
 * Executes the action on a link.
 *
 * @param {MouseEvent} event
 */
TYPO3.seminars.executeLinkAction = function(event) {
	var linkElement = event.target
	var linkHref = linkElement.getAttribute('href');

	TYPO3.seminars.disableAllActionLinks();

	var formElement = document.createElement("form");
	formElement.style.display = 'none';
	formElement.setAttribute('method', 'post');
	formElement.setAttribute('action', linkHref);

	for (var j = 0; j < linkElement.attributes.length; j++) {
		var attribute = linkElement.attributes[j];
		var name = attribute.name;
		if (/^data-post-/.test(name)) {
			var dataParts = name.split('-');
			var inputElement = document.createElement('input');
			inputElement.setAttribute('type', 'hidden');
			inputElement.setAttribute('name', dataParts[2] + '[' + dataParts[3] + ']');
			inputElement.setAttribute('value', attribute.value);
			formElement.appendChild(inputElement);
		}
	}

	linkElement.appendChild(formElement);
	formElement.submit();

	return false;
};

/**
 * Disables all action links (so that they cannot be clicked again once an action is being processed).
 */
TYPO3.seminars.disableAllActionLinks = function() {
	var linkElements = document.querySelectorAll('a[data-method]');
	for (var i = 0; i < linkElements.length; i++) {
		linkElements[i].onclick = function () {
			return false;
		};
	}
};
