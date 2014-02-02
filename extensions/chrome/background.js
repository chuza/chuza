/***************************************************************
/
/	Este programa se rige bajo la GNU General Public License v2
/	El autor del mismo es Urko Joseba de Lucas Beaumont
/	urko1982 [at] gmail [dot] com
/	http://twitter.com/urko
/
/
*****************************************************************/

$(document).ready(function(){
	
		console.log("background cargando...");
		var contador = 0;
		
		// Cada 10 segundos comprueba que el RSS es el mismo
		window.setInterval(function() {
		
			console.log("inicio intervalo...");
			
			if(localStorage.rss==1){ 
				rss =  'http://chuza.gl/rss2.php';
			} else { 
				rss = 'http://chuza.gl/rss2.php?status=queued';
			} 
			
			var query = "SELECT * FROM feed WHERE url='"+rss+"' LIMIT 10";
			
	 		$.get("http://query.yahooapis.com/v1/public/yql?q="+encodeURIComponent(query)+"&format=json&callback=?",function(msg){

				// msg.query.results.item is an array:
				var items = msg.query.results.item;
				var aux = 1; //variable para seguir con el loop
				
				for( var i=0; i < items.length; i++) {
					
					if( aux==1){
						var tut = items[i];
						var titulo = tut.title;
						//Si cumple las limitaciones
						if( (titulo.indexOf('[NSFW]') >-1 && localStorage.nsfw=='true') || (titulo.indexOf('[m18]') >-1 && localStorage.m18=='true') || ( titulo.indexOf('[m18]') == -1 &&  titulo.indexOf('[NSFW]') == -1 ) && aux==1) {
							aux = 0 ;
							console.log(tut.link+"-"+localStorage.last);
							console.log(tut.link != localStorage.last);
							if( tut.link != localStorage.last || !localStorage.last ){
								chrome.browserAction.setBadgeBackgroundColor({color:[0, 200, 0, 100]});
								if(contador>0){
									 contador++;
								} else {
									contador = 1;
								}
									 
								chrome.browserAction.setBadgeText({text:contador+""});
								localStorage.last = tut.link;
							}
						}	
					}
				}
 	
 			},'json');
 			
 		console.log("fin intervalo...");
 		
		}, 10000);
	
});