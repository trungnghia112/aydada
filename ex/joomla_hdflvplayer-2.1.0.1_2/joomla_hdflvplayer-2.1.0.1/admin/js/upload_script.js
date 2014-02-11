/**
 * @name 	        hdflvplayer
 ** @version	        2.1.0.1
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @subpackage	        hdflvplayer
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2011 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	com_hdflvplayer installation file.
 ** @Creation Date	23 Feb 2011
 ** @modified Date	28 Aug 2013
 */
var uploadqueue = [];
var uploadmessage = '';
function addQueue(whichForm) {

	uploadqueue.push(whichForm);
	if (uploadqueue.length == 1) {
		processQueue();
	} else {
		holdQueue();
	}
}
function processQueue() {
	if (uploadqueue.length > 0) {
		form_handler = uploadqueue[0];
		setStatus(form_handler, 'Uploading');
		submitUploadForm(form_handler);
	}
}
function holdQueue() {
	form_handler = uploadqueue[uploadqueue.length - 1];
	setStatus(form_handler, 'Queued');
}
function updateQueue(statuscode, statusmessage, outfile) {

	uploadmessage = statusmessage;
	form_handler = uploadqueue[0];
	if (statuscode == 0) {

		document.getElementById(form_handler + "-value").value = outfile;
	}

	setStatus(form_handler, statuscode);
	uploadqueue.shift();
	processQueue();

}
function submitUploadForm(form_handle) {
	document.forms[form_handle].target = "uploadvideo_target";
	documentBasePath = document.location.href;

	if (documentBasePath.indexOf('?') != -1)
		documentBasePath = documentBasePath.substring(0, documentBasePath
				.indexOf('?'));
	if (documentBasePath.indexOf('administrator') == -1) {
		baseURL = documentBasePath + "/administrator";
	} else {
		if (documentBasePath.lastIndexOf('administrator/') == -1) {
			baseURL = documentBasePath;
		} else {
			documentBasePath = documentBasePath.substring(0, documentBasePath
					.lastIndexOf('/'));
			baseURL = documentBasePath;
		}
	}
	document.forms[form_handle].action = baseURL
			+ "/index.php?option=com_hdflvplayer&tmpl=component&layout=editvideoupload&task=uploadfile&processing=1";
	document.forms[form_handle].submit();
}
function setStatus(form_handle, status) {
	switch (form_handle) {
	case "normalvideoform":
		divprefix = 'f1';
		break;
	case "hdvideoform":
		divprefix = 'f2';
		break;
	case "thumbimageform":
		divprefix = 'f3';
		break;
	case "previewimageform":
		divprefix = 'f4';
		break;
	case "ffmpegform":
		divprefix = 'f5';
		break;
	case "rollform":
		divprefix = 'f6';
		break;
	}
	switch (status) {
	case "Queued":
		document.getElementById(divprefix + "-upload-form").style.display = "none";
		document.getElementById(divprefix + "-upload-progress").style.display = "";
		document.getElementById(divprefix + "-upload-status").innerHTML = "Queued";
		document.getElementById(divprefix + "-upload-message").style.display = "none";
		document.getElementById(divprefix + "-upload-filename").innerHTML = document.forms[form_handle].myfile.value;
		document.getElementById(divprefix + "-upload-image").src = 'components/com_hdflvplayer/images/empty.gif';
		break;

	case "Uploading":
		document.getElementById(divprefix + "-upload-form").style.display = "none";
		document.getElementById(divprefix + "-upload-progress").style.display = "";
		document.getElementById(divprefix + "-upload-status").innerHTML = "Uploading";
		document.getElementById(divprefix + "-upload-message").style.display = "none";
		document.getElementById(divprefix + "-upload-filename").innerHTML = document.forms[form_handle].myfile.value;
		document.getElementById(divprefix + "-upload-image").src = 'components/com_hdflvplayer/images/loader.gif';
		break;
	case "Retry":
	case "Cancelled":
		document.getElementById(divprefix + "-upload-form").style.display = "";
		document.getElementById(divprefix + "-upload-progress").style.display = "none";
		document.forms[form_handle].myfile.value = '';
		enableUpload(form_handle);
		break;

	case 0:
		document.getElementById(divprefix + "-upload-image").src = 'components/com_hdflvplayer/images/success.gif';
		document.getElementById(divprefix + "-upload-status").style.display = 'none';
		document.getElementById(divprefix + "-upload-message").style.display = "";
		document.getElementById(divprefix + "-upload-message").style.color = "green";
		document.getElementById(divprefix + "-upload-message").innerHTML = '<b>Upload Status :</b>'
				+ uploadmessage;
		document.getElementById(divprefix + "-upload-cancel").innerHTML = '';
		break;

	default:
		document.getElementById(divprefix + "-upload-image").src = 'components/com_hdflvplayer/images/error.gif';
		document.getElementById(divprefix + "-upload-status").style.display = 'none';
		document.getElementById(divprefix + "-upload-message").style.display = "";
		document.getElementById(divprefix + "-upload-message").style.color = "red";
		document.getElementById(divprefix + "-upload-message").innerHTML = '<b>Upload Status :</b>'
				+ uploadmessage
				+ " <a href=javascript:setStatus('"
				+ form_handle + "','Retry')><b>Retry</b></a>";
		document.getElementById(divprefix + "-upload-cancel").innerHTML = '';
		break;
	}

}

function enableUpload(whichForm) {
	if (document.forms[whichForm].myfile.value != '')
		document.forms[whichForm].uploadBtn.disabled = "";
	else
		document.forms[whichForm].uploadBtn.disabled = "disabled";
}

function cancelUpload(whichForm) {
	document.getElementById('uploadvideo_target').src = '';
	setStatus(whichForm, 'Cancelled');
	pos = uploadqueue.lastIndexOf(whichForm);
	if (pos == 0) {

		uploadqueue.shift();
		processQueue();

	} else {
		uploadqueue.splice(pos, 1);
	}

}
