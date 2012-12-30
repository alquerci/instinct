
document.getElementById("slidetotop").style.display = "none";


	document.addEventListener('scroll', function(e) {
		var slidetotop = document.getElementById("slidetotop");
		var winScroll = getWinScroll();
				
		if(winScroll.y > 300){
			slidetotop.style.display = "block";
		}else{
			slidetotop.style.display = "none";
		}
		
  }, false);
  
  