theme_newsFlash.nfBox = document.getElementById('nf_reel');

function pause(){
	clearInterval(theme_newsFlash.timerScroll);
	theme_newsFlash.timerPause = setInterval('startScroll()', 10000);
}

function startScroll(){
	clearInterval(theme_newsFlash.timerPause);
	theme_newsFlash.timerScroll = setInterval('scroll()', 40);
}

function scroll(){
	theme_newsFlash.positionFlash--;
	if(theme_newsFlash.positionFlash%15 == 0){
		theme_newsFlash.numeroFlash++;
		pause();
	}
	if(theme_newsFlash.numeroFlash == theme_newsFlash.maxFlash){
		theme_newsFlash.positionFlash = 0;
		theme_newsFlash.numeroFlash = 0;
	}
	theme_newsFlash.nfBox.style.top = theme_newsFlash.positionFlash+'px';
}

theme_newsFlash.timerScroll = setInterval('scroll()', 40);