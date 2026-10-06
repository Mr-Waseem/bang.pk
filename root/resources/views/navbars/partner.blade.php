	<nav class="navbar navbar-default" style="margin-bottom: 0px;">
  <div class="container-fluid" id="menubg">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ URL::to('dashboard') }}" id="menufont"><?php echo $quee["system_name"];?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <!-- <li style="border-bottom: 1px solid grey;"><a href="{{ asset('roles') }}" style="color: white"><b>Roles</b></a></li> -->
        <!-- <li style="border-bottom: 1px solid grey;"><a href="{{ asset('account-group') }}" style="color: white"><b>Account Group</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="{{ asset('scenarios') }}" style="color: white"><b>Scenarios</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="{{ asset('sro-schedules') }}" style="color: white"><b>SRO Schedules</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="{{ asset('sro-items') }}" style="color: white"><b>SRO Items#</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="{{ asset('taxes') }}" style="color: white"><b>Taxes</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="{{ asset('products') }}" style="color: white"><b>Admin Products</b></a></li> -->
        
        <li style="border-bottom: 1px solid grey;"><a href="#" style="color: white"><b>Phone: +92-321-4197290</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="mailto:fbrdigitalinvoice.pk" style="color: white"><b>Email: info@bang.pk</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="https://fbrdigitalinvoice.pk" target="_blank" style="color: white"><b>Website: bang.pk</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('print-reports/create') }}" style="color: white"><b>Print Reports</b></a></li>
        <!-- <li style="border-bottom: 1px solid grey;"><a href="#" style="color: white"><b>Address: 33-A Commercial, Pak Arab Housing Scheme, Lahore.</b></a></li> -->
      </ul>
      <!-- <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form> -->
      <ul class="nav navbar-nav navbar-right">
        <!-- <li><a href="#">Link</a></li> -->
        <li class="dropdown" style="font-family: monospace;">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: black;font-weight: bold;">{{ Auth::user()->name }}<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ URL::to('account') }}"><i class="icon-user"></i>Account Setting</a></li>
             <!-- <li><a href="{{ URL::to('settings/1/edit') }}"><i class="icon-cog"></i>System settings</a></li> -->
				  <!-- <li><a href="#/"><i class="icon-mail"></i>Messages</a></li>
				  <li><a href="#"><i class="icon-clipboard"></i>Tasks</a></li> -->
				  <li class="divider"></li>
				 
				  <li>
            @if (session()->has('company_id'))
              <a href="{{ asset('logout-company') }}">Select Company</a>
            @else
              <a href="{{ URL::to('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
              <form id="logout-form" action="{{ URL::to('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form> 
            @endif
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>