<?php echo Form::hidden('biller_id', Auth::User()->id, ['id' => 'biller_id', 'class' => 'form-control']); ?>

<div class="company-form">
<!-- Company Information Section -->
<div class="row">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('name', 'Company Name', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <small class="text-danger d-block mb-1">SRB: use exact registered business name (no special characters)</small>
                <?php echo Form::text('CompanyName', null, ['id' => 'CompanyName', 'class' => 'form-control', 'autofocus' => 'autofocus']); ?>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('phone', 'Phone', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::text('phone', null, ['id' => 'phone', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('Category', 'Category', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('category', [
                'Other' => 'Other',
                'Importer' => 'Importer',
                'Exporter' => 'Exporter',
                'Manufacturer' => 'Manufacturer',
                'Distributor' => 'Distributor',
                'Wholesaler' => 'Wholesaler',
                'Journal order supplier' => 'Journal order supplier',
                'Retailer' => 'Retailer',
                ], null, ['id' => 'category', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('System Type', 'System Type', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('system_type', [
                'DI' => 'DIGITAL INVOICE',
                'POS' => 'POS',
                'PRA' => 'PRA',
                'KPRA' => 'KPRA (RIMS)',
                'SRB' => 'SRB (Cloud POS)'
                ], old('system_type', 'DI'), ['id' => 'system_type', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>

<!-- Address Section -->
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('address', 'Address', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::text('address', null, ['id' => 'address', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('Province', 'Province', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('province', [
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

<!-- Business Type Section -->


<!-- Tax Information Section -->
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('Ntn', 'NTN - CNIC', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <small class="text-danger d-block mb-1">NTN for PTV LTD & AOP(9937038) - CNIC for Individual (3520133847501)</small>
                <?php echo Form::text('ntn', null, ['id' => 'ntn', 'class' => 'form-control', 'placeholder' => 'NTN 7 Digits or CNIC 13 Digits without dashes']); ?>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('POSID', 'POS ID', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <small class="text-danger d-block mb-1">In case of POS / PRA / KPRA / SRB</small>
                <?php echo Form::text('pos_id', null, ['id' => 'pos_id', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>


</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('sandbox_token', 'SandBox Token / SRB Password', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <small class="text-danger d-block mb-1">FBR: SandBox Token. SRB: POS password from SRB</small>
                <?php echo Form::text('sandbox_token', null, ['id' => 'sandbox_token', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('token', 'Live TOKEN / KPRA Key / SRB User', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <small class="text-danger d-block mb-1">FBR/PRA: Live TOKEN. KPRA: API key. SRB: POS username</small>
                <?php echo Form::text('token', null, ['id' => 'token', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('invoice_type', 'Invoice Type', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <small class="text-danger d-block mb-1">SRB: SandBox = Test mode, Live = Live mode</small>
                <?php echo Form::select('invoice_type', [
                'SandBox' => 'SandBox',
                'Live' => 'Live'
                ], null, ['id' => 'invoice_type', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>


    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('sale_type', 'Partner', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('partner_id', $partners, null, ['id' => 'partner_id', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('name', 'Name', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::text('name', null, ['id' => 'name', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('email', 'Email', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::text('email', null, ['id' => 'email', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('password', 'Password', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <input type="password" id="password" class="form-control" name="password">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('type', 'Business Type', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('Businesstype', [
                'Invoice Only' => 'Invoice Only',
                'Inventory' => 'Inventory',
                'Trader' => 'Trader',
                'Manufacturer' => 'Manufacturer'
                ], null, ['id' => 'Businesstype', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('Scenario', 'Scenario', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <!-- <?php echo Form::select('scenario', $Scenario, null, ['id' => 'scenario', 'class' => 'form-control']); ?> -->
                <?php echo Form::select('scenario[]', $Scenario, null, [
                'id' => 'langOpt3',
                'class' => 'form-control',
                'multiple' => 'multiple',
                'style' => 'width: auto; display: inline-block;'
                ]); ?>


            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('name', 'Number of Invoices', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::text('number_of_invoices', 100000, ['id' => 'number_of_invoices', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>


<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('Strn', 'SalesTax With held At Source', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('st_held', [0 => 'No', 1 => 'Yes'], null, ['id' => 'st_held', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('strn_show', 'FED Payable', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('fed_payable', [0 => 'No', 1 => 'Yes'], null, ['id' => 'fed_payable', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('discount', 'Discount %', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('discount', ['0' => 'No', '1' => 'Yes'], null, ['id' => 'discount', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('Discount 2', 'Discount 2 %', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('discount2', ['0' => 'No', '1' => 'Yes'], null, ['id' => 'discount2', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('discount', 'Discount Fixed', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('discount_fixed', ['0' => 'No', '1' => 'Yes'], null, ['id' => 'discount_fixed', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('Discount 2', 'Discount Fixed 2', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('discount_fixed2', ['0' => 'No', '1' => 'Yes'], null, ['id' => 'discount_fixed2', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>

     <div class="row mt-3">
        <div class="col-md-6">
            <div class="form-group row">
                <?php echo Form::label('prefix', 'Invoice No Prefix', ['class' => 'col-md-4 col-form-label']); ?>

                <div class="col-md-8">
                    <?php echo Form::text('invoiceno_prefix', null, ['id' => 'invoiceno_prefix', 'class' => 'form-control']); ?>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <?php echo Form::label('qrcode', 'Invoice Qr Code', ['class' => 'col-md-4 col-form-label']); ?>

                <div class="col-md-8">
                    <?php echo Form::select('invoice_qrcode', ['1' => 'Top', '0' => 'Bottom'], null, ['id' => 'invoice_qrcode', 'class' => 'form-control']); ?>

                </div>
            </div>
        </div>
    </div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('invoice_serial', 'Invoice Serial#', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::text('invoice_serial', 1, ['id' => 'invoice_serial', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('Approval', 'Approval', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('approval', ['0' => 'No', '1' => 'Yes'], null, ['id' => 'approval', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>


<hr class="my-4">
<!-- Payment Information Section -->
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('Contact_Person', 'Contact Person', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::text('contact_person', null, ['id' => 'contact_person', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('Contact_Phone', 'Contact Person Phone', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <!-- <?php echo Form::text('contact_person_phone', null, ['id' => 'contact_person_phone', 'class' => 'form-control']); ?> -->
                <?php echo Form::text('contact_person_phone', null, ['id' => 'contact_person_phone', 'class' => 'form-control',
                                'placeholder' => '+92__________',
                                'data-slots' => '_',
                                'data-accept' => '\w',
                                'size' => '9',
                                'onkeydown' => 'focusNext(event);']); ?>

            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('Contact_Person_email', 'Contact Person Email', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::email('contact_person_email', null, ['id' => 'contact_person_email', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('Contact_Phone_add', 'Contact Person Address', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::text('contact_person_address', null, ['id' => 'contact_person_address', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('client_payment', 'Client Payment', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::text('client_payment', null, ['id' => 'client_payment', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('payment_terms', 'Payment Terms', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('payment_terms', [
                'Monthly' => 'Monthly',
                'Annual' => 'Annual'
                ], null, ['id' => 'payment_terms', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>

<div class="row mt-3" style="display: none;">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('ntn_show', 'Show Customer NTN', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('ntn_show', [1 => 'Yes', 0 => 'No'], null, ['id' => 'ntn_show', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('type', 'Account Status', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('type', [
                'ACTIVE' => 'ACTIVE',
                'INACTIVE' => 'INACTIVE'
                ], null, ['id' => 'type', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>





<!-- User Information Section -->

<div class="row mt-3">


    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('bill_type', 'Bill Type', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('bill_type', [
                'A4' => 'A4',
                'Thermal' => 'Thermal',
                'Thermal2' => 'Thermal2'
                ], null, ['id' => 'bill_type', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('is_active', 'Company Status', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('is_active', [
                '1' => 'Active',
                '0' => 'Deactive'
                ], 1, ['id' => 'is_active', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>


<div class="row mt-3" style="display: none;">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('start_date', 'Start Date', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::date('start_date', date('Y-m-d'), ['id' => 'start_date', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('expire_date', 'Expiry Date', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::date('expire_date', date('Y-m-d', strtotime("+1 year")), ['id' => 'expire_date', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('Strn', 'STRN', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::text('strn', null, ['id' => 'strn', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <?php echo Form::label('strn_show', 'Show Customer STRN', ['class' => 'col-md-4 col-form-label']); ?>

            <div class="col-md-8">
                <?php echo Form::select('strn_show', [1 => 'Yes', 0 => 'No'], null, ['id' => 'strn_show', 'class' => 'form-control']); ?>

            </div>
        </div>
    </div>
</div>




<!-- Submit Button -->
<div class="row mt-4">
    <div class="col-md-12 text-center">
        <?php echo Form::submit($submitbutton, ['class' => 'btn btn-primary px-4']); ?>

    </div>
</div>
</div>

<script src="<?php echo e(URL::asset('css/multi-select/jquery.multiselect.js')); ?>"></script>
<script src="<?php echo e(asset('js/plugins/select2/select2.full.min.js')); ?>"></script>
<script type="text/javascript">


</script>
<?php /**PATH D:\Axis-Coding\xampp-8.2.12\htdocs\it_life_work\digital-invoicing\root\resources\views/companies/_form.blade.php ENDPATH**/ ?>