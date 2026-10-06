<title>Add Company</title>

<link rel="stylesheet" href="<?php echo e(URL::asset('css/multi-select/jquery.multiselect.css')); ?>">
<style type="text/css">
        ul,
        li {
            margin: 0;
            /* padding: 0; */
            list-style: inline;
        }

        .label {
            color: #000;
            font-size: 16px;
        }

        .company-form,
        .company-form * {
            box-sizing: border-box;
        }

        .company-form .row {
            min-width: 0;
        }

        .company-form .form-group {
            min-width: 0;
        }

        .company-form .form-control,
        .company-form .select2-container,
        .company-form .ms-options-wrap {
            max-width: 100%;
        }

        select + .select2-container {
            width: 100% !important;
        }

        @media (max-width: 991.98px) {
            .company-form .col-md-6,
            .company-form .col-md-4,
            .company-form .col-md-8,
            .company-form .col-md-12 {
                flex: 0 0 100%;
                max-width: 100%;
                width: 100%;
            }

            .company-form > .row {
                margin-left: 0;
                margin-right: 0;
            }

            .company-form .form-group.row {
                flex-direction: column;
                margin-bottom: 0.75rem;
            }

            .company-form .col-form-label {
                text-align: left;
                padding-top: 0;
                margin-bottom: 0.35rem;
            }

            .company-form .form-control,
            .company-form input[size] {
                width: 100% !important;
                max-width: 100%;
            }

            .company-form .select2-container,
            .company-form .ms-options-wrap,
            .company-form .ms-options-wrap > button {
                width: 100% !important;
            }

            .panel-body {
                padding: 15px 12px;
                overflow-x: hidden;
            }
        }
    </style>
<?php $__env->startSection('contents'); ?>
    <div class="container-fluid">
        <?php if(Session::has('flash_message')): ?>
            <div class="alert alert-success alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
                <strong>Success!</strong> <?php echo e(Session::get('flash_message')); ?>

            </div>
        <?php endif; ?>
    </div>
    <!-- <h1 class="page-title">Add Company</h1> -->
    <!-- Breadcrumb -->
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="<?php echo e(asset('dashboard')); ?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active"><strong>Add Company</strong></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Add Company</h3>
                    <!-- <ul class="panel-tool-options">
                <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
               </ul> -->
                </div>
                <div class="panel-body">
                    <?php echo $__env->make('errors.validation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo Form::open([
                        'url' => 'company',
                        'class' => 'form-horizontal',
                        'files' => 'true',
                        'enctype' => 'multipart/form-data',
                    ]); ?>

                    <?php echo Form::hidden('status', 'company', ['id' => 'status']); ?>

                    <?php echo $__env->make('companies._form', ['submitbutton' => 'save'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(URL::asset('css/multi-select/jquery.multiselect.js')); ?>"></script>
    <script src="<?php echo e(asset('js/plugins/select2/select2.full.min.js')); ?>"></script>
    <script type="text/javascript">
        $("#sale_type").select2();
        $("#sale_type").next(".select2").find(".select2-selection").focus(function() {
        $("#sale_type").select2("open");
        });
   
        $("#partner_id").select2();
        $("#partner_id").next(".select2").find(".select2-selection").focus(function() {
        $("#partner_id").select2("open");
        });
        $("#province").select2();
        $("#province").next(".select2").find(".select2-selection").focus(function() {
        $("#province").select2("open");
        });
        $("#category").select2();
        $("#category").next(".select2").find(".select2-selection").focus(function() {
        $("#category").select2("open");
        });
        $("#system_type").select2();
        $("#system_type").next(".select2").find(".select2-selection").focus(function() {
        $("#system_type").select2("open");
        });
        $("#Businesstype").select2();
        $("#Businesstype").next(".select2").find(".select2-selection").focus(function() {
        $("#Businesstype").select2("open");
        });
        
        $("#invoice_type").select2();
        $("#invoice_type").next(".select2").find(".select2-selection").focus(function() {
        $("#invoice_type").select2("open");
        });
        $("#type").select2();
        $("#type").next(".select2").find(".select2-selection").focus(function() {
        $("#type").select2("open");
        });
        $("#payment_terms").select2();
        $("#payment_terms").next(".select2").find(".select2-selection").focus(function() {
        $("#payment_terms").select2("open");
        });
        
        $("#scenario").select2();
        $("#scenario").next(".select2").find(".select2-selection").focus(function() {
        $("#scenario").select2("open");
        });

        $('#langOpt3').multiselect({
            columns: 1,
            placeholder: 'Select Scenarios',
            search: true,
            selectAll: true
        });

        document.addEventListener('DOMContentLoaded', () => {
for (const el of document.querySelectorAll("[placeholder][data-slots]")) {
    const pattern = el.getAttribute("placeholder"),
        slots = new Set(el.dataset.slots || "_"),
        prev = (j => Array.from(pattern, (c,i) => slots.has(c)? j=i+1: j))(0),
        first = [...pattern].findIndex(c => slots.has(c)),
        accept = new RegExp(el.dataset.accept || "\\d", "g"),
        clean = input => {
            input = input.match(accept) || [];
            return Array.from(pattern, c =>
                input[0] === c || slots.has(c) ? input.shift() || c : c
            );
        },
        format = () => {
            const [i, j] = [el.selectionStart, el.selectionEnd].map(i => {
                i = clean(el.value.slice(0, i)).findIndex(c => slots.has(c));
                return i<0? prev[prev.length-1]: back? prev[i-1] || first: i;
            });
            el.value = clean(el.value).join``;
            el.setSelectionRange(i, j);
            back = false;
        };
    let back = false;
    el.addEventListener("keydown", (e) => back = e.key === "Backspace");
    el.addEventListener("input", format);
    el.addEventListener("focus", format);
    el.addEventListener("blur", () => el.value === pattern && (el.value=""));
}
});
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Axis-Coding\xampp-8.2.12\htdocs\it_life_work\digital-invoicing\root\resources\views/companies/create.blade.php ENDPATH**/ ?>