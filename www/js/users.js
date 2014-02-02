<?
/****************************
*
* WARN
*     this files should be called from a generalxx.js.php file
*
*****************************/
?>

//** new coments **//
// new comments global var
// 2 status: 0 = normal and #comment_number_to_reply
var Comment = {
  status:0,
  padding:0,
  level:0
}

$(document).ready( function() {
  $("#comentarNoticia").click( function () {
      Comment.padding = 0;
      $("div .commentform").insertAfter(".comments-list");
      Comment.status = 0;
      $("[name=reply_id]").val("0");
  });

  $("a.fold").click( function(ev) {
      ev.preventDefault();
      e = $(this);
      if (e.hasClass("folded")) {
          e
           .removeClass("folded")
           .html("(-)")
           .siblings("span").show()
           .parent().siblings("div.cmt").show();
      } else {
          e
           .addClass("folded")
           .html("(+)")
           .siblings("span").hide()
           .parent().siblings("div.cmt").hide();
      }
  });

  $("#selectCommentOrder").change( function() {
      $.ajax({
          url: base_url + 'backend/set_comment_order.php',
          data: { order:$(this).val() },
          success: function() {
            window.location.reload();
          },
          error: function() {
            alert("Erro trocando a orde dos comentarios");
          },
          dataType:'text'
      });
  });

  //login_dialog();

});

function login_dialog() {
  $('#loginDialog').modal();
}

function comment_reply(id,c_id) {
  // 1st part
  padding = $("c-"+id).attr("name")
  $("div .commentform").insertAfter($("#c-"+id+" > .comment-body")).css("padding-left",Comment.padding+"px");
  $("#comentarNoticia").css("visibility","visible");
  Comment.status = c_id;
  $("[name=parent_id]").val(c_id);

  //2nd part (original)
	//ref = '#' + id + ' ';
	textarea = $('#comment');
	if (textarea.length == 0 ) return;
  /*
	var re = new RegExp(ref);
	var oldtext = textarea.val();
	if (oldtext.match(re)) return;
	if (oldtext.length > 0 && oldtext.charAt(oldtext.length-1) != "\n") oldtext = oldtext + "\n";
	textarea.val(oldtext + ref);
  */
	textarea.get(0).focus();
}

function post_load_form(id, container) {
	var url = base_url + 'backend/post_edit.php?id='+id+"&key="+base_key;
	$.get(url, function (html) {
			if (html.length > 0) {
				if (html.match(/^ERROR:/i)) {
					alert(html);
				} else {
					$('#'+container).html(html);
				}
				reportAjaxStats('html', 'post_edit');
			}
		});
}


function post_new() {
	post_load_form(0, 'addpost');
}

function post_edit(id) {
	post_load_form(id, 'pcontainer-'+id);
}

function post_reply(id, user) {
	ref = '@' + user + ',' + id + ' ';
	textarea = $('#post');
	if (textarea.length == 0) {
		post_new();
	}
	post_add_form_text(ref, 1);
}

function post_add_form_text(text, tries) {
	if (! tries) tries = 1;
	textarea = $('#post');
	if (tries < 20 && textarea.length == 0) {
			tries++;
			setTimeout('post_add_form_text("'+text+'", '+tries+')', 50);
			return false;
	}
	if (textarea.length == 0 ) return false;
	var re = new RegExp(text);
	var oldtext = textarea.val();
	if (oldtext.match(re)) return false;
	if (oldtext.length > 0 && oldtext.charAt(oldtext.length-1) != ' ') oldtext = oldtext + ' ';
	textarea.val(oldtext + text);	
	textarea.get(0).focus();
}

// See http://www.shiningstar.net/articles/articles/javascript/dynamictextareacounter.asp?ID=AW
function textCounter(field,cntfield,maxlimit) {
	if (field.value.length > maxlimit)
	// if too long...trim it!
		field.value = field.value.substring(0, maxlimit);
	// otherwise, update 'characters left' counter
	else
		cntfield.value = maxlimit - field.value.length;
}



/************************
Simple format functions
**********************************/
/*
  Code from http://www.gamedev.net/community/forums/topic.asp?topic_id=400585
  strongly improved by Juan Pedro López for http://meneame.net
  2006/10/01, jotape @ http://jplopez.net
*/

function applyTag(id, tag) {
	obj = document.getElementById(id);
	if (obj) wrapText(obj, tag, tag);
	return false;
}

function wrapText(obj, tag) {
	if(typeof obj.selectionStart == 'number') {
		// Mozilla, Opera and any other true browser
		var start = obj.selectionStart;
		var end   = obj.selectionEnd;

		if (start == end || end < start) return false;
		obj.value = obj.value.substring(0, start) +  replaceText(obj.value.substring(start, end), tag) + obj.value.substring(end, obj.value.length);
	} else if(document.selection) {
		// Damn Explorer
		// Checking we are processing textarea value
		obj.focus();
		var range = document.selection.createRange();
		if(range.parentElement() != obj) return false;
		if (range.text == "") return false;
		if(typeof range.text == 'string')
	        document.selection.createRange().text =  replaceText(range.text, tag);
	} else
		obj.value += text;
}

function replaceText(text, tag) {
		return '<'+tag+'>'+text+'</'+tag+'>';
}


