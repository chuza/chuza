/***************************************************************
/
/	Este programa se rige bajo la GNU General Public License v2
/	El autor del mismo es Urko Joseba de Lucas Beaumont
/	urko1982 [at] gmail [dot] com
/	http://twitter.com/urko
/
/
*****************************************************************/


	// Saves options to localStorage.
	function save_options() {
	
		localStorage["user"] = document.getElementById("user").value;
	    localStorage["api"] = document.getElementById("api").value;
	    localStorage["rss"] = document.getElementById("rss").value;
	    localStorage["nsfw"] = document.getElementById("nsfw").checked;
   	    localStorage["m18"] = document.getElementById("m18").checked;
   	    localStorage["v21"] = document.getElementById("v21").checked;
   	    
   	    alert(localStorage.v21);
   	    
	    localStorage.saved = 1;
	    
	  // Update status to let user know options were saved.
  		var status = document.getElementById("status");
  		status.innerHTML = "<h3 style='margin:50px 0 0 480px'>Opciones guardadas</h3>";
  		setTimeout(function() {
    		status.innerHTML = "";
  		}, 10000);
	}

	// Restores select box state to saved value from localStorage.
	function restore_options() {
  		var usuario = localStorage["rss"];
  		if (!usuario) {
    		return;
  		} else {
  			document.getElementById("user").value = localStorage["user"];
  			document.getElementById("api").value = localStorage["api"];
  			document.getElementById("rss").value = localStorage["rss"];
  			if(localStorage["nsfw"]=='false') document.getElementById("nsfw").checked = false;
  			if(localStorage["m18"]=='false') document.getElementById("m18").checked = false;
  			if(localStorage["v21"]=='false') document.getElementById("v21").checked = false;
  		}
	}
  
  
  
  
  
  