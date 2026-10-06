<div class="row">
		<div class="col-sm-6">
		<center><h3><u><b>{{$company_detail[0]->system_name}}</b></u></h3></center>
		<center><b>{{$company_detail[0]->address}}</b></center>
		<center><b>PH :{{$company_detail[0]->phone}}</b><center>
		<center><b>Email :{{$company_detail[0]->email}}</b><center>
		</div>
		<div class="col-sm-3">
		</div>
		<div class="col-sm-3">
			<span style="float:right;margin-top:-19px;"><?php $t=time(); ($t . "<br>"); echo(date("d-m-Y",$t));?></span>
		</div>
		</div>