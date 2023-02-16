function updateJsonStringOfApiToFileSettings()
{
	updateJsonStringOfFilePathAlternativesMain('apiToFileInnerSettings', 'addNewRowToThisForApiToFiles');
}

function addNewRequestApiToFileSettings()
{
	let groupId = 'apiToFileSettingsGroup';
	let tableId = 'addNewRowToThisForApiToFiles';
	let inputId = 'apiToFileInnerSettings';
	let values = [
		{type: "store_hash", val: ""},
		{type: "auth_token", val: ""},
		{type: "severity", val: ""},
		{type: "output", val: ""}
	];
	addNewFilePathAlternativeRowBase(-1, values, groupId, tableId, inputId);
}

function removeRequestApiToFileSettingsRow(rowNumber)
{
	let groupId = 'apiToFileSettingsGroup';
	let tableId = 'addNewRowToThisForApiToFiles';
	let inputId = 'apiToFileInnerSettings';
	removeFilePathAlternativeRowBase(rowNumber, groupId, tableId, inputId);
}