@extends("app")

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <title>Edit Party</title>
</head>
@section('contents')
    <h1 class="page-title">Edit Account</h1>
    <!-- Breadcrumb -->
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
        <li><a href="{{ asset('parties') }}">Chart Of Account</a></li>
        <li class="active"><strong>Edit Account</strong></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Edit Account</h3>
                    <!-- <ul class="panel-tool-options">
             <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
             <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
             <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
            </ul> -->
                </div>
                <div class="panel-body">
                    @include('errors.validation')
                    {!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\PartyController@update', $edit->id], 'class' => 'form-horizontal']) !!}
                    {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Code</label>
                        <div class="col-sm-5">
                            {!! Form::text('code', null, ['id' => 'code', 'class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Account Name <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            {!! Form::text('party_name', null, ['id' => 'party_name', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
                        </div>
                    </div>
                    <div class="form-group" style="width: -webkit-fill-available;">
                        <label class="col-sm-3 control-label">Select&nbsp;Type</label>
                        <div class="col-sm-5">
                            {!! Form::select('account_show_id', $AccountGroups, $edit->id, ['id' => 'account_show_id', 'onchange' => 'AccountName($(this).val().split("_").pop(), $(this).val().split("_")[0]);', 'class' => 'form-control']) !!}
                            <span class="help-block text-danger" style="color: red;">
                            If you want to add Customer choose (DEBTOR)
                            </span>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label class="col-sm-3 control-label">Account ID</label>
                        <div class="col-sm-5">
                            {!! Form::text('account_group_id', null, ['id' => 'account_group_id', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Account Type</label>
                        <div class="col-sm-5">
                            {!! Form::text('account_type', null, ['id' => 'account_type_disabled', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                            {!! Form::hidden('account_type', null, ['id' => 'account_type', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    @if ($edit->account_type == 'EMPLOYEES' || $edit->account_type == 'SATLUJ DAIRY EMPLOYEE')
                        <div class="form-group" id="SalaryDiv">
                            <label class="col-sm-3 control-label">Salary</label>
                            <div class="col-sm-5">
                                {!! Form::text('salary', null, ['id' => 'salary', 'class' => 'form-control', 'placeholder' => 'Only for Employees', 'onkeydown' => 'focusNext(event);']) !!}
                            </div>
                        </div>
                        <div class="form-group" id="EmployeeStatusDiv">
                            <label class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-5">
                                {!! Form::select('employee_status', ['ACTIVE' => 'ACTIVE', 'INACTIVE' => 'INACTIVE'], null, ['id' => 'employee_status', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            </div>
                        </div>
                    @endif
                    @if ($edit->account_type == 'MILK SUPPLIER')
                        <div class="form-group" style=" width: -webkit-fill-available;" id="supplierDiv">
                            <label class="col-sm-3 control-label">Supplier Location</label>
                            <div class="col-sm-5">
                                {!! Form::select('location_id', $Supplier, null, ['id' => 'location_id', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            </div>
                        </div>

                        <div class="form-group" id="RateDiv" style="">
                            <label class="col-sm-3 control-label">Rate</label>
                            <div class="col-sm-5">
                                {!! Form::text('fatrate', null, ['id' => 'fatrate', 'class' => 'form-control', 'placeholder' => 'Suppliers Product Rate', 'onkeydown' => 'focusNext(event);']) !!}
                            </div>
                        </div>
                    @endif

                    <div class="form-group" style="width: -webkit-fill-available;display:none">
                        <label class="col-sm-3 control-label">Shop</label>
                        <div class="col-sm-5">
                            {!! Form::select('shop_id', $shop, null, ['id' => 'shop_id', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    {{-- <div class="form-group" style="display: none">
                        <label class="col-sm-3 control-label">CNIC</label>
                        <div class="col-sm-5">
                            {!! Form::text('cnic', null, ['id' => 'cnic', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Customer Type <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                        {!! Form::select('customer_type', [
                                'Registered' => 'Registered',
                                'Unregistered' => 'Unregistered',
                                'Unregistered Distributor' => 'Unregistered Distributor',
                                'Retail Consumer' => 'Retail Consumer',
                            ], null, [
                                'id' => 'customer_type',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Customer Province <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                        {!! Form::select('province', array(
                            'PUNJAB' => 'PUNJAB', 
                            'SINDH' => 'SINDH', 
                            'BALOCHISTAN' => 'BALOCHISTAN', 
                            'KHYBER PAKHTUNKHWA' => 'KHYBER PAKHTUNKHWA',
                            'AZAD JAMMU AND KASHMIR' => 'AZAD JAMMU AND KASHMIR',
                            'CAPITAL TERRITORY' => 'CAPITAL TERRITORY',
                            'GILGIT BALTISTAN' => 'GILGIT BALTISTAN',
                               ),null, ['id' => 'province', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group" id="banks_name_div" style="display:none;">
                        <label class="col-sm-3 control-label">BANK NAME</label>
                        <div class="col-sm-5">
                            {!! Form::select('bank_id', $banks, null, ['id' => 'bank_id', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group" id="banks_account_no_div" style="display:none;">
                        <label class="col-sm-3 control-label">ACCOUNT#</label>
                        <div class="col-sm-5">
                            {!! Form::text('bank_account_no', null, ['id' => 'bank_account_no', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Phone</label>
                        <div class="col-sm-5">
                            {!! Form::text('phone', null, ['id' => 'phone', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group" id="ntn_div">
                        <label class="col-sm-3 control-label">NTN / CNIC <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            <!-- {!! Form::text('ntn', null, ['id' => 'ntn', 
                                'placeholder' => '_______',
                                'data-slots' => '_',
                                'data-accept' => '\w',
                                'size' => '9',
                                'class' => 'form-control']) !!}
                            <span class="help-block text-danger" style="color: red;">
                            NTN 7 digit format (3345678) & Should be valid NTN
                            </span> -->
                              {!! Form::text('ntn', null, ['id' => 'ntn', 
                        
                                'class' => 'form-control']) !!}
                            <span class="help-block text-danger" style="color: red;">
                            7 digit NTN or 13 digit CNIC without dashes
                            </span>
                        </div>
                    </div>
                     @if($showstrn->strn_show == 1)
                    <div class="form-group">
                        <label class="col-sm-3 control-label">STRN</label>
                        <div class="col-sm-5">
                            {!! Form::text('strn', null, ['id' => 'strn', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);', 'placeholder' => 'Optional']) !!}
                        </div>
                    </div>
                    @endif
                    <div class="form-group" style="display:none;">
                        <label class="col-sm-3 control-label">City</label>
                        <div class="col-sm-5">
                            {!! Form::text('city', null, ['id' => 'city', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Address <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            {!! Form::text('address', null, ['id' => 'address', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div id="salary-form" style="display: none;">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">CNIC</label>
                            <div class="col-sm-5">
                                {!! Form::text('cnic', null, ['id' => 'cnic', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Designation</label>
                            <div class="col-sm-5">
                                {!! Form::select('designation',$designations ,null, ['id' => 'designation', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);','style'=>'width:100%;']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Basic Salary</label>
                            <div class="col-sm-5">
                                {!! Form::text('basic_salary', null, ['id' => 'basic_salary', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Allowance</label>
                            <div class="col-sm-5">
                                {!! Form::text('allowance', null, ['id' => 'allowance', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            </div>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label class="col-sm-3 control-label">Deduction</label>
                            <div class="col-sm-5">
                                {!! Form::text('deduction', null, ['id' => 'deduction', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Net Salary</label>
                            <div class="col-sm-5">
                                {!! Form::text('net_salary', null, ['id' => 'net_salary', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-5">
                                {!! Form::select('status', $status,null, ['id' => 'status', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);','style'=>'width:100%;']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Salary Status</label>
                            <div class="col-sm-5">
                                {!! Form::select('salary_status', $salary_status,null, ['id' => 'salary_status', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);','style'=>'width:100%;']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="line-dashed"></div>
                    <center>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Update Client</button>
                        </div>
                    </center>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css"
        type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <script src="{{ asset('js/plugins/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        $("#account_show_id").select2();
        $("#account_show_id").next(".select2").find(".select2-selection").focus(function() {
            $("#account_show_id").select2("open");
        });

        $("#shop_id").select2();
        $("#shop_id").next(".select2").find(".select2-selection").focus(function() {
            $("#shop_id").select2("open");
        });

        $("#location_id").select2();
        $("#location_id").next(".select2").find(".select2-selection").focus(function() {
            $("#location_id").select2("open");
        });

        
        $("#designation").select2();
        $("#designation").next(".select2").find(".select2-selection").focus(function() {
            $("#designation").select2("open");
        });

        $("#status").select2();
        $("#status").next(".select2").find(".select2-selection").focus(function() {
            $("#status").select2("open");
        });

        $("#salary_status").select2();
        $("#salary_status").next(".select2").find(".select2-selection").focus(function() {
            $("#salary_status").select2("open");
        });


        $('#basic_salary, #allowance').keyup(function(){
            var basic_salary = $('#basic_salary').val();
            var allowance = $('#allowance').val();
            var total = parseInt(basic_salary)+parseInt(allowance);
            $('#net_salary').val(total);
        });

        // $('#basic_salary, #allowance, #deduction').keyup(function(){
        //     if($('#basic_salary').val()!='' && $('#allowance').val()!='' && $('#deduction').val()!='') {
        //         var basic_salary = parseFloat($('#basic_salary').val());
        //         var allowance = parseFloat($('#allowance').val());
        //         var deduction = parseFloat($('#deduction').val());
        //         var sal = basic_salary + allowance;
        //         var tax = (deduction/100)*sal;
        //         var net_salary = sal-tax;
        //         $('#net_salary').val(net_salary);
        //     }else{
        //         alert('Something is empty');
        //     }
        // })

        function AccountName(TypeValue, TypeId) {
            if (TypeValue == "EMPLOYEES" || TypeValue == "SATLUJ DAIRY EMPLOYEE") {
                $('#SalaryDiv').show();
            } else {
                $('#SalaryDiv').hide();
            }
            //  if(TypeValue != "EMPLOYEES"){
            //  			$('#SalaryDiv').hide();
            // }

            if (TypeValue == "MILK SUPPLIER") {
                $('#RateDiv').show();
                $('#supplierDiv').show();
            }
            if (TypeValue != "MILK SUPPLIER") {
                $('#RateDiv').hide();
                $('#supplierDiv').hide();
            }

            if(TypeValue == "SALARY"){
                $('#salary-form').css('display','block');
                $('#banks_name_div').css('display','none');
                $('#banks_account_no_div').css('display','none');
                $('#ntn_div').css('display','none');
                
            }else{
                $('#salary-form').css('display','none');
                $('#banks_name_div').css('display','block');
                $('#banks_account_no_div').css('display','block');
                $('#ntn_div').css('display','block');
            }

            document.getElementById('account_group_id').value = TypeId;
            document.getElementById('account_type_disabled').value = TypeValue;
            document.getElementById('account_type').value = TypeValue;
        }
    </script>
    <script>
    //Paste this code to script without any change
// This code empowers all input tags having a placeholder and data-slots attribute 
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
@stop
