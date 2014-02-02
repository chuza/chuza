/***************************************************************
/
/	Este programa se rige bajo la GNU General Public License v2
/	El autor del mismo es Urko Joseba de Lucas Beaumont
/	urko1982 [at] gmail [dot] com
/	http://twitter.com/urko
/
/
*****************************************************************/

// Crea menu contextual (segundo boton) de titulo 'jonear noticia' y que activa enviar_noticia.
chrome.contextMenus.create({
	
	"title": "Chuzar",
    "type" : "normal",
    "contexts":["page","selection","link","editable","image","video","audio"],
	"onclick":enviar_noticia
	
});
  
// Captura la pagina actual (donde se ha abierto el menu contextual) y crea una pestana de joneame con la url de la noticia
// Configurar con Jonarano la pagina destino

function enviar_noticia(info,tab) {
	
	console.log("enviar_noticia");

    	var url_actual = tab.url;
        var url = 'http://chuza.gl/submit.php?url='+url_actual;
        
    	chrome.windows.create({ url: url, width: 1200, type:"normal" }); 
             
};