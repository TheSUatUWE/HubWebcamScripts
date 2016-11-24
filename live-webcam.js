var timeout       = 2;
var webcam_t;
var img_num       = "1";
var img_loc_start = "http://services.hubradio.co.uk/webcam/cam-fr";
var img_loc_end = ".php";


function refresh_webcam(url, container, timeout) {
  var tmp = new Date();
  tmp = "?"+tmp.getTime();
  document.getElementById(container).src=url+tmp;
  webcam_t = setTimeout(function() { refresh_webcam(url, container, timeout) }, timeout*1000);
}

//refresh_webcam(img_loc_start + "1" + img_loc_end, "webcam-1", timeout);
//refresh_webcam(img_loc_start + "2" + img_loc_end, "webcam-2", timeout);
