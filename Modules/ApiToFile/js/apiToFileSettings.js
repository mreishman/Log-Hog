function updateJsonStringOfApiToFileSettings()
{
	updateJsonStringOfFilePathAlternativesMain('apiToFileInnerSettingsBC', 'addNewRowToThisForApiToFiles');
}

function addNewRequestApiToFileSettings()
{
	let groupId = 'apiToFileSettingsGroup';
	let tableId = 'addNewRowToThisForApiToFiles';
	let inputId = 'apiToFileInnerSettingsBC';
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
	let inputId = 'apiToFileInnerSettingsBC';
	removeFilePathAlternativeRowBase(rowNumber, groupId, tableId, inputId);
}