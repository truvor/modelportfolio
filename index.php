<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />

		<title>Model Portfolio</title>
		<link rel="stylesheet" href="jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="DT_bootstrap.css">

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="jquery-ui.js"></script>

		<script type="text/javascript" charset="utf-8" language="javascript" src="/release-datatables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8" language="javascript" src="DT_bootstrap.js"></script>
		<script type="text/javascript" src="bootstrap-2.0.2.js"></script>

		<script type="text/javascript" src="js/datatable.js"></script>
		<script type="text/javascript" src="js/graphics.js"></script>

		<script src="http://code.highcharts.com/stock/highstock.js"></script>
		<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>

	<!--Hide popup on load page-->
	<script>
		$(document).ready(function() {
			$('#dialog').hide();

			$("button[value='buy']").toggleClass("btn-block", true);
			$("button[value='buy']").css("width", "100%");
			$("button[value='sell']").toggle(false);
		});
	</script>

	</head>
	<body onLoad="tableRuler()">
	<!--Facebook login-->
	<div id="fb-root"></div>
	<script>
		var uid =null;
		// Additional JS functions here
		window.fbAsyncInit = function () {
			FB.Event.subscribe('auth.login',
				function (response) {
					if(response.status === 'connected'){
						uid = response.authResponse.userID;
						$('#userid').val(uid);
                        putPortfolio()
						location.reload();
					}
			});

			FB.init({
				appId : '', // App ID
				channelUrl : 'env-5772537.j.rsnx.ru/channel.html', // Channel File
				status : true, // check login status
				cookie : true, // enable cookies to allow the server to access the session
				xfbml : true // parse XFBML
			});
			// Additional init code here
			FB.getLoginStatus(function (response) {
				if (response.status === 'connected') {
					// connected
					uid = response.authResponse.userID;
                    $('#userid').val(uid);
					putPortfolio()
				}
			});
		};

		function putPortfolio() {
			$.get(
				"/buymarket.php", {
				id : uid,
			},
				onAjaxSuccess);

			function onAjaxSuccess(data) {
				document.getElementById('portfolio').innerHTML = data
                                  $(document).ready( function() {
		       $('#example1').dataTable( {
		         "iDisplayLength": 8
		       } );
		     } )
				tableRuler()
			}
		}

		// Load the SDK Asynchronously
		(function (d) {
			var js,
			id = 'facebook-jssdk',
			ref = d.getElementsByTagName('script')[0];
			if (d.getElementById(id)) {
				return;
			}
			js = d.createElement('script');
			js.id = id;
			js.async = true;
			js.src = "//connect.facebook.net/ru_RU/all.js";
			ref.parentNode.insertBefore(js, ref);
		}
			(document));
	</script>

		<div class="container well" style="margin-top: 10px">
			<ul class="nav nav-tabs" id="myTab">
				<li class="active"><a href="#quotes">Quotes</a></li>
				<li><a href="#portfolio">Portfolio</a></li>
			</ul>

			<div class="tab-content" onclick = "tableRuler()">
				<div class="tab-pane active" id="quotes">
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered ruler" id="example" onselectstart="return false" onmousedown="return false" >
						<thead>
						<tr class="header">
							<th>#</th>
							<th>Name</th>
							<th>Ticker</th>
							<th>Price</th>
							<th>Time</th>
						</tr>
						</thead>
						<tbody>
							<?php include "quotes.php"; ?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane" id="portfolio">
				</div>
			</div>

			<div class="fb-login-button" data-show-faces="true" data-width="200" data-max-rows="1"></div>
			<div id="container" style="height: 300px; min-width: 500px"></div>
		</div>

		<script>
			$('#myTab a').click(function (e) {
				e.preventDefault();
				$(this).tab('show');

				var hr = $(this).prop('href');
				if(hr == "http://env-4992412.jelastic.regruhosting.ru/#quotes" || hr == "http://env-4992412.jelastic.regruhosting.ru/index.php#quotes"){
					$("button[value='buy']").toggleClass("btn-block", true);
					$("button[value='buy']").css("width", "100%");
					$("button[value='sell']").toggle(false);
				}
				else {
					$("button[value='buy']").toggleClass("btn-block", false);
					$("button[value='buy']").css("width", "48%");
					$("button[value='sell']").toggle(true);
				}

			})
		</script>

	<div id="dialog" title="New Order">
	<form name = "popupForm" novalidate method="post" action = "postbuy.php">
		<label>Security</label>
		<input type="text" name="name" id="text-field" readonly value="">
		<br>
		<input type="text" name="ticker" id="text-field" readonly value="">
		<br>

		<label for="text-field">Price</label>
		<input type="text" name="price" id="text-field" placeholder="Input price">
		<br>

		<label for="count">Quantity</label>
		<input type="number" name="count" id="numeric-spinner" value="10" placeholder="Input quantity">
		<br>
		<input type="hidden" name="uid" id="userid">

		<button type="submit" name = "submitButton" class="btn btn-success" role="button" aria-disabled="false" style="width: 48%;" value = "buy">
			<span class="ui-button-text">Buy</span>
		</button>
		<button type="submit" name = "submitButton" class="btn btn-danger" role="button" aria-disabled="false" style="width: 48%;" value = "sell">
			<span class="ui-button-text">Sell</span>
		</button>
		<div class="clearfix"></div>
	</form>
</div>
	</body>
</html>
