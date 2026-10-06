<title>Companies Management</title>

<?php $__env->startSection('head'); ?>
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #28a745;
        }
        
        .page-heading {
            background: #3e6790;
    /* padding: 20px; */
    margin: -10px -0px 10px 0px;
    border-bottom: 1px solid #eee;
        }
        
        .panel {
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .panel-heading {
            background: var(--secondary-color);
            color: white;
            border-radius: 0;
            padding: 15px 20px;
        }
        
        .panel-title {
            font-weight: 600;
        }
        
        .btn-add {
            background: var(--primary-color);
            border: none;
            float: right;
            margin-top: -5px;
        }
        
        .btn-add:hover {
            background: #2980b9;
        }
        
        .dataTables_filter input {
            border: 1px solid #ddd !important;
            border-radius: 4px !important;
            padding: 5px 10px !important;
        }
        
        .table th {
            background: #f8f9fa;
            font-weight: 600;
        }

        .table thead tr th{
            font-size: 12px;
        }

          .table tbody tr td{
            font-size: 14px;
            padding: 4px !important;
        }
        
        .alert {
            border-radius: 4px;
        }
        
        .btn-action {
            padding: 5px 10px;
            margin-right: 5px;
        }
        
        .dt-buttons .btn {
            margin-right: 5px;
            background: var(--primary-color);
            border: none;
            color: white;
        }
        
        .dt-buttons .btn:hover {
            background: #2980b9;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contents'); ?>
<div class="container-fluid">
    <?php if(Session::has('flash_message')): ?>
        <div class="alert alert-success alert-dismissible show" role="alert" style="position: relative;">
            <?php echo e(Session::get('flash_message')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); padding: 0.5rem; line-height: 1; background: transparent; border: 0; font-size: 1.5rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
</div>
    <div class="container-fluid">
        
        <div class="page-header-container" style="display: flex; justify-content: space-between; align-items: center; background: #3498db; padding: 15px 20px; margin: 0 0px 20px 0px; border-bottom: 1px solid #e0e0e0;">
    <!-- Left Side - Title -->
    <div class="title-container" style="display: flex; align-items: center;">
        <i class="fas fa-building" style="font-size: 1.5rem; color:rgb(0, 27, 45); margin-right: 12px;"></i>
        <h1 class="page-title" style="margin: 0; font-size: 1.5rem; font-weight: 600;">Companies Management</h1>
    </div>
    
    <!-- Right Side - Button -->
    <?php if($loginuser->status == "Admin"): ?>
    <a href="<?php echo e(asset('company/create')); ?>" class="btn btn-primary" style="display: inline-flex; align-items: center; padding: 8px 15px; border-radius: 4px;">
        <i class="fas fa-plus" style="margin-right: 8px;"></i>
        Add Company
    </a>
    <?php endif; ?>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <!-- Panel Header with Title and Controls -->
            <div class="panel-heading clearfix">
                <h3 class="panel-title float-start">
                    <i class="fas fa-list me-2"></i>Companies List
                </h3>
                <!-- <ul class="panel-tool-options list-unstyled float-end mb-0">
                    <li>
                        <a data-rel="collapse" href="#" class="text-white" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </a>
                    </li>
                    <li>
                        <a data-rel="reload" href="#" class="text-white" title="Refresh">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </li>
                </ul> -->
            </div>
            
            <!-- Panel Body with Table -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="companiesTable" style="width:100%">
                        <!-- Table Header -->
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th style="width: 340px !important;">Company&nbsp;Name</th>
                                <th>Expiry Date</th>
                                <th>Start Date</th>
                                <th>User</th>
                                <?php if($loginuser->status == "Admin"): ?>
                                <th>Password</th>
                                <?php endif; ?>
                                <th>Type</th>
                                <th>Status</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        
                        <!-- Table Body -->
                        <tbody>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td style="width: 340px !important;"><?php echo e($value->CompanyName); ?></td>
                                    <td><?php echo e(date("d/m/Y", strtotime($value->expire_date))); ?></td>
                                    <!-- <td><?php echo e(date("d/m/Y", strtotime($value->start_date))); ?></td> -->
                                    <td><?php echo e(date("d/m/Y", strtotime($value->created_at))); ?></td>
                                    <td><?php echo e($value->user[0]->email ?? 'N/A'); ?></td>
                                    <?php if($loginuser->status == "Admin"): ?>
                                    <td>
                                        <span class="text-muted"><?php echo e($value->user[0]->show_password ?? 'N/A'); ?></span>
                                    </td>
                                    <?php endif; ?>
                                    <td>
                                        <span class="badge bg-<?php echo e($value->type == 'Premium' ? 'success' : 'info'); ?>">
                                            <?php echo e($value->type); ?> - <?php echo e($value->invoice_type); ?> - <?php echo e($value->system_type); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <?php if((int)($value->is_active ?? 1) === 1): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Deactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Company Actions" style="width: 120px;">
                                            <!-- Edit Button -->
                                            
                                            <?php if($loginuser->status == "Admin"): ?>
                                            <a href="<?php echo e(asset('company/' . $value->id . '/edit')); ?>" 
                                               class="btn btn-info btn-action" 
                                               title="Edit"
                                               data-bs-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php endif; ?>
                                            
                                            <!-- <?php if($loginuser->status == "Admin"): ?>
                                           
                                            <a href="company/<?php echo e($value->id); ?>/destroy"
                                               class="btn btn-danger btn-action" 
                                               title="Delete"
                                               data-bs-toggle="tooltip"
                                               onclick="return confirm('Are you sure you want to delete this company?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            <?php endif; ?> -->
                                            <!-- Assign Button -->
                                            <a href="<?php echo e(asset('company/assign/' . $value->id)); ?>" 
                                               class="btn btn-primary btn-action" 
                                               title="Assign User"
                                               data-bs-toggle="tooltip">
                                                <i class="fas fa-sign-in-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#companiesTable').DataTable({
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
                     "<'row'<'col-sm-12'B>>",
                buttons: [
                    // {
                    //     extend: 'copy',
                    //     className: 'btn btn-sm btn-secondary',
                    //     text: '<i class="fas fa-copy"></i> Copy'
                    // },
                    {
                        extend: 'excel',
                        className: 'btn btn-sm btn-success',
                        text: '<i class="fas fa-file-excel"></i> Excel'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-sm btn-danger',
                        text: '<i class="fas fa-file-pdf"></i> PDF'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm btn-info',
                        text: '<i class="fas fa-print"></i> Print'
                    },
                    // {
                    //     extend: 'colvis',
                    //     className: 'btn btn-sm btn-primary',
                    //     text: '<i class="fas fa-columns"></i> Columns'
                    // }
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search companies...",
                    lengthMenu: "Show _MENU_ entries per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                },
                columnDefs: [
                    { orderable: false, targets: [7] } // Disable sorting for actions column
                ]
            });
            
            // Fix search input styling
            $('.dataTables_filter input').addClass('form-control form-control-sm');
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Axis-Coding\xampp-8.2.12\htdocs\it_life_work\digital-invoicing\root\resources\views/companies/index.blade.php ENDPATH**/ ?>