<!DOCTYPE html>
<html>
	<head>
		<title>Hipster Menu</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
		<link href="./css/poverty.css" type="text/css" rel="stylesheet" media="screen,projection"/>
		<link href="./css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
		<link href="./css/font-awesome.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="crossorigin="anonymous"></script>
		<!--Google SHit-->
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		<meta name="google-signin-client_id" content="413698421344-c39mjtvkgs6svj4nipudj61uflfsjr31.apps.googleusercontent.com">
		<!--end google shit-->
		<link href="./css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

	</head>

<style>
	.bodyBackground{
		 background: linear-gradient(to bottom left, #DDE3E6, #D4DDE4);
	}
	</style>

	<body class="bodyBackground">
		<div class="site-content" style="" id="replace">
		</div>
	</body>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="crossorigin="anonymous"></script>
	<script>
		var $animation_elements;
		var $window;
		function updatePage(data)
		{
			var $target = $('html,body');
			$target.animate({scrollTop: 0}, 0);
			$("#replace").html(data);
			$("#replace").fadeIn(401);
			var editables = $("ul.editable,ol.editable,h1.editable,h2.editable,h3.editable,h4.editable,h5.editable,h6.editable,p.editable,div.editable");
			editables.each(function(){
				getContent($(this));
			});
			$animation_elements = $('.animation-element');
			$window = $(window);
			$window.trigger('scroll');
		}
		function updateContent(bttnClick)
		{
			console.log("updating with: "+window.location.hash);
			var hash = window.location.hash;
			if(bttnClick){
				if(hash =='#'||hash=="#!")
				{
					return 0;
				}
			}else
			{
				if(hash == "#!")
				{
					history.go(-1);
					updateContent(true);
				}
			}
			if(hash =='')
			{
				hash = 'welcome';
			}else{
				hash = hash.substr(1);
			}
			$.ajax(
				{url:'./pages/'+hash+'.html',
				 success:function(data){

					 $("#replace").fadeOut(401);
					 setTimeout(function(){updatePage(data);},400);
				 },
				 error:function(){
					 $.ajax(
						 {url:'./pages/error.html',
						  success:function(data){
							  $("#replace").fadeOut(401);
							  setTimeout(function(){updatePage(data);},400);
						  }
						 })}
				});
		}

		window.onhashchange = function(){
			updateContent(true);
		};
		window.onload = function() {
			console.log("loaded");

			$(".sideToggle").click(function(){
				$(".sidebar").toggleClass("active");
			});

		};
		updateContent(false);
	</script>
	<script>

		$( "#searchBar" ).parent().focusin(function() {
			$( this ).parent().append("<div class=\"card\"style=\"margin:0px;width:100%;overflow-y:scroll;position:absolute;max-height:200px;z-index:10000;\" class=\"sideBody\" id=\"results\"></div>");
			updateSearch()
		});
		$("#searchBar").parent().focusout(function(){
			setTimeout(function(){$("#results").remove();},250)

		});
		$( "#searchBar" ).keyup(function() {
			updateSearch()
		});

		function updateSearch(){
			var url = window.location.pathname;
			url = url.substring(url.lastIndexOf('/')+1);
			console.log(document.getElementById('searchBar').value );
			$.ajax({
				url: './php/search.php',
				type: 'POST',
				data: {
					"search": ''+document.getElementById('searchBar').value,
					"page": '"'+ url+window.location.hash+ '"'
				},
				success: function(data) {
					console.log($("#results"));
					$("#results").html(data);
					console.log(data);

				},
				error: function(e) {
					console.log("oops");
				}
			});}
	</script>
	<script src="./js/poverty.js" async></script>
	<script src="./js/loadContent.js" async></script>
</html>
