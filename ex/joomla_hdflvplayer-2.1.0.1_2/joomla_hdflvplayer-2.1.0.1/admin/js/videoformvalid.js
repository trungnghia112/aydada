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

// Function for validation
function submitbutton(pressbutton) {

	if (pressbutton == 'addvideoupload') {
		submitform(pressbutton);
		return;
	}

	// do field validation

	if (pressbutton == 'savevideoupload' || pressbutton == 'applyvideoupload') {
		var streameroption1 = (document.getElementById('streameroption1').checked);
		var streameroption2 = (document.getElementById('streameroption2').checked);
		var streameroption3 = (document.getElementById('streameroption3').checked);
		
		var bol_file1 = (document.getElementById('filepath1').checked);
		var bol_file2 = (document.getElementById('filepath2').checked);
		var bol_file3 = (document.getElementById('filepath3').checked);
		var bol_file4 = (document.getElementById('filepath4').checked);
		var streamer_name = '';
		var stream_opt = document.getElementsByName('streameroption[]');
		var islivevalue2 = (document.getElementById('islive2').checked);
		var length_stream = stream_opt.length;
		for (i = 0; i < length_stream; i++) {
			if (stream_opt[i].checked == true) {
				document.getElementById('streameroption-value').value = stream_opt[i].value;
				if (stream_opt[i].value == 'rtmp') {

					streamer_name = document.getElementById('streamname').value;

					var tomatch = /rtmp:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}|rtmp:\/\//;

					if (!tomatch.test(streamer_name) || streamer_name == '') {
						alert('Please enter a valid streamer path');
						return false;
					}
					document.getElementById('streamerpath-value').value = streamer_name;
					if (islivevalue2 == true)
						document.getElementById('islive-value').value = 1;
					else
						document.getElementById('islive-value').value = 0;
				}
			}
		}

		if (bol_file1 == true) {
			document.getElementById('fileoption').value = 'File';
			if (uploadqueue.length != '') {
				alert('Upload in Progress');
				return;
			}
			if (document.getElementById('id').value == '') {
				if (document.getElementById('normalvideoform-value').value == ''
						&& document.getElementById('hdvideoform-value').value == '') {
					alert('You must Upload a Video file');
					return;
				}
				if (document.getElementById('thumbimageform-value').value == '') {
					alert('You must Upload a Thumb Image');
					return;
				}
			}
		}
		if((streameroption1 == true && bol_file2==true || streameroption2 == true && bol_file2==true) || streameroption3 == true ){

				if (document.getElementById('videourl').value == '') {
					alert('You must provide a Video Url');
                                        document.getElementById('videourl').focus();
					return;
				}


			document.getElementById('fileoption').value = 'Url';
                        if (document.getElementById('videourl').value != '') {
				if(streameroption3 != true)
                        {

                                var url = document.getElementById('videourl').value;
				var urlregex = url
						.match("^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)");
				if (urlregex == null) {
					alert('Please Enter Valid URL');
					return;
				}
                        }
				document.getElementById('videourl-value').value = document
						.getElementById('videourl').value;
			}



			if (document.getElementById('thumburl').value != '') {

                               var thumbUrl = document.getElementById('thumburl').value;

				document.getElementById('thumburl-value').value = thumbUrl;

				var thumburlregex = thumbUrl
						.match("^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)");
				if (thumburlregex == null) {
					alert('Please Enter Valid Thumb URL');
					return;
				}
			}
			if (document.getElementById('previewurl').value != '') {

				var previewUrl = document.getElementById('previewurl').value;
				document.getElementById('previewurl-value').value = previewUrl;

				var previewurlregex = previewUrl
						.match("^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)");
				if (previewurlregex == null) {
					alert('Please Enter Valid Preview URL');
					return;
				}

			}
			if (document.getElementById('hdurl').value != '') {
				document.getElementById('hdurl-value').value = document
						.getElementById('hdurl').value;

			}
		}
		if (bol_file4 == true) {
			if (document.getElementById('videourl').value == '') {
				alert('You must provide a Video URL');
				return;
			}
			document.getElementById('fileoption').value = 'Youtube';
			if (document.getElementById('videourl').value != '') {
				var youtube = document.getElementById('videourl').value;

				if (youtube.contains("youtube.com") || youtube.contains("vimeo.com") || youtube.contains("youtu.be")){
                                        document.getElementById('videourl-value').value = document.getElementById('videourl').value;
				}else{
					alert('Please Enter Valid Youtube or Vimeo URL');
					return;
				}

			}
		}
		if (bol_file3 == true) {
			if (document.getElementById('id').value == '') {
				if (document.getElementById('ffmpegform-value').value == '') {
					alert('You must provide a Video file');
					return;
				}
			}
			document.getElementById('fileoption').value = 'FFmpeg';
			if (uploadqueue.length != '') {
				alert('Upload in Progress');
				return;
			}
		}
		if (document.getElementById('title').value == '') {
			alert('You must provide a Title');
			return;
		}
		submitform(pressbutton);
		return;
	} else {
		submitform(pressbutton);
		return;
	}
}

Joomla.submitbutton = function(pressbutton) {

	if (pressbutton == 'addvideoupload') {
		submitform(pressbutton);
		return;
	}

	// do field validation

	if (pressbutton == 'savevideoupload' || pressbutton == 'applyvideoupload') {
		var streameroption1 = (document.getElementById('streameroption1').checked);
		var streameroption2 = (document.getElementById('streameroption2').checked);
		var streameroption3 = (document.getElementById('streameroption3').checked);
		
		var bol_file1 = (document.getElementById('filepath1').checked);
		var bol_file2 = (document.getElementById('filepath2').checked);
		var bol_file3 = (document.getElementById('filepath3').checked);
		var bol_file4 = (document.getElementById('filepath4').checked);
		var streamer_name = '';
		var stream_opt = document.getElementsByName('streameroption[]');
		var islivevalue2 = (document.getElementById('islive2').checked);
		var length_stream = stream_opt.length;
		for (i = 0; i < length_stream; i++) {
			if (stream_opt[i].checked == true) {
				document.getElementById('streameroption-value').value = stream_opt[i].value;
				if (stream_opt[i].value == 'rtmp') {

					streamer_name = document.getElementById('streamname').value;

					var tomatch = /rtmp:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}|rtmp:\/\//;

					if (!tomatch.test(streamer_name) || streamer_name == '') {
						alert('Please enter a valid streamer path');
						return false;
					}
					document.getElementById('streamerpath-value').value = streamer_name;
					if (islivevalue2 == true)
						document.getElementById('islive-value').value = 1;
					else
						document.getElementById('islive-value').value = 0;
				}
			}
		}

		if (bol_file1 == true) {
			document.getElementById('fileoption').value = 'File';
			if (uploadqueue.length != '') {
				alert('Upload in Progress');
				return;
			}
			if (document.getElementById('id').value == '') {
				if (document.getElementById('normalvideoform-value').value == ''
						&& document.getElementById('hdvideoform-value').value == '') {
					alert('You must Upload a Video file');
					return;
				}
				if (document.getElementById('thumbimageform-value').value == '') {
					alert('You must Upload a Thumb Image');
					return;
				}
			}
		}
		if((streameroption1 == true && bol_file2==true || streameroption2 == true && bol_file2==true) || streameroption3 == true ){
			
				if (document.getElementById('videourl').value == '') {
					alert('You must provide a Video Url');
                                        document.getElementById('videourl').focus();
					return;
				}
			

			document.getElementById('fileoption').value = 'Url';
                        if (document.getElementById('videourl').value != '') {
				if(streameroption3 != true)
                        {

                                var url = document.getElementById('videourl').value;
				var urlregex = url
						.match("^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)");
				if (urlregex == null) {
					alert('Please Enter Valid URL');
					return;
				}
                        }
				document.getElementById('videourl-value').value = document
						.getElementById('videourl').value;
			}

                    

			if (document.getElementById('thumburl').value != '') {

                               var thumbUrl = document.getElementById('thumburl').value;

				document.getElementById('thumburl-value').value = thumbUrl;

				var thumburlregex = thumbUrl
						.match("^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)");
				if (thumburlregex == null) {
					alert('Please Enter Valid Thumb URL');
					return;
				}
			}
			if (document.getElementById('previewurl').value != '') {

				var previewUrl = document.getElementById('previewurl').value;
				document.getElementById('previewurl-value').value = previewUrl;

				var previewurlregex = previewUrl
						.match("^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)");
				if (previewurlregex == null) {
					alert('Please Enter Valid Preview URL');
					return;
				}

			}
			if (document.getElementById('hdurl').value != '') {
				document.getElementById('hdurl-value').value = document
						.getElementById('hdurl').value;

			}
		}
		if (bol_file4 == true) {
			if (document.getElementById('videourl').value == '') {
				alert('You must provide a Video URL');
				return;
			}
			document.getElementById('fileoption').value = 'Youtube';
			if (document.getElementById('videourl').value != '') {
				var youtube = document.getElementById('videourl').value;
                                if (youtube.contains("youtube.com") || youtube.contains("vimeo.com") || youtube.contains("youtu.be")){
                                    document.getElementById('videourl-value').value = document.getElementById('videourl').value;
				}else{
					alert('Please Enter Valid Youtube or Vimeo URL');
					return;
				}

			}
		}
		if (bol_file3 == true) {
			if (document.getElementById('id').value == '') {
				if (document.getElementById('ffmpegform-value').value == '') {
					alert('You must provide a Video file');
					return;
				}
			}
			document.getElementById('fileoption').value = 'FFmpeg';
			if (uploadqueue.length != '') {
				alert('Upload in Progress');
				return;
			}
		}
		if (document.getElementById('title').value == '') {
			alert('You must provide a Title');
			return;
		}
		submitform(pressbutton);
		return;
	} else {
		submitform(pressbutton);
		return;
	}
}