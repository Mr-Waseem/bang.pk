	<?php
use App\Models\Setting;
$settings = Setting::where('id', 1)->first();
?>
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
      <a class="navbar-brand" href="<?php echo e(URL::to('dashboard')); ?>" id="menufont"><?php echo $quee["system_name"];?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <!-- <li style="border-bottom: 1px solid grey;"><a href="<?php echo e(asset('roles')); ?>" style="color: white"><b>Roles</b></a></li> -->
        <li style="border-bottom: 1px solid grey;"><a href="<?php echo e(asset('account-group')); ?>" style="color: white"><b>Account Group</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="<?php echo e(asset('scenarios')); ?>" style="color: white"><b>Scenarios</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="<?php echo e(asset('sro-schedules')); ?>" style="color: white"><b>SRO Schedules</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="<?php echo e(asset('sro-items')); ?>" style="color: white"><b>SRO Items#</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="<?php echo e(asset('taxes')); ?>" style="color: white"><b>Taxes</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="<?php echo e(asset('products')); ?>" style="color: white"><b>Admin Products</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="<?php echo e(asset('admin-company-report')); ?>" style="color: white"><b>Report</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="<?php echo e(URL::to('print-reports/create')); ?>" style="color: white"><b>Print Reports</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="<?php echo e(asset('ratings')); ?>" style="color: white"><b>Rating</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="<?php echo e(asset('clients')); ?>" style="color: white"><b>Clients</b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="<?php echo e(asset('copy-customer')); ?>" style="color: white"><b>Copy</b></a></li>
        
        <!-- <li style="border-bottom: 1px solid grey;"><a href="#" style="color: white"><b>Phone: <?php echo e($settings->phone); ?></b></a></li>
        <li style="border-bottom: 1px solid grey;"><a href="#" style="color: white"><b>Email: <?php echo e($settings->email); ?></b></a></li> -->
        
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
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: black;font-weight: bold;"><?php echo e(Auth::user()->name); ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo e(URL::to('account')); ?>"><i class="icon-user"></i>Account Setting</a></li>
             <li><a href="<?php echo e(URL::to('settings/1/edit')); ?>"><i class="icon-cog"></i>System settings</a></li>
				  <!-- <li><a href="#/"><i class="icon-mail"></i>Messages</a></li>
				  <li><a href="#"><i class="icon-clipboard"></i>Tasks</a></li> -->
				  <li class="divider"></li>
				 
				  <li>
            <?php if(session()->has('company_id')): ?>
              <a href="<?php echo e(asset('logout-company')); ?>">Select Company</a>
            <?php else: ?>
              <a href="<?php echo e(URL::to('logout')); ?>" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
              <form id="logout-form" action="<?php echo e(URL::to('logout')); ?>" method="POST" style="display: none;">
                <?php echo e(csrf_field()); ?>

              </form> 
            <?php endif; ?>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav><?php /**PATH D:\Axis-Coding\xampp-8.2.12\htdocs\it_life_work\digital-invoicing\root\resources\views/navbars/admin.blade.php ENDPATH**/ ?>