<head>
  <link href="/css/select2.min.css" rel="stylesheet" />

</head>
<html>
	<head>
		<meta charset="utf-8">
		<title>Invoice</title>
		<link rel="stylesheet" href="style.css">
		<link rel="license" href="https://www.opensource.org/licenses/mit-license/">
		<script src="script.js"></script>
		<style>
/* reset */

*
{
	/*border: 0;*/
	box-sizing: content-box;
	color: inherit;
	font-family: inherit;
	font-size: inherit;
	font-style: inherit;
	font-weight: inherit;
	line-height: inherit;
	list-style: none;
	margin: 0;
	padding: 0;
	text-decoration: none;
	vertical-align: top;
}

/* content editable */

*[data-prefix] { border-radius: 0.25em; min-width: 1em; outline: 0; }

*[data-prefix] { cursor: pointer; }

*[data-prefix]:hover, *[data-prefix]:focus, td:hover *[data-prefix], td:focus *[data-prefix], img.hover { background: #DEF; box-shadow: 0 0 1em 0.5em #DEF; }

span[data-prefix] { display: inline-block; }

/* heading */

h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }

/* table */

table { font-size: 75%; table-layout: fixed; width: 100%; }
table { border-collapse: separate; border-spacing: 2px; }
th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
th, td { border-radius: 0.25em; border-style: solid; }
th { background: #EEE; border-color: #BBB; }
td { border-color: #DDD; }

/* page */

html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
html { background: #999; cursor: default; }

body { box-sizing: border-box; height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; }
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

/* header */

header { margin: 0 0 3em; }
header:after { clear: both; content: ""; display: table; }

header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
header address p { margin: 0 0 0.25em; }
header span, header img { display: block; float: right; }
header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
header img { max-height: 100%; max-width: 100%; }
header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

/* article */

article, article address, table.meta, table.inventory { margin: 0 0 3em; }
article:after { clear: both; content: ""; display: table; }
article h1 { clip: rect(0 0 0 0); position: absolute; }

article address { float: left; font-size: 125%; font-weight: bold; }

/* table meta & balance */

table.meta, table.balance { float: left; width: 33%; }
table.meta:after, table.balance:after { clear: both; content: ""; display: table; }

/* table meta */

table.meta th { width: 40%; }
table.meta td { width: 60%; }

/* table items */

table.inventory { clear: both; width: 100%; }
table.inventory th { font-weight: bold; text-align: center; }

table.inventory td:nth-child(1) { width: 26%; }
table.inventory td:nth-child(2) { width: 38%; }
table.inventory td:nth-child(3) { text-align: right; width: 12%; }
table.inventory td:nth-child(4) { text-align: right; width: 12%; }
table.inventory td:nth-child(5) { text-align: right; width: 12%; }

/* table balance */

table.balance th, table.balance td { width: 50%; }
table.balance td { text-align: right; }

/* aside */

aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
aside h1 { border-color: #999; border-bottom-style: solid; }

/* javascript */

.add, .cut
{
	border-width: 1px;
	display: block;
	font-size: .8rem;
	padding: 0.25em 0.5em;	
	float: left;
	text-align: center;
	width: 0.6em;
}

.add, .cut
{
	background: #9AF;
	box-shadow: 0 1px 2px rgba(0,0,0,0.2);
	background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
	background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
	border-radius: 0.5em;
	border-color: #0076A3;
	color: #FFF;
	cursor: pointer;
	font-weight: bold;
	text-shadow: 0 -1px 2px rgba(0,0,0,0.333);
}

.add { margin: -2.5em 0 0; }

.add:hover { background: #00ADEE; }

.cut { opacity: 0; position: absolute; top: 0; left: -1.5em; }
.cut { -webkit-transition: opacity 100ms ease-in; }

tr:hover .cut { opacity: 1; }

@media print {
	* { -webkit-print-color-adjust: exact; }
	html { background: none; padding: 0; }
	body { box-shadow: none; margin: 0; }
	span:empty { display: none; }
	.add, .cut { display: none; }
}

@page { margin: 0; }
		</style>
	</head>
	<center><img src="/upload/logo/{{$logo[0]->image}}"></center>
	<body style="width: 10.5in;">
		<a href="javascript:window.print();"><header>
			<h1>ORDER FORM</h1>
			<!-- <address data-prefix>
				<p>Jonathan Neal</p>
				<p>101 E. Chapman Ave<br>Orange, CA 92866</p>
				<p>(800) 555-1234</p>
			</address>
			<span><img alt="" src="http://www.jonathantneal.com/examples/invoice/logo.png"><input type="file" accept="image/*"></span> -->
		</header></a>
		<article>
			<h1>Recipient</h1>

			<table class="meta">
				<tr>
					<th><span data-prefix>Date</span></th>
					<td><span>{{date("d/m/Y", Strtotime($details[0]->voucher_date))}}</span></td>
				</tr>
				<tr>
					<th><span data-prefix>Delivery Date</span></th>
					<td><span>{{date("d/m/Y", Strtotime($details[0]->delivery_date))}}</span></td>
				</tr>
				<tr>
					<th><span>Customer Name</span></th>
					<td><span>{{$details[0]->customer->party_name}}</span></td>
				</tr>
			
				<tr>
					<th><span>Phone</span></th>
					<td><span>{{$details[0]->customer->phone}}</span></td>
				</tr>
				<tr>
					<th><span>Remarks</span></th>
					<td><span>{{$details[0]->remarks}}</span></td>
				</tr>
			</table>
			<table class="meta">
				<!-- <tr>
					<th><span data-prefix>Invoice #</span></th>
					<td><span data-prefix>101138</span></td>
				</tr>
				<tr>
					<th><span data-prefix>Date</span></th>
					<td><span data-prefix>January 1, 2012</span></td>
				</tr>
				<tr>
					<th><span data-prefix>Amount Due</span></th>
					<td><span id="prefix" data-prefix>$</span><span>600.00</span></td>
				</tr> -->
			</table>
			<table class="meta">
				<tr>
					<th><span data-prefix>Voucher No</span></th>
					<td><span data-prefix>{{$details[0]->voucher_no}}</span></td>
				</tr>
				<tr>
					<th><span data-prefix>City</span></th>
					<td><span data-prefix>{{$details[0]->customer->city}}</span></td>
				</tr>
				<tr>
					<th><span data-prefix>Email</span></th>
					<td><span>{{$details[0]->customer->email}}</span></td>
				</tr>
				<tr>
					<th><span data-prefix>Address</span></th>
					<td><span>{{$details[0]->customer->address}}</span></td>
				</tr>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span data-prefix>CODE</span></th>
						<th style="width:20%; text-align: left;"><span data-prefix>PRODUCT&nbsp;NAME</span></th>
						<th><span data-prefix>QUANTITY/Kgs</span></th>
						<th><span data-prefix>RATE/Kgs</span></th>
						<th><span data-prefix>PACKING</span></th>
						<th><span data-prefix>PAYMENT TERMS</span></th>
						
					</tr>
				</thead>
				<tbody id="myData">
					@foreach($details[0]->order_details as $data)
					<tr>
						<td><span data-prefix>{{$data->products->product_code}}</span></td>
						<td><span data-prefix>{{$data->products->product_name}}</span></td>
						<td style="text-align: center;"><span data-prefix>{{$data->quantity}}</span></td>
						<td style="text-align: center;"><span data-prefix>{{$data->price}}</span></td>
						<td style="text-align: center;"><span data-prefix>{{$data->uom->uom}}</span></td>
						<td><span data-prefix>{{$data->terms}}</span></td>
						
					</tr>
					@endforeach
				</tbody>
			</table>
			<!-- <a class="add">+</a> -->
			<!-- <table class="balance">
				<tr>
					<th><span data-prefix>Total Cost</span></th>
					<td><span data-prefix><input type="text" id="TotalAmount" name="TotalAmount" value="0" style="color: black; background: none; border:none;" disabled></span></td>


				</tr>
				<tr style="display: none;">
					<th><span data-prefix>Amount Paid</span></th>
					<td><span data-prefix><input type="text" id="rates" name="rates" value="0" style="color: black;" disabled></span></td>
				</tr>
				<tr style="display: none;">
					<th><span data-prefix>Balance Due</span></th>
					<td><span data-prefix>$</span><span><input type="text" id="amounts" name="amounts" value="0" style="color: black;" disabled></span></td>
				</tr>
			</table> -->
		</article>
		<aside>
			<h1><span data-prefix>Created By: {{$details[0]->billers->name}}</span></h1>
			<div data-prefix>
				<p>This is computer generated invoice. No need to any signature or stamp.</p>
			</div>
		</aside>
	</body>
</html>

<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script src="/js/plugins/nouislider/nouislider.min.js"></script>
<!-- Input Mask-->
<script src="/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<!-- Select2-->
<script src="/js/plugins/select2/select2.full.min.js"></script>
<!--Bootstrap ColorPicker-->
<script src="/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!--Bootstrap DatePicker-->
<script src="/js/plugins/datepicker/bootstrap-datepicker.js"></script>



<script type="text/javascript">

</script>