<!DOCTYPE html>
<html lang="en">
@include("include.config")
<?php
$conn = DB::connection()->getPdo();
  $quee=$conn->query('SELECT * from settings')->fetch();
  $que=$conn->query('SELECT * from system_logos')->fetch();
?>
<head>
@yield("head")
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Stcko Manager - A fully responsive, HTML5 based admin theme">
<meta name="keywords" content="Responsive, HTML5, admin theme, business, professional, Mouldifi, web design, CSS3">
<title><?php echo $quee["title"]; ?></title>
<style>
.html5buttons{display:none;}
</style>
<!-- Site favicon -->
<link rel='shortcut icon' type='image/x-icon' href='/upload/logo/<?php echo $que["image"]; ?>' />
<!-- /site favicon -->

<!-- Entypo font stylesheet -->
<link href="/css/entypo.css" rel="stylesheet">
<!-- /entypo font stylesheet -->

<!-- Font awesome stylesheet -->
<link href="/css/font-awesome.min.css" rel="stylesheet">
<!-- /font awesome stylesheet -->

<!-- Bootstrap stylesheet min version -->
<link href="/css/bootstrap.min.css" rel="stylesheet">
<!-- /bootstrap stylesheet min version -->

<!-- Mouldifi core stylesheet -->
<link href="/css/mouldifi-core.css" rel="stylesheet">
<!-- /mouldifi core stylesheet -->

<link href="/css/mouldifi-forms.css" rel="stylesheet">

<script>
      window.Laravel = <?php echo json_encode([
         'csrfToken' => csrf_token(),
      ]); ?>
</script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
<![endif]-->

<!--[if lte IE 8]>
	<script src="js/plugins/flot/excanvas.min.js"></script>
<![endif]-->
</head>
<body>
<div class="page-container">
	<div class="page-sidebar">
		<header class="site-header">
		  <div class="site-logo"><a href="/dashboard"><img src="/upload/logo/<?php echo $que["image"]; ?>" alt="<?php echo $quee["system_name"]; ?>" title="<?php echo $quee["system_name"]; ?>" style="width:200px;"></a></div>
		  <div class="sidebar-collapse hidden-xs"><a class="sidebar-collapse-icon" href="#"><i class="icon-menu"></i></a></div>
		  <div class="sidebar-mobile-menu visible-xs"><a data-target="#side-nav" data-toggle="collapse" class="mobile-menu-icon" href="#"><i class="icon-menu"></i></a></div>
		</header>
		<ul id="side-nav" class="main-menu navbar-collapse collapse">
			<li><a href="/dashboard"><i class="icon-gauge"></i><span class="title">Dashboard</span></a>
			</li>
			<li><a href="/products"><i class="icon-thumbs-up"></i><span class="title">Products</span></a>
			</li>
			<li class="has-sub"><a href="/purchases"><i class="icon-list"></i><span class="title">Stock & Purchase</span></a>
				<ul class="nav collapse">
					<li><a href="/purchases"><span class="title">List Stock & Parchases</span></a></li>
					<li><a href="/purchases/create"><span class="title">Add Stock & Purchase</span></a></li>
				</ul>
			</li>
			<li class="has-sub"><a href="/sales"><i class="icon-list"></i><span class="title">Sales</span></a>
				<ul class="nav collapse">
					<li><a href="/sales"><span class="title">List Sales</span></a></li>
					<li><a href="/sales/create"><span class="title">Add Sale</span></a></li>
				</ul>
			</li>
			<li class="has-sub"><a href="#"><i class="icon-layout"></i><span class="title">People</span></a>
				<ul class="nav collapse">
					<li><a href="/parties"><span class="title">Clients</span></a></li>
					<li><a href="/supplier"><span class="title">Supplier</span></a></li>
					<li><a href="/publisher"><span class="title">Publishers</span></a></li>
				</ul>
			</li>
			<li class="has-sub"><a href="#"><i class="icon-layout"></i><span class="title">Tax & Discount</span></a>
				<ul class="nav collapse">
					<li><a href="/discount"><span class="title">Discount</span></a></li>
					<li><a href="/taxes"><span class="title">Tax Rates</span></a></li>
					<li><a href="/catagories"><span class="title">Product Catagories</span></a></li>
				</ul>
			</li>
			<li class="has-sub"><a href="#"><i class="icon-layout"></i><span class="title">Accounts</span></a>
				<ul class="nav collapse">
					<li class="has-sub">
						<a href="#/"><span class="title">Ledgers</span></a> 
						<ul class="nav collapse"> 
							<li><a href="/ledger"><span class="title">Client Ledgers</span></a></li> 
							<li><a href="/ledger/suppliers"><span class="title">Supplier/Buyer Ledgers</span></a></li>
						</ul> 
					</li>
					<li class="has-sub">
						<a href="#/"><span class="title">Vouchers</span></a> 
						<ul class="nav collapse"> 
							<li><a href="/account-head"><span class="title">Head Of Account</span></a></li>
							<li><a href="/general-voucher"><span class="title">General Voucher</span></a></li>
							<li><a href="/bank-payments"><span class="title">Bank Payment</span></a></li>
							<li><a href="/cash-receipts"><span class="title">Cash Receipt</span></a></li>
							 <li><a href="/cash-payments"><span class="title">Cash Payment</span></a></li>
							<!--<li><a href="/"><span class="title"></span></a></li> -->
						</ul> 
					</li>
					<li class="has-sub">
						<a href="#/"><span class="title">Expenses</span></a> 
						<ul class="nav collapse"> 
							<li><a href="/expenses/heads"><span class="title">Expenses Heads</span></a></li> 
							<li><a href="/expenses"><span class="title">All Expenses</span></a></li>
						</ul> 
					</li>
					<li><a href="/profitloss"><span class="title">Profit Loss Account</span></a></li>
				</ul>
			</li>
			<!-- <li class="has-sub"><a href="#"><i class="icon-cog"></i><span class="title">Transction</span></a>
				<ul class="nav collapse">
					<li><a href="/settings/1/edit"><span class="title">Payment</span></a></li>
					<li><a href="/account/{{ Auth::user()->id }}/edit"><span class="title">Receipt</span></a></li>
				</ul>
			</li>
			<li class="has-sub"><a href="#"><i class="icon-cog"></i><span class="title">Finance</span></a>
				<ul class="nav collapse">
					<li><a href=""><span class="title">Account Group</span></a></li>
					<li><a href=""><span class="title">Ledger</span></a></li>
					<li><a href=""><span class="title">Expense</span></a></li>
					<li><a href=""><span class="title">Cash Flow</span></a></li>
					<li><a href=""><span class="title">Statement</span></a></li>
					<li><a href="#"><span class="title">Back Account</span></a></li>
				</ul>
			</li> -->
			<li class="has-sub"><a href="#"><i class="icon-cog"></i><span class="title">Settings</span></a>
				<ul class="nav collapse">
					<li><a href="/settings/1/edit"><span class="title">System Settings</span></a></li>
					<li><a href="/account/{{ Auth::user()->id }}/edit"><span class="title">Account Settings</span></a></li>
				</ul>
			</li>
			<li><a href="/roles"><i class="icon-users"></i><span class="title">User Roles</span></a>
			</li>
<!-- 			<li><a href="/ledger"><i class="icon-newspaper"></i><span class="title">Ledger</span></a></li>
			<li><a href="/repairing"><i class="icon-newspaper"></i><span class="title">Repairing</span></a></li>
			<li>
			<a href="/settings/1/edit"><i class="icon-cog"></i><span class="title">General Settings</span></a>
			<li><a href="/account/{{ Auth::user()->id }}/edit"><i class="icon-cog"></i><span class="title">Account Settings</span></a> -->
		
			<li class="has-sub"> 
				<a href="#/"><i class="icon-flow-tree"></i><span class="title">Reports</span></a> 
				<ul class="nav collapse"> 
					<li class="has-sub">
						<a href="#/"><span class="title">Purchase Register</span></a> 
						<ul class="nav collapse"> 
							<li><a href="/single-party-purchase-report/create" target="__blank"><span class="title">Single Party Purchase</span></a></li> 
							<li><a href="/all-party-purchase-report/create" target="__blank"><span class="title">All Parties Purchase</span></a></li>
							<li><a href="#/" target="__blank"><span class="title">Import Purchase</span></a></li>
							<li><a href="#/" target="__blank"><span class="title">Local Purchase</span></a></li>
						</ul> 
					</li>
					<li class="has-sub">
						<a href="#/"><span class="title">Sale Register</span></a> 
						<ul class="nav collapse"> 
							<li><a href="/sales-report/single-party/create" target="__blank"><span class="title">Single Party Sale</span></a></li> 
							<li><a href="/sales-report/all-party/create" target="__blank"><span class="title">All Parties Sale</span></a></li>
						</ul> 
					</li>
					<li class="has-sub">
						<a href="#/"><span class="title">Stock Register</span></a> 
						<ul class="nav collapse"> 
							<li><a href="#/" target="__blank"><span class="title">Month Wise Closing</span></a></li> 
							<li><a href="/stock-report/all-items" target="__blank"><span class="title">All Items</span></a></li>
							<li><a href="#/" target="__blank"><span class="title">Item Ledger</span></a></li>
						</ul> 
					</li>   
					<li class="has-sub">
						<a href="#/"><span class="title">Expense Reports</span></a> 
						<ul class="nav collapse"> 
							<li><a href="/expense-head-report/create" target="__blank"><span class="title">Expense Head Report</span></a></li> 
							<li><a href="/expense-report" target="__blank"><span class="title">All Expense</span></a></li>
							<!-- <li><a href="#/" target="__blank"><span class="title">Item Ledger</span></a></li> -->
						</ul> 
					</li> 
					<li><a href="#/"><span class="title">Party Ledger</span></a></li>
					<li class="has-sub">
						<a href="#/"><span class="title">Party Information</span></a> 
						<ul class="nav collapse"> 
							<li><a href="#/" target="__blank"><span class="title">Address</span></a></li> 
							<li><a href="#/" target="__blank"><span class="title">No Of Suppliers</span></a></li>
							<li><a href="#/" target="__blank"><span class="title">No of Buyers</span></a></li>
						</ul> 
					</li>
					<li><a href="#/" target="__blank"><span class="title">Summary Reports</span></a></li> 
					<li><a href="#/" target="__blank"><span class="title">Outstanding Bills</span></a></li> 
					<li><a href="/cash-book-report" target="__blank"><span class="title">Cash Book Report</span></a></li>
				</ul> 
			</li>
				<li class="has-sub"><a href="basic-tables.html"><i class="icon-window"></i><span class="title">Graph Reports</span></a>
				<ul class="nav collapse">
					<!-- <li><a href="/purchase-report/create"><span class="title">Purchases Report</span></a></li>
					<li><a href="/sale-report/create"><span class="title">Sale Report</span></a></li> -->
					<li><a href="/reports" target="_blank"><span class="title">Yearly Sale / Purchase</span></a></li>
					<li><a href="/reports/month" target="_blank"><span class="title">Monthly Sale / Purchase</span></a></li>
					<li><a href="/reports/day" target="_blank"><span class="title">Day Book</span></a></li>
				</ul>
			</li>
				</ul> 
			</li>
		</ul>		
  </div>
  <div class="main-container">
  
		<!-- Main header -->
		<div class="main-header row">
		  <div class="col-sm-6 col-xs-7">
		  
			<!-- User info -->
			<ul class="user-info pull-left">          
			  <li class="profile-info dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"> <img width="44" class="img-circle avatar" alt="" 
				src="D:/wamp/www/mouldifi/storage/users/users/eee78d1ff86fa298518be24412aa83ad.jpg">{{ Auth::user()->name }} <span class="caret"></span></a>
				<ul class="dropdown-menu">
				  
				  <li><a href="/account/{{ Auth::user()->id }}/edit"><i class="icon-user"></i>My profile</a></li>
				  <li><a href="#/"><i class="icon-mail"></i>Messages</a></li>
				  <li><a href="#"><i class="icon-clipboard"></i>Tasks</a></li>
				  <li class="divider"></li>
				  <li><a href="/settings/1/edit"><i class="icon-cog"></i>System settings</a></li>
				  <li><a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form></li>
				</ul>
			  </li>
			</ul>
		  </div>
		  <div class="col-sm-6 col-xs-5">
			<div class="pull-right">
				<ul class="user-info pull-left">
				  <li class="notifications dropdown">
					<a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-attention"></i><span class="badge badge-info">6</span></a>
					<ul class="dropdown-menu pull-right">
						<li class="first">
							<div class="small"><a class="pull-right danger" href="#">Mark all Read</a> You have <strong>3</strong> new notifications.</div>
						</li>
						<li>
							<ul class="dropdown-list">
								<li class="unread notification-success"><a href="#"><i class="icon-user-add pull-right"></i><span class="block-line strong">New user registered</span><span class="block-line small">30 seconds ago</span></a></li>
								<li class="unread notification-secondary"><a href="#"><i class="icon-heart pull-right"></i><span class="block-line strong">Someone special liked this</span><span class="block-line small">60 seconds ago</span></a></li>
								<li class="unread notification-primary"><a href="#"><i class="icon-user pull-right"></i><span class="block-line strong">Privacy settings have been changed</span><span class="block-line small">2 hours ago</span></a></li>
								<li class="notification-danger"><a href="#"><i class="icon-cancel-circled pull-right"></i><span class="block-line strong">Someone special liked this</span><span class="block-line small">60 seconds ago</span></a></li>
								<li class="notification-info"><a href="#"><i class="icon-info pull-right"></i><span class="block-line strong">Someone special liked this</span><span class="block-line small">60 seconds ago</span></a></li>
								<li class="notification-warning"><a href="#"><i class="icon-rss pull-right"></i><span class="block-line strong">Someone special liked this</span><span class="block-line small">60 seconds ago</span></a></li>
							</ul>
						</li>
						<li class="external-last"> <a href="#" class="danger">View all notifications</a> </li>
					</ul>
				  </li>
				  <li class="notifications dropdown">
					<a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-mail"></i><span class="badge badge-secondary">12</span></a>
					<ul class="dropdown-menu pull-right">
						<li class="first">
							<div class="dropdown-content-header"><i class="fa fa-pencil-square-o pull-right"></i> Messages</div>
						</li>
						<li>
							<ul class="media-list">
								<li class="media">
									<div class="media-left"><img alt="" class="img-circle img-sm" src="images/domnic-brown.png"></div>
									<div class="media-body">
										<a class="media-heading" href="#">
											<span class="text-semibold">Domnic Brown</span>
											<span class="media-annotation pull-right">Tue</span>
										</a>
										<span class="text-muted">Your product sounds interesting I would love to check this ne...</span>
									</div>
								</li>
								<li class="media">
									<div class="media-left"><img alt="" class="img-circle img-sm" src="images/john-smith.png"></div>
									<div class="media-body">
										<a class="media-heading" href="#">
											<span class="text-semibold">John Smith</span>
											<span class="media-annotation pull-right">12:30</span>
										</a>
										<span class="text-muted">Thank you for posting such a wonderful content. The writing was outstanding...</span>
									</div>
								</li>
								<li class="media">
									<div class="media-left"><img alt="" class="img-circle img-sm" src="images/stella-johnson.png"></div>
									<div class="media-body">
										<a class="media-heading" href="#">
											<span class="text-semibold">Stella Johnson</span>
											<span class="media-annotation pull-right">2 days ago</span>
										</a>
										<span class="text-muted">Thank you for trusting us to be your source for top quality sporting goods...</span>
									</div>
								</li>
								<li class="media">
									<div class="media-left"><img alt="" class="img-circle img-sm" src="images/alex-dolgove.png"></div>
									<div class="media-body">
										<a class="media-heading" href="#">
											<span class="text-semibold">Alex Dolgove</span>
											<span class="media-annotation pull-right">10:45</span>
										</a>
										<span class="text-muted">After our Friday meeting I was thinking about our business relationship and how fortunate...</span>
									</div>
								</li>
								<li class="media">
									<div class="media-left"><img alt="" class="img-circle img-sm" src="images/domnic-brown.png"></div>
									<div class="media-body">
										<a class="media-heading" href="#">
											<span class="text-semibold">Domnic Brown</span>
											<span class="media-annotation pull-right">4:00</span>
										</a>
										<span class="text-muted">I would like to take this opportunity to thank you for your cooperation in recently completing...</span>
									</div>
								</li>
							</ul>
						</li>
						<li class="external-last"> <a class="danger" href="#">All Messages</a> </li>
					</ul>
				  </li>
				</ul>
			</div>
		  </div>
		</div>
		<div class="main-content">
			@yield("contents")
	  </div>
  </div>
</div>
<center>
	<footer class="footer-main" style="background: #16202F;"> 
	&copy; 2016 <strong><?php echo $quee["title"]; ?>.</strong> Developed By <a target="_blank" href="http://www.itlife.com.pk/">IT Life</a> 
</footer>
</center>
<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/plugins/metismenu/jquery.metisMenu.js"></script>
<script src="/js/plugins/blockui-master/jquery-ui.js"></script>
<script src="/js/plugins/blockui-master/jquery.blockUI.js"></script>
<!--Float Charts-->
<script src="/js/plugins/flot/jquery.flot.min.js"></script>
<script src="/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="/js/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="/js/plugins/flot/jquery.flot.selection.min.js"></script>        
<script src="/js/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="/js/plugins/flot/jquery.flot.time.min.js"></script>
<script src="/js/functions.js"></script>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script> -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>

<script type="text/javascript">
	$(".livesearch").chosen();
</script>


<!--ChartJs-->
<script src="/js/plugins/chartjs/Chart.min.js"></script>

<script>
	$(document).ready(function () {
		var $checkbox = $('.todo-list .checkbox input[type=checkbox]');

		$checkbox.change(function () {
			if ($(this).is(':checked')) {
				$(this).parent().addClass('checked');
			} else {
				$(this).parent().removeClass('checked');
			}
		});

		$checkbox.each(function (index) {
			if ($(this).is(':checked')) {
				$(this).parent().addClass('checked');
			} else {
				$(this).parent().removeClass('checked');
			}
		});

		// charts
		var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

		var previousPoint = null;
		$('#graph-bars, #graph-lines').bind('plothover', function (event, pos, item) {
			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					$('#flotTip').remove();
					var x = item.datapoint[0],
							y = item.datapoint[1];

					var color = item.series.color;
					var day = new Date(x).getDate();
					var month = monthNames[new Date(x).getMonth()];
					var year = new Date(x).getFullYear();
					showTooltip(item.pageX,
							item.pageY,
							day + ' ' + month + ',' + year
							+ " : <strong>" + y +
							" visitors</strong>");

					/*content = item.series.label + ' = ' + item.datapoint[1];
					 showTooltip(item.pageX, item.pageY, content);
					 showTooltip(item.pageX, item.pageY, y + ' visitors at ' + x + '.00h');*/

				}
			} else {
				$('#flotTip').remove();
				previousPoint = null;
			}
		});

		var graphData = [{
				// Visits
				data: [[1196463600000, 45], [1196550000000, 30], [1196636400000, 98], [1196722800000, 37], [1196809200000, 95], [1196895600000, 45], [1196982000000, 65],
					[1197068400000, 120], [1197154800000, 90], [1197241200000, 65], [1197327600000, 50]],
				color: '#ef193c'
			}, {
				// Returning Visits
				data: [[1196463600000, 100], [1196550000000, 170], [1196636400000, 260], [1196722800000, 127], [1196809200000, 240], [1196895600000, 180], [1196982000000, 160],
					[1197068400000, 210], [1197154800000, 270], [1197241200000, 120], [1197327600000, 85]],
				color: '#2196d4',
			}
		];


		// Lines
		$.plot($('#graph-lines'), graphData, {
			series: {
				points: {
					show: true,
					radius: 3.5
				},
				lines: {
					show: true,
					fill: true,
				},
				shadowSize: 0
			},
			grid: {
				color: '#646464',
				borderColor: 'transparent',
				borderWidth: 20,
				hoverable: true
			},
			xaxis: {
				mode: "time",
				tickColor: 'transparent',
				tickDecimals: 2
			},
			yaxis: {
				tickSize: 100
			}
		});

		// Bars
		$.plot($('#graph-bars'), graphData, {
			series: {
				points: {
					show: true,
					radius: 3.5,
				},
				lines: {
					show: true,
					fill: false
				},
				bars: {
					show: false,
					lineWidth: 5,
					align: 'center'
				},
				shadowSize: 0,
				hoverable: true
			},
			grid: {
				color: '#646464',
				borderColor: 'transparent',
				borderWidth: 20,
				hoverable: true
			},
			xaxis: {
				mode: "time",
				tickColor: 'transparent',
				tickDecimals: 2
			},
			yaxis: {
				tickSize: 100
			}
		});

		var $graphBar = $('#graph-bars'), $graphLine = $('#graph-lines'), $linkLine = $('#lines'), $linkBar = $('#bars');
		$graphBar.hide();
		$linkLine.on('click', function (e) {
			e.preventDefault();

			$linkBar.removeClass('active');
			$graphBar.fadeOut(function () {
				$(this).addClass('active');
				$graphLine.fadeIn();
			});
		});
		$linkBar.on('click', function (e) {
			e.preventDefault();

			$linkLine.removeClass('active');
			$graphLine.fadeOut(function () {
				$(this).addClass('active');
				$graphBar.fadeIn();
			});
		});

		var revenueData = [{
				// Visits
				data: [[1475280000000, 400.05], [1475366400000, 1600.32], [1475452800000, 900.35], [1475539200000, 2100.31], [1475625600000, 1800.55], [1475712000000, 900.42], [1475798400000, 2885.01], [1475884800000, 1870.97], [1475971200000, 2145.14], [1476057600000, 1130.14], [1476144000000, 1490.02], [1476230400000, 740.74], [1476316800000, 1280.88], [1476403200000, 1157.71], [1476489600000, 599.71], [1476576000000, 2159.89], [1476662400000, 1557.81], [1476748800000, 959.06], [1476835200000, 158.00], [1476921600000, 757.99], [1477008000000, 800], [1477094400000, 950.25], [1477180800000, 1289.22], [1477267200000, 400.52], [1477353600000, 2425], [1477440000000, 1300.35], [1477526400000, 1600.20], [1477612800000, 890.65], [1477699200000, 2165.29], [1477785600000, 1566.22], [1477872000000, 2064.33]],
				//data: [[6, 400], [7, 1600], [8, 900], [9, 2100], [10, 1200], [12, 1800]],
				//data: [[1167692400000, 1600.05], [1167778800000, 5800.32], [1167865200000, 570.35], [1167951600000, 5600.31], [1168210800000, 1155.55], [1168297200000, 2255.64], [1168383600000, 5334.02], [1168470000000, 1151.88], [1168556400000, 3352.99], [1168815600000, 2652.99], [1168902000000, 3251.21], [1168988400000, 4152.24], [1169074800000, 4450.48], [1169161200000, 7751.99], [1169420400000, 5851.13], [1169506800000, 1555.04], [1169593200000, 55.37], [1169679600000, 54.23], [1169766000000, 55.42], [1170025200000, 54.01], [1170111600000, 56.97], [1170198000000, 58.14], [1170284400000, 58.14], [1170370800000, 59.02], [1170630000000, 58.74], [1170716400000, 58.88], [1170802800000, 57.71], [1170889200000, 59.71], [1170975600000, 59.89], [1171234800000, 57.81], [1171321200000, 59.06], [1171407600000, 58.00], [1171494000000, 57.99], [1171580400000, 59.39], [1171839600000, 59.39], [1171926000000, 58.07], [1172012400000, 60.07], [1172098800000, 61.14], [1172444400000, 61.39], [1172530800000, 61.46], [1172617200000, 61.79], [1172703600000, 62.00], [1172790000000, 60.07], [1173135600000, 60.69], [1173222000000, 61.82], [1173308400000, 60.05], [1173654000000, 58.91], [1173740400000, 57.93], [1173826800000, 58.16], [1173913200000, 57.55], [1173999600000, 57.11], [1174258800000, 56.59], [1174345200000, 59.61], [1174518000000, 61.69], [1174604400000, 62.28], [1174860000000, 62.91], [1174946400000, 62.93], [1175032800000, 64.03], [1175119200000, 66.03], [1175205600000, 65.87], [1175464800000, 64.64], [1175637600000, 64.38], [1175724000000, 64.28], [1175810400000, 64.28], [1176069600000, 61.51], [1176156000000, 61.89], [1176242400000, 62.01], [1176328800000, 63.85], [1176415200000, 63.63], [1176674400000, 63.61], [1176760800000, 63.10], [1176847200000, 63.13], [1176933600000, 61.83], [1177020000000, 63.38], [1177279200000, 64.58], [1177452000000, 65.84], [1177538400000, 65.06], [1177624800000, 66.46], [1177884000000, 64.40], [1178056800000, 63.68], [1178143200000, 63.19], [1178229600000, 61.93], [1178488800000, 61.47], [1178575200000, 61.55], [1178748000000, 61.81], [1178834400000, 62.37], [1179093600000, 62.46], [1179180000000, 63.17], [1179266400000, 62.55], [1179352800000, 64.94], [1179698400000, 66.27], [1179784800000, 65.50], [1179871200000, 65.77], [1179957600000, 64.18], [1180044000000, 65.20], [1180389600000, 63.15], [1180476000000, 63.49], [1180562400000, 65.08], [1180908000000, 66.30], [1180994400000, 65.96], [1181167200000, 66.93], [1181253600000, 65.98], [1181599200000, 65.35], [1181685600000, 66.26], [1181858400000, 68.00], [1182117600000, 69.09], [1182204000000, 69.10]],
				color: '#fff',
				label: 'Revenue($)',
				dashes: {show: true}
			}
		];

		$('#placeholder_overview, #Revenue-lines').bind('plothover', function (event, pos, item) {
			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					$('#flotTip').remove();
					var x = item.datapoint[0],
							y = item.datapoint[1];
					//showTooltip(item.pageX, item.pageY, y + ' visitors at ' + x + '.00h');

					var color = item.series.color;
					var day = new Date(x).getDate();
					var month = monthNames[new Date(x).getMonth()];
					var year = new Date(x).getFullYear();
					showTooltip(item.pageX,
							item.pageY,
							day + ' ' + month + ',' + year
							+ " : <strong>" + y +
							"($)</strong>");
				}
			} else {
				$('#flotTip').remove();
				previousPoint = null;
			}
		});

		var options = {
			series: {
				points: {
					show: true,
					radius: 3.5,
					fillColor: "rgba(0,0,0,0.35)",
				},
				lines: {
					show: true,
					lineWidth: 2,
					fill: true
				},
				bars: {
					show: false,
					lineWidth: 2
				},
				shadowSize: 10,
				//highlightColor: '#fff',
				hoverable: true,
				clickable: true,
			},
			grid: {
				color: '#646464',
				borderColor: 'transparent',
				borderWidth: 20,
				hoverable: true,
				tickColor: "rgba(255,255,255,0.05)",
				markingsColor: "rgba(255,255,255,0.05)",
				markingsLineWidth: 5,
				/*backgroundColor: {
					colors: ["rgba(54,58,60,0.05)", "rgba(0,0,0,0.2)"]
				}*/
			},
			legend: {
				show: true
			},
			xaxis: {
				mode: 'time',
				font: {
					weight: "bold"
				},
				color: "#D6D8DB",
				tickColor: 'transparent',
				tickDecimals: 2
			},
			selection: {
				mode: "x"
			},
			yaxis: {
				font: {
					weight: "bold"
				},
				color: "#D6D8DB",
				tickSize: 500
			}
		};

		// Lines
		var plot = $.plot($('#Revenue-lines'), revenueData, options);

		// Bars
		var overview = $.plot($("#placeholder_overview"), revenueData, {
			colors: ["#edc240", "#5eb95e"],
			series: {
				bars: {
					show: true,
					lineWidth: 5,
					fillColor: "#5eb95e"
				},
				shadowSize: 2,
				grow: {
					active: false
				}
			},
			legend: {
				show: false
			},
			xaxis: {
				ticks: [],
				mode: "time"
			},
			yaxis: {
				ticks: [],
				min: 0,
				autoscaleMargin: 0.1
			},
			selection: {
				mode: "x"
			},
			grid: {
				color: "#D6D8DB",
				borderColor: 'transparent',
				markingsColor: "rgba(255,255,255,0.05)",
				/*backgroundColor: {
					colors: ["rgba(54,58,60,0.05)", "rgba(0,0,0,0.2)"]
				}*/
			}
		});

		$("#Revenue-lines").bind("plotselected", function (event, ranges) {
			// do the zooming
			plot = $.plot($("#Revenue-lines"), revenueData,
					$.extend(true, {}, options, {
						xaxis: {
							min: ranges.xaxis.from,
							max: ranges.xaxis.to
						}
					}));

			// don't fire event on the overview to prevent eternal loop
			overview.setSelection(ranges, true);
		});

		$("#placeholder_overview").bind("plotselected", function (event, ranges) {
			plot.setSelection(ranges);
		});

		$("#Revenuelines").click(function (event) {
			event.preventDefault();
			overview.clearSelection();
			$.plot($("#Revenue-lines"), revenueData, options);
		});

		// pie graph
		var doughnutData = [
			{
				value: 5742,
				color: "#22b66f",
				highlight: "#12a65f",
				label: "Only Visited"
			},
			{
				value: 2496,
				color: "#f3c111",
				highlight: "#e7b505",
				label: "Purchased"
			},
			{
				value: 1762,
				color: "#ef193c",
				highlight: "#e81235",
				label: "Bounced"
			}
		];

		var doughnutOptions = {
			segmentShowStroke: true,
			segmentStrokeColor: "transparent",
			segmentStrokeWidth: 0,
			percentageInnerCutout: 60, // This is 0 for Pie charts
			animationSteps: 100,
			animationEasing: "easeOutBounce",
			animateRotate: true,
			animateScale: false,
			responsive: true,
			//String - A legend template
			legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
		};

		var canvas = document.getElementById("doughnutChart");
		var helpers = Chart.helpers;
		//var ctx = document.getElementById("doughnutChart").getContext("2d");
		var moduleDoughnut = new Chart(canvas.getContext("2d")).Doughnut(doughnutData, doughnutOptions);
		var legendHolder = document.createElement('div');
		legendHolder.innerHTML = moduleDoughnut.generateLegend();
		helpers.each(legendHolder.firstChild.childNodes, function (legendNode, index) {
			helpers.addEvent(legendNode, 'mouseover', function () {
				var activeSegment = moduleDoughnut.segments[index];
				activeSegment.save();
				activeSegment.fillColor = activeSegment.highlightColor;
				moduleDoughnut.showTooltip([activeSegment]);
				activeSegment.restore();
			});
		});
		helpers.addEvent(legendHolder.firstChild, 'mouseout', function () {
			moduleDoughnut.draw();
		});
		canvas.parentNode.parentNode.appendChild(legendHolder.firstChild);
	});
</script>
			<script type="text/javascript">
		function checkDelete(id, resource, redirectUrl) {
		//resource = "http://localhost:8000" + resource;
		if (confirm('Are you sure you want to delete this record?')) {
		   var deleteToken = $("#hrefDelete").attr("data-token");
		   $.ajax({
			  type: "GET",
			  //data: {price_range: "100", _method: "DELETE", _token: "" + deleteToken + ""},
			  //data: {price_range: "100", _method: "DELETE", _token: "" + deleteToken + ""},
			  url: resource,
			  success: function(result) {
				alert(result);
				window.location.href = redirectUrl;
			  },
				error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			  }
			});
		  }
		}
		</script>
@yield("scripts")
</body>

<!-- Mirrored from g-axon.com/mouldifi-3.0/dark/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Nov 2016 11:01:25 GMT -->
</html>
