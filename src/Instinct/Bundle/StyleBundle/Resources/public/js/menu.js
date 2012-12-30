document.getElementById("menuwarp").addEventListener('mousemove', function(e) {
		var menu = document.getElementById("menuwarp");
		
		var centerpos = 0;
		var leftpos = 0;
		var rightpos = 0;
		
		centerpos = getWinSize().larg / 2;
		leftpos = centerpos - 500 + 70;
		rightpos = centerpos + 500 - 70;
		
		
		if(e.clientX > leftpos && e.clientX < rightpos ){
			menu.style.background = "url('"+TPL_PATH+"images/header/menu/header_menu_level_1_warp.png') no-repeat "+(e.clientX-70)+"px 0px";
		}else{
			menu.style.background = "";
		}
  }, false);
  
  
	document.getElementById("menuwarp").addEventListener('mouseout', function(e) {
		var menu = document.getElementById("menuwarp");
	
		menu.style.background = "";

  }, false);