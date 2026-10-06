
{!! Form::hidden('biller_id', Auth::User()->id, ['id' => 'biller_id', 'class' => 'form-control']) !!}
<!-- Company Information Section -->
<div class="row">
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('name', 'Company Name', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('CompanyName', null, ['id' => 'CompanyName', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('phone', 'Phone', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('phone', null, ['id' => 'phone', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
        {!! Form::label('Category', 'Category', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('category', [
                    'PVT LTD' => 'PVT LTD', 
                    'AOP' => 'AOP',
                    'INDIVIDUAL' => 'INDIVIDUAL'
                ], null, ['id' => 'category', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('System Type', 'System Type', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('system_type', [
                    'DI' => 'DIGITAL INVOICE', 
                    'POS' => 'POS'
                ], null, ['id' => 'system_type', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>

<!-- Address Section -->
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('address', 'Address', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('address', null, ['id' => 'address', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('Province', 'Province', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('province', [
                    'Punjab' => 'Punjab', 
                    'Sindh' => 'Sindh', 
                    'Balochistan' => 'Balochistan', 
                    'Khyber Pakhtunkhwa' => 'Khyber Pakhtunkhwa'
                ], null, ['id' => 'province', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>

<!-- Business Type Section -->


<!-- Tax Information Section -->
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('Ntn', 'NTN - CNIC', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
            <small class="text-danger d-block mb-1">NTN for PTV LTD & AOP(9937038) - CNIC for Individual (3520133847501)</small>
                {!! Form::text('ntn', null, ['id' => 'ntn', 'class' => 'form-control', 'placeholder' => 'NTN 7 Digits or CNIC 13 Digits without dashes']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('POSID', 'POS ID', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
            <small class="text-danger d-block mb-1">In case of POS</small>
                {!! Form::text('pos_id', null, ['id' => 'pos_id', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    
    
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('sandbox_token', 'SandBox Token', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                <small class="text-danger d-block mb-1">Please Enter the exact SandBox Token</small>
                {!! Form::text('sandbox_token', null, ['id' => 'sandbox_token', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('token', 'Live TOKEN', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                <small class="text-danger d-block mb-1">Please Enter the exact TOKEN to avoid Errors</small>
                {!! Form::text('token', null, ['id' => 'token', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('invoice_type', 'Invoice Type', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('invoice_type', [
                    'SandBox' => 'SandBox', 
                    'Live' => 'Live'
                ], null, ['id' => 'invoice_type', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    
    
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('sale_type', 'Partner', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('partner_id', $partners, null, ['id' => 'partner_id', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('name', 'Name', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('email', 'Email', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('email', null, ['id' => 'email', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('password', 'Password', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                <input type="password" id="password" class="form-control" name="password">
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('type', 'Business Type', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('Businesstype', [
                    'Invoice Only' => 'Invoice Only', 
                    'Inventory' => 'Inventory', 
                    'Trader' => 'Trader', 
                    'Manufacturer' => 'Manufacturer'
                ], null, ['id' => 'Businesstype', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('Scenario', 'Scenario', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                <!-- {!! Form::select('scenario', $Scenario, null, ['id' => 'scenario', 'class' => 'form-control']) !!} -->
                {!! Form::select('scenario[]', $Scenario, null, [
                    'id' => 'langOpt3',
                    'class' => 'form-control',
                    'multiple' => 'multiple',
                    'style' => 'width: auto; display: inline-block;'
                ]) !!}
               
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('name', 'Number of Invoices', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('number_of_invoices', 100000, ['id' => 'number_of_invoices', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>


<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('Strn', 'SalesTax With held At Source', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
            {!! Form::select('st_held', [0 => 'No', 1 => 'Yes'], null, ['id' => 'st_held', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('strn_show', 'FED Payable', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('fed_payable', [0 => 'No', 1 => 'Yes'], null, ['id' => 'fed_payable', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
<div class="col-md-6">
    <div class="form-group row">
        {!! Form::label('discount', 'Discount', ['class' => 'col-md-4 col-form-label']) !!}
        <div class="col-md-8">
            {!! Form::select('discount', ['0' => 'No', '1' => 'Yes'], null, ['id' => 'discount', 'class' => 'form-control']) !!}
        </div>
    </div>
</div>
</div>


<hr class="my-4">
 <!-- Payment Information Section -->
 <div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('client_payment', 'Client Payment', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('client_payment', null, ['id' => 'client_payment', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('payment_terms', 'Payment Terms', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('payment_terms', [
                    'Monthly' => 'Monthly', 
                    'Annual' => 'Annual'
                ], null, ['id' => 'payment_terms', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
<div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('ntn_show', 'Show Customer NTN', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('ntn_show', [1 => 'Yes', 0 => 'No'], null, ['id' => 'ntn_show', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('type', 'Account Status', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('type', [
                    'ACTIVE' => 'ACTIVE', 
                    'INACTIVE' => 'INACTIVE'
                ], null, ['id' => 'type', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>





<!-- User Information Section -->

<div class="row mt-3">
 
    
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('bill_type', 'Bill Type', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('bill_type', [
                    'A4' => 'A4',
                    'Thermal' => 'Thermal',
                    'Thermal2' => 'Thermal2'
                ], null, ['id' => 'bill_type', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>


<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('start_date', 'Start Date', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::date('start_date', date('Y-m-d'), ['id' => 'start_date', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('expire_date', 'Expiry Date', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::date('expire_date', date('Y-m-d', strtotime("+1 year")), ['id' => 'expire_date', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('Strn', 'STRN', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('strn', null, ['id' => 'strn', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('strn_show', 'Show Customer STRN', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('strn_show', [1 => 'Yes', 0 => 'No'], null, ['id' => 'strn_show', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>




<!-- Submit Button -->
<div class="row mt-4">
    <div class="col-md-12 text-center">
        {!! Form::submit($submitbutton, ['class' => 'btn btn-primary px-4']) !!}
    </div>
</div>

<script src="{{ URL::asset('css/multi-select/jquery.multiselect.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">

       
    </script>