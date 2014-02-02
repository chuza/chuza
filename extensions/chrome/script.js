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

	    console.log(localStorage.nsfw);
	    console.log(localStorage.m18);
			
			if(localStorage.rss==1){ 
				document.getElementById("titular").innerHTML="Portada";
				rss =  'http://chuza.gl/rss2.php';
			} else {
				document.getElementById("titular").innerHTML="&Uacute;timas Chuzadas!";
				rss = 'http://chuza.gl/rss2.php?status=queued';
			} 
			
			//Numero de noticias maximas 10, pero solo mostraremos 5
			var query = "SELECT * FROM feed WHERE url='"+rss+"' LIMIT 10";
	
	// Storing the seconds since the epoch in now:
	var now = (new Date()).getTime()/1000;
	

	// If there is no cache set in localStorage, or the cache is older than 1 minute:
	if(!localStorage.cache || localStorage.saved == 1 || now - parseInt(localStorage.time) > 1*60)
	{
		localStorage.saved = 0;
		$.get("http://query.yahooapis.com/v1/public/yql?q="+encodeURIComponent(query)+"&format=json&callback=?",function(msg) {

			// msg.query.results.item is an array:
			var items = msg.query.results.item;
			
			var htmlString = "";
			var aux = 0;

			for( var i=0; i < items.length; i++) {
				
				if( aux < 5 ) {
					
					var tut = items[i];
					var titulo = tut.title;
					console.log(titulo);
					
					//Si cumple las limitaciones
					if( (titulo.indexOf('[NSFW]') >-1 && localStorage.nsfw=='true') || (titulo.indexOf('[m18]') >-1 && localStorage.m18=='true') || ( titulo.indexOf('[m18]') == -1 &&  titulo.indexOf('[NSFW]') == -1 ) ){
			
						console.log(titulo);
						tut_desc = tut.description; //Descripcion de la noticia
						p_desc_1 = tut_desc.indexOf('<p>'); //Inicio de la descripcion
						p_desc_2 = tut_desc.indexOf('</p>'); //Fin de la descripcion
						desc = tut_desc.substring(p_desc_1,p_desc_2); //Descripcion
						
						if(localStorage.rss==1){ 
							// Muestra thumbnail de la noticia
								if(tut.description.indexOf('static')!=-1){
									aux_2=tut.link_id.substring(0,2);
									//alert(aux_2);
									//aux_1=tut.link_id.substring(0,1);
									aux_1=0;
									htmlString += '<div class="tutorial"><a href="'+tut.link+'" target="_blank"><img src="http://static.chuza.gl/thumbs/'+aux_1+'/'+aux_2+'/'+tut.link_id+'.jpg" /></a><a href="'+tut.link+'" target="_blank"><h3>'+tut.title+'</h3></a>'+desc+'<a href="'+tut.link+'" target="_blank">Ver imagen</a></div>';
								} else {
		 							htmlString += '<div class="tutorial"  style="text-align:middle; margin-left:82px; width:410px;"><a href="'+tut.link+'" target="_blank"><h3>'+tut.title+'</h3></a>'+desc+'</div>';
		 						}
						} else {
							htmlString += '<div class="tutorial"  style="text-align:middle;"><a href="'+tut.link+'" target="_blank"><h3>'+tut.title+'</h3></a>'+desc+'</div>';
						}						
						aux++;	
					}
			 	}
			}
		 			 	
			// Setting the cache
			localStorage.cache	= htmlString;
			localStorage.time	= now;

			// Updating the content div:
			$('#content').html(htmlString);
		},'json');
	}
	else{
		// The cache is fresh, use it:
		$('#content').html(localStorage.cache);
	}
});