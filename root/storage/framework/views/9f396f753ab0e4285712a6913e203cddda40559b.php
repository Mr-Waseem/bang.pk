<title>Company Settings</title>

<link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet" />
<style type="text/css">
    .cs-page {
        max-width: 980px;
        margin: 0 auto 40px;
    }
    .cs-hero {
        background: linear-gradient(135deg, #0f766e 0%, #134e4a 55%, #1e3a5f 100%);
        border-radius: 16px;
        padding: 28px 32px;
        color: #fff;
        margin-bottom: 22px;
        box-shadow: 0 10px 30px rgba(15, 118, 110, 0.25);
    }
    .cs-hero h1 {
        margin: 0 0 6px;
        font-size: 26px;
        font-weight: 700;
        letter-spacing: 0.2px;
    }
    .cs-hero p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
    }
    .cs-card {
        background: #fff;
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .cs-card-header {
        padding: 16px 22px;
        border-bottom: 1px solid #eef2f7;
        background: #f8fafc;
    }
    .cs-card-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
    }
    .cs-card-header small {
        color: #64748b;
        font-size: 12px;
    }
    .cs-card-body {
        padding: 22px;
    }
    .cs-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 6px;
    }
    .cs-field {
        margin-bottom: 16px;
    }
    .cs-field .form-control {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        min-height: 42px;
        box-shadow: none;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .cs-field .form-control:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
    }
    .cs-field textarea.form-control {
        min-height: 90px;
        resize: vertical;
    }
    .cs-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 8px;
    }
    .cs-btn-save {
        background: #0f766e;
        border-color: #0f766e;
        border-radius: 999px;
        padding: 10px 28px;
        font-weight: 600;
        box-shadow: 0 6px 16px rgba(15, 118, 110, 0.28);
    }
    .cs-btn-save:hover,
    .cs-btn-save:focus {
        background: #0d9488;
        border-color: #0d9488;
    }
    .logo-preview-wrap {
        margin-top: 10px;
        padding: 12px;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        display: inline-block;
    }
    .logo-preview {
        width: 200px;
        height: 120px;
        object-fit: contain;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #fff;
        display: block;
    }
    .logo-help {
        margin-top: 6px;
        color: #64748b;
        font-size: 12px;
    }
    select + .select2-container {
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single {
        border-radius: 10px !important;
        border: 1px solid #e2e8f0 !important;
        height: 42px !important;
        padding-top: 6px;
    }
</style>
<?php $__env->startSection('contents'); ?>
<div class="cs-page">
    <div class="cs-hero">
        <h1>Company Settings</h1>
        <p>Update your company profile details used on invoices and FBR submissions.</p>
    </div>

    <?php if(Session::has('flash_message')): ?>
        <div class="alert alert-success alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?php echo e(Session::get('flash_message')); ?>

        </div>
    <?php endif; ?>

    <?php echo $__env->make('errors.validation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo Form::model($company, [
        'method' => 'PATCH',
        'action' => ['App\Http\Controllers\CompanySettingsController@update', $company->id],
        'class' => 'form-horizontal',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]); ?>


    <?php echo Form::hidden('id', $company->id, ['id' => 'id']); ?>


    <div class="cs-card">
        <div class="cs-card-header">
            <h3>Company Profile</h3>
            <small>Name, contact, tax IDs and province</small>
        </div>
        <div class="cs-card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="cs-field">
                        <label class="cs-label" for="CompanyName">Company Name</label>
                        <?php echo Form::text('CompanyName', null, ['id' => 'CompanyName', 'class' => 'form-control', 'required' => true, 'autofocus' => true, 'placeholder' => 'Enter company name']); ?>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="cs-field">
                        <label class="cs-label" for="phone">Phone</label>
                        <?php echo Form::text('phone', null, ['id' => 'phone', 'class' => 'form-control', 'placeholder' => 'e.g. 03XX-XXXXXXX']); ?>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="cs-field">
                        <label class="cs-label" for="address">Address</label>
                        <?php echo Form::textarea('address', null, ['id' => 'address', 'class' => 'form-control', 'rows' => 3, 'placeholder' => 'Full business address']); ?>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="cs-field">
                        <label class="cs-label" for="ntn">NTN / CNIC</label>
                        <?php echo Form::text('ntn', null, ['id' => 'ntn', 'class' => 'form-control', 'placeholder' => 'NTN or CNIC']); ?>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cs-field">
                        <label class="cs-label" for="strn">STRN</label>
                        <?php echo Form::text('strn', null, ['id' => 'strn', 'class' => 'form-control', 'placeholder' => 'Sales tax registration no.']); ?>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cs-field">
                        <label class="cs-label" for="province">Province</label>
                        <?php echo Form::select('province', [
                            '' => 'Select Province',
                            'PUNJAB' => 'PUNJAB',
                            'SINDH' => 'SINDH',
                            'BALOCHISTAN' => 'BALOCHISTAN',
                            'KHYBER PAKHTUNKHWA' => 'KHYBER PAKHTUNKHWA',
                            'AZAD JAMMU AND KASHMIR' => 'AZAD JAMMU AND KASHMIR',
                            'CAPITAL TERRITORY' => 'CAPITAL TERRITORY',
                            'GILGIT BALTISTAN' => 'GILGIT BALTISTAN',
                        ], null, ['id' => 'province', 'class' => 'form-control']); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cs-card">
        <div class="cs-card-header">
            <h3>Invoice Preferences</h3>
            <small>Layout, logo and display options</small>
        </div>
        <div class="cs-card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="cs-field">
                        <label class="cs-label" for="show_unit">Show Unit on Invoice</label>
                        <?php echo Form::select('show_unit', [1 => 'Yes', 0 => 'No'], null, ['id' => 'show_unit', 'class' => 'form-control']); ?>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="cs-field">
                        <label class="cs-label" for="show_fbr_qty">Show FBR Qty (extra column)</label>
                        <?php echo Form::select('show_fbr_qty', [1 => 'Yes', 0 => 'No'], null, ['id' => 'show_fbr_qty', 'class' => 'form-control']); ?>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="cs-field">
                        <label class="cs-label" for="custom_heading">Custom Heading</label>
                        <?php echo Form::text('custom_heading', null, ['id' => 'custom_heading', 'class' => 'form-control', 'placeholder' => 'Optional invoice heading']); ?>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="cs-field">
                        <label class="cs-label" for="invoice_design">Invoice Design</label>
                        <?php echo Form::select('invoice_design', [0 => 'Standard', 1 => 'Invoice One', 2 => 'Invoice Two', 3 => 'Invoice Three', 4 => 'Invoice Four'], null, ['id' => 'invoice_design', 'class' => 'form-control']); ?>

                        <div class="logo-help">Invoice Three uses Topnotch template. Invoice Four uses A Shoes layout.</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="cs-field">
                        <label class="cs-label" for="company_logo">Company Logo</label>
                        <?php echo Form::file('company_logo', ['id' => 'company_logo', 'class' => 'form-control', 'accept' => 'image/*']); ?>

                        <div class="logo-preview-wrap" id="logo-preview-container">
                            <?php if($company->company_logo): ?>
                                <img id="logo-preview" class="logo-preview" src="<?php echo e(asset(ltrim($company->company_logo, '/'))); ?>" alt="Company Logo">
                            <?php else: ?>
                                <img id="logo-preview" class="logo-preview" src="" alt="Company Logo" style="display: none;">
                            <?php endif; ?>
                            <div class="logo-help" id="logo-file-name">JPG, PNG, WEBP (max 2MB)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cs-actions">
        <button type="submit" class="btn btn-primary cs-btn-save">Save Settings</button>
    </div>

    <?php echo Form::close(); ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/plugins/select2/select2.full.min.js')); ?>"></script>
<script type="text/javascript">
    $('#company_logo').on('change', function(e) {
        var file = e.target.files[0];
        var fileNameEl = document.getElementById('logo-file-name');
        if (file) {
            var reader = new FileReader();
            reader.onload = function(ev) {
                $('#logo-preview').attr('src', ev.target.result).show();
            };
            if (fileNameEl) {
                fileNameEl.textContent = file.name;
            }
            reader.readAsDataURL(file);
        } else if (fileNameEl) {
            fileNameEl.textContent = 'JPG, PNG, WEBP (max 2MB)';
        }
    });

    $("#province").select2();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Axis-Coding\xampp-8.2.12\htdocs\it_life_work\digital-invoicing\root\resources\views/account/company-settings.blade.php ENDPATH**/ ?>