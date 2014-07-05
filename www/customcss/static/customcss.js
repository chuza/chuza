$(document).ready( function() {

  $('#cleanIt').click( function() {
	  $("#css_text").html("");
  });

  $('#originalIt').click( function(e) {
	  e.preventDefault();
	  get_styles({"edit":0});
  });
		
  $(".styleEdit").click( function(e) {
	  e.preventDefault();
	  var css_id = $(this).parent().attr("value");
	  get_styles({"edit":css_id});
  });

  $("#css_form").submit(function(e) {
	e.preventDefault();
	$.post('/customcss/process.php',
	  $(this).serializeArray(),
	  function(d) {
		  var response = $.parseJSON(d);
		  if (response.error) {
			  alert(response.error);
		  } else {
			  $("<h3>" + response.success + "</h3>").prependTo(
				  $("#css_form").parent())
			  .fadeOut(3000);

			  get_styles();

		  }
	  }, function(d) {
		  //console.log(arguments);
	  } 
	);  
  });

  function bindStyles() {
	  $(".styleRemove").click( function(e) {
		  e.preventDefault();
		  var css_id = $(this).parent().parent().attr("value");
		  get_styles({"remove":css_id});
	  });

	  $(".styleEdit").click( function(e) {
		  e.preventDefault();
		  var css_id = $(this).parent().attr("value");
		  get_styles({"edit":css_id});
	  });
  }

  function get_styles(data, callback) {
	  $.get(
		  "/customcss/setstyle.php",
		  data,
		  function(data) {
			$("#userStyles").html("");
			if (data.styles) {
				for (var key in data.styles) {
					var row = data.styles[key];
					$("#userStyles").append(
						'<li class="estilo" value="'+row['css_id']+'"><a class="styleEdit" href="#" ><b>'+row['css_name']+'</b> por '+row['user_login']+'</a><div style="float:right;"><a class="styleRemove" href="#" >X'+'</a></div></li>'
					);
				}
			}

			bindStyles();

			if (data.css) {
				$("#css_text").html(data.css.css_text).fadeIn();
				if (data.css.css_name) {
					$("#css_name").val(data.css.css_name);
				}
			}
		  },
		  'json'
	  )
  }

  get_styles();


});
