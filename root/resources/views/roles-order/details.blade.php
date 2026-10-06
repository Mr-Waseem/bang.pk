@extends("app")
@section("contents")
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Teacher Details
            <!--<small>Control panel</small>-->
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Teacher Details</a></li>
            <li class="active">Home</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<div class="panel panel-default">
				<div class="panel-heading">Teacher Detail
				<p style="float: right;"><a href="/teachers/">Home</a></p>
				</div>
									<div class="panel-body">
					<div class="row">
						<div class="col-md-4">
							<div class="panel panel-default">
								<div class="panel-heading">{{ $details->name }} Image</div>
								<div class="panel-body">
									<div class="row">
									<a href="\upload\teachers\{{ $details->image }}" class="thumbnail" style="border: none;">
										<img src="\upload\teachers\{{ $details->image }}" alt="Teacher Image" class="online" style="border-radius: 20px;width: 200px; height: 200px;border: 2px solid green;    margin-left: 60px;">
										<center>Click it for normal view</center>
										</a>
									</div>
									
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="panel panel-default">
								<div class="panel-heading">Introduction</div>
								<div class="panel-body">
									<div class="row">
										<p><b style="margin-left: 15px;">Name:</b>  {{ $details->name }}</p>
										<p><b style="margin-left: 15px;">Birth Day:</b>  {{ $details->birthday }}</p>
										<p><b style="margin-left: 15px;">Gender:</b>  {{ $details->gender }}</p>
										<p><b style="margin-left: 15px;">Phone:</b>  {{ $details->phone }}</p>
										</br></br></br></br></br></br></br>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="panel panel-default">
								<div class="panel-heading">Address</div>
								<div class="panel-body">
									<div class="row">
										<p><b style="margin-left: 15px;">Email:</b>  {{ $details->email }}</p>
										<p><b style="margin-left: 15px;">Address:</b>  {{ $details->address }}</p></br></br>
									</div>
								</div>
							</div>
							<!--
							<div class="panel panel-default">
								<div class="panel-heading">Level Groups</div>
								<div class="panel-body">
									<div class="row">
										<p><b style="margin-left: 15px;">Yahoo Level1 Group:</b>  {{ $details->yahoo_level1_group }}</p></br>
										<p><b style="margin-left: 15px;">Yahoo Level2 Group:</b>  {{ $details->yahoo_level2_group }}</p></br></br>
									</div>
								</div>
							</div>
							--->
						</div>
						<!--						
						<div class="col-md-4">
							<div class="panel panel-default">
								<div class="panel-heading">Is Approved</div>
								<div class="panel-body">
									<div class="row">
										<p><b style="margin-left: 15px;">Is Approved:</b>  {{ $details->is_approved }}</p></br></br></br>
									</div>
								</div>
							</div>
						</div>
						-->						
					</div>

				</div>
			</div>          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@stop	  