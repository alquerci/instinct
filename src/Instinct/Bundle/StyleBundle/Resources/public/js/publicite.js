function getCookie(sName) {
	var oRegex = new RegExp("(?:; )?" + sName + "=([^;]*);?");

	if (oRegex.test(document.cookie)) {
		return decodeURIComponent(RegExp["$1"]);
	} else {
		return null;
	}
}


function getAncrePub(){
	var theme_publicite_ancre = getCookie("theme_publicite_ancre");
	var ancre = false;
	
	if(theme_publicite_ancre !=  null ){
		if(theme_publicite_ancre){
			ancre = true;
		}
	}
	
	return ancre;
}

function getContentPub(){
	var ancre = getAncrePub();
	var content = "";
	
	if(ancre){
		content = "3988-3872";
	}else{
		content = "";
	}
	
	return content;
}

document.getElementById('adiframe').data = 'http://ads.clicmanager.fr/ads.php?c=22758&s=43580&t=3&a=&q=' + getContentPub();
document.getElementById('adiframeifie').src = 'http://ads.clicmanager.fr/ads.php?c=22758&s=43580&t=3&a=&q=' + getContentPub();