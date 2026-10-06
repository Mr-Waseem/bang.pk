<?php
use App\Models\Setting;
$Settings = Setting::where('id', '=', 1)->get();
?>
<head>
  <link href="{{ asset('css/bg.css') }}" rel="stylesheet">
</head>
    <!-- <center><h3><u><b id="systemTitle">{{ session()->get('company_name') }}</b></u></h3></center>
	<center><b id="systemDetail">{{ session()->get('company_address') }}</b></center>
	<center><b id="systemDetail">PH :{{ session()->get('company_phone') }}</b><center>
	<center><b id="systemDetail">Email :{{ session()->get('company_email') }}</b><center>
	<br>
		<span style="float: right;margin-top: -19px " id="systemDetail">@php
				$t=time(); ($t . "<br>"); echo(date("d/m/Y",$t));
			@endphp
		</span> -->

		  <div class="report-header">
    <div class="company-info">
      <h1>{{ session()->get('company_name') }}</h1>
      <p>{{ session()->get('company_address') }}</p>
    </div>
    <div class="report-info">
      <p>Report Generated: @php
				$t=time(); ($t . "<br>"); echo(date("d/m/Y",$t));
			@endphp</p>
    </div>
  </div>
