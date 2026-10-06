<?php echo $__env->make("/include.config", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php $__env->startSection('head'); ?>
    <link href="/css/plugins/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="/js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
    <div class="container-fluid">
        <?php if(Session::has('flash_message')): ?>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                style="margin-right: 20px;margin-top: 15px;">&times;</button>
            <div class="alert alert-success"> <?php echo e(Session::get('flash_message')); ?> </div>
        <?php endif; ?>
        <?php if(Session::has('error_message')): ?>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                style="margin-right: 20px;margin-top: 15px;">&times;</button>
            <div class="alert alert-danger"> <?php echo e(Session::get('error_message')); ?> </div>
        <?php endif; ?>
    </div>
    <div class="page-heading clearfix">
        <h1 class="page-title pull-left">Sales Tax</h1><a href="<?php echo e(asset('pos-salestax/create')); ?>" class="btn btn-primary btn-sm btn-add"
            role="button">Add Sale Tax Invoice</a>
    </div>
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="
     <?php echo e(asset('dashboard')); ?>"><i class="fa fa-home"></i>Home</a></li>
        <!-- <li><a href="/sales">Sales</a></li>  -->
        <li class="active"><strong>Sales Tax</strong></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Manage Sales Tax</h3>
                </div>
                <div class="panel-body">
                    <form method="GET" action="<?php echo e(asset('pos-salestax')); ?>" class="form-inline" style="margin-bottom: 20px;">
                        <div class="form-group" style="margin-right: 10px; margin-bottom: 10px;">
                            <label for="from_date" style="margin-right: 8px;">From</label>
                            <input type="date" name="from_date" id="from_date" class="form-control"
                                value="<?php echo e($fromDateInput); ?>" required>
                        </div>
                        <div class="form-group" style="margin-right: 10px; margin-bottom: 10px;">
                            <label for="to_date" style="margin-right: 8px;">To</label>
                            <input type="date" name="to_date" id="to_date" class="form-control"
                                value="<?php echo e($toDateInput); ?>" required>
                        </div>
                        <button type="submit" name="find" value="1" class="btn btn-primary" style="margin-bottom: 10px;">
                            <i class="fa fa-search"></i> Find
                        </button>
                    </form>
                    <div class="table-responsive">
                        <form method="get" action="salestax/multidelete">
                            <button type="submit" id="saveButton" class="btn btn-danger" style="margin-bottom:10px; display:none;">DELETE</button>
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th style="display:none;">
                                        <input type="checkbox" id="checkall" name="checkall"  onchange="selects();">
                                    </th>
                                    <th>Sr#</th>
                                    <th>Date</th>
                                    <th style="display:none;">DC#</th>
                                    <th>Inv#</th>
                                    <th>Tax Value</th>
                                    <!-- <th>Ex.Tax Value</th> -->
                                    <th>Total</th>
                                    <th>Grand Total</th>
                                    <th>Party</th>
                                    <th>Party NTN</th>
                                    <th style="display:none;">Print</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum = 0; ?>
                                <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($sale->invoice_no != '0'): ?>
                                        <?php $sum = $sum + 1; ?>
                                        <tr>
                                            <td style="display:none;">
                                                <input type="checkbox" id="Dltid" name="Dltid[]" value="<?php echo e($sale->id); ?>">
                                            </td>
                                            <td class="center"><?php echo e($sum); ?></td>
                                            <td class="center"><?php echo e(date('d/m/Y', strtotime($sale->date))); ?></td>
                                            <td style="display:none;" class="center"><?php echo e($sale->dcn_no); ?></td>
                                            <td class="center"><?php echo e($sale->invoice_no); ?></td>

                                            <?php $total = 0;
                                            $discount = 0;
                                            $tax = 0;
                                            $extratax = 0;
                                            $grandtotal = 0; ?>
                                            <?php $__currentLoopData = $sale->saletax_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $total = $total + (int) $details->rate * (int) $details->quantity;
                                                //$discount = $discount + (($details->discount/100)*(int)$details->quantity*(int)$details->unit_cost);
                                                $tax = $tax + (int) $details->taxvalue;
                                                $extratax = $extratax + (int) $details->extraTaxValue;
                                                $grandtotal = $grandtotal + (int) $details->total;
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <td class="center"><?php echo e((int) $tax); ?></td>
                                            <!-- <td class="center"><?php echo e((int) $extratax); ?></td> -->
                                            <td class="center"><?php echo e((int) $total); ?></td>
                                            <!-- <td class="center"><?php echo e($discount); ?></td> -->
                                            <td class="center"><?php echo e((int) $grandtotal); ?></td>
                                            <td class="center">
                                                <?php if($sale->parties != null): ?>
                                                    <?php echo e($sale->parties->party_name); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td class="center">
                                                <?php if($sale->parties != null): ?>
                                                    <?php echo e($sale->parties->ntn); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center" style="white-space:nowrap;">
                                                <a style="display:none;"href="<?php echo e(asset('pos-salestax/dcn')); ?>/<?php echo e($sale->id); ?>" target="_blank"
                                                    style="color:white;">
                                                    <button class="btn btn-primary" type="button">DC</button></a>
                                                <a  href="<?php echo e(asset('pos-salestax/print')); ?>/<?php echo e($sale->id); ?>" target="_blank"
                                                    style="color:white;">
                                                    <button class="btn btn-info" type="button"> <i class="icon-print"
                                                            title="Print Invoice"></i></button></a>
                                                <a href="<?php echo e(asset('pos-salestax/' . $sale->id . '/pdf')); ?>" style="color:white;">
                                                    <button class="btn btn-danger" type="button" title="Download PDF">
                                                        <i class="fa fa-file-pdf-o"></i></button></a>
                                                <button class="btn btn-success js-email-invoice" type="button"
                                                    data-url="<?php echo e(asset('pos-salestax/' . $sale->id . '/email')); ?>"
                                                    data-invoice="<?php echo e($sale->invoice_no); ?>"
                                                    title="Email Invoice">
                                                    <i class="fa fa-envelope"></i>
                                                </button>
                                                <?php if($sale->fbr_invoice_no == null): ?>
                                                    <a href="<?php echo e(asset('pos-salestax')); ?>/<?php echo e($sale->id); ?>/destroy">
                                                        <button class="btn btn-red" type="button" onclick="return confirm('Are you sure you want to Delete this Record?')"> <i
                                                                class="icon-trash"
                                                                title="Delete Invoice"></i></button></a>
                                                <?php endif; ?>
                                            </td>
                                            <td class="size-80 text-center" style="display:none;">
                                                <div class="row">
                                                    <a style="display:none;"href="<?php echo e(asset('pos-salestax')); ?>/<?php echo e($sale->id); ?>/edit" target="_blank"
                                                        style="color:white;">
                                                        <button class="btn btn-black" type="button"> <i
                                                                class="fa fa-paste"
                                                                title="Edit Invoice"></i></button></a>
                                                    <?php if($sale->fbr_invoice_no == null): ?>
                                                    <a
                                                        href="<?php echo e(asset('pos-salestax')); ?>/<?php echo e($sale->id); ?>/destroy">
                                                        <button class="btn btn-red" type="button" onclick="return confirm('Are you sure you want to Delete this Record?')"> <i
                                                                class="icon-trash"
                                                                title="Delete Invoice"></i></button></a>
                                                    <?php endif; ?>
                                                </div>
                                                <!-- <div class="dropdown">
         <a class="more-link" data-toggle="dropdown" href="#/"><i class="icon-dot-3 ellipsis-icon"></i></a>
         <ul class="dropdown-menu dropdown-menu-right">
          <li><a href="/sales/<?php echo e($sale->id); ?>" target="__blank">Invoice</a></li>
          <li><a href="/sales/print/<?php echo e($sale->id); ?>" target="__blank">Print Invoice</a></li>
          <li><a href="/sales/<?php echo e($sale->id); ?>/edit">Edit</a></li>
          <li><a href="javascript:checkDelete(<?php echo e($sale->id); ?>, '/sales/<?php echo e($sale->id); ?>/destroy', '/sales');">Delete</a> </li>
         </ul>
        </div> -->
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="display:none;"></th>
                                    <th>Sr#</th>
                                    <th>Date</th>
                                    <th style="display:none;">DC#</th>
                                    <th>Invoice No</th>
                                    <!-- <th>Biller</th> -->
                                    <!-- <th>Sale&nbsp;Type</th> -->
                                    <th>Tax Value</th>
                                    <!-- <th>Ex.Tax&nbsp;Value</th> -->
                                    <th>Total</th>
                                    <!--<th>Product Tax</th>-->
                                    <th>Grand Total</th>
                                    <th>Party</th>
                                    <th>Party NTN</th>
                                    <th style="display:none;">Print</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="/js/jquery.min.js"></script>
    <!--<script src="/js/bootstrap.min.js"></script>
    <script src="/js/plugins/metismenu/jquery.metisMenu.js"></script>
    <script src="/js/plugins/blockui-master/jquery-ui.js"></script>
    <script src="/js/plugins/blockui-master/jquery.blockUI.js"></script>
    <script src="/js/functions.js"></script>
    --->
    <script src="/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/js/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="/js/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
    <script src="/js/plugins/datatables/jszip.min.js"></script>
    <script src="/js/plugins/datatables/pdfmake.min.js"></script>
    <script src="/js/plugins/datatables/vfs_fonts.js"></script>
    <script src="/js/plugins/datatables/extensions/Buttons/js/buttons.html5.js"></script>
    <script src="/js/plugins/datatables/extensions/Buttons/js/buttons.colVis.js"></script>
    <script>
        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                dom: '<"html5buttons" B>lTfgitp',
                columnDefs: [
                    { targets: [0, 3, 11], visible: false, searchable: false }
                ],
                buttons: [{
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    'colvis'
                ]
            });
        });


        function selects(){
     
     var check =  document.getElementsByName('checkall');
     if(check[0].checked==false){
      // alert('in');
      var ele=document.getElementsByName('Dltid[]');
                  // alert(ele);  
                  for(var i=0; i<ele.length; i++){  
                      if(ele[i].type=='checkbox') 
                      // alert(ele[i]);
                          ele[i].checked=false;  
                  }  
     }
    else{
      var ele=document.getElementsByName('Dltid[]');
                  // alert(ele);  
                  for(var i=0; i<ele.length; i++){  
                      if(ele[i].type=='checkbox') 
                      // alert(ele[i]);
                          ele[i].checked=true;  
                  }  
              }
  
    }
    </script>
    <?php echo $__env->make('partials.email-invoice-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Axis-Coding\xampp-8.2.12\htdocs\it_life_work\digital-invoicing\root\resources\views/salestax/pos/index.blade.php ENDPATH**/ ?>