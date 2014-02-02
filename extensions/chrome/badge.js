/***************************************************************
/
/	Este programa se rige bajo la GNU General Public License v2
/	El autor del mismo es Urko Joseba de Lucas Beaumont
/	urko1982 [at] gmail [dot] com
/	http://twitter.com/urko
/
/
*****************************************************************/


// Cuando se ejecuta joneame.html se quita el aviso de nuevo joneo
// Quita el badge

$(document).ready(function(){
  chrome.browserAction.setBadgeBackgroundColor({color:[0, 0, 0, 0]});
  chrome.browserAction.setBadgeText({text:""});
  contador = 0;
} );
  
  
  
  
  
  