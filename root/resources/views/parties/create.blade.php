@extends("app")

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <title>Add New Party</title>
</head>
@section('contents')

    <h1 class="page-title">Add New Account</h1>
    <!-- Breadcrumb -->
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
        <li><a href="{{ asset('parties') }}">Char Of Account</a></li>
        <li class="active"><strong>Add Account</strong></li>
    </ol>
    <div class="container-fluid">
        @if (Session::has('flash_message'))
            <div class="alert alert-success alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"
                    style="margin-right: 4%;">&times;</a>
                <strong>Success!</strong> {{ Session::get('flash_message') }}
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Add Account</h3>
                </div>
                <div class="panel-body">
                    @include('errors.validation')
                    {!! Form::open(['url' => 'parties', 'class' => 'form-horizontal', 'id' => 'PartyForm']) !!}
                    {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Code</label>
                        <div class="col-sm-5">
                            {!! Form::text('code1', $codes, ['id' => 'code1', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                            {!! Form::hidden('code', $codes, ['id' => 'code', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Account Name <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            {!! Form::text('party_name', null, ['id' => 'party_name', 'class' => 'form-control', 'autofocus' => 'autofocus', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group" style="width: -webkit-fill-available;">
                        <label class="col-sm-3 control-label">Account&nbsp;Type <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            {!! Form::select('account_show_id', $AccountGroups, old('account_show_id', $defaultAccountShowId ?? null), ['id' => 'account_show_id', 'onchange' => 'AccountName($(this).val().split("_").pop(), $(this).val().split("_")[0]);', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            <span class="help-block text-danger" style="color: red;">
                            If you want to add Customer choose (DEBTOR)
                            </span>
                        </div>
                       
                    </div>
                    <div class="form-group" id="SalaryDiv" style="display: none;">
                        <label class="col-sm-3 control-label">Salary</label>
                        <div class="col-sm-5">
                            {!! Form::text('salary', 0, ['id' => 'salary', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);', 'onfocus' => 'this.value=""']) !!}
                        </div>
                    </div>
                    <div class="form-group" id="EmployeeStatusDiv" style="display: none;">
                        <label class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-5">
                            {!! Form::select('employee_status', ['ACTIVE' => 'ACTIVE', 'INACTIVE' => 'INACTIVE'], null, ['id' => 'employee_status', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>


                    <div class="form-group" id="RateDiv" style="display: none;">
                        <label class="col-sm-3 control-label">Rate</label>
                        <div class="col-sm-5">
                            {!! Form::text('fatrate', 0, ['id' => 'fatrate', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);', 'placeholder' => 'Suppliers Product Rate', 'onfocus' => 'this.value=""']) !!}
                        </div>
                    </div>



                    <div class="form-group" style="width: -webkit-fill-available;display:none;">
                        <label class="col-sm-3 control-label">Shop</label>
                        <div class="col-sm-5">
                            {!! Form::select('shop_id', $shop, null, ['id' => 'shop_id', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    {!! Form::hidden('account_group_id', old('account_group_id', $defaultAccountGroupId ?? null), ['id' => 'account_group_id', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}

                    {!! Form::hidden('account_type', old('account_type', $defaultAccountType ?? null), ['id' => 'account_type', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}

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
                    <div class="form-group" id="banks_name_div" style="display: none;">
                        <label class="col-sm-3 control-label">BANK NAME</label>
                        <div class="col-sm-5">
                            {!! Form::select('bank_id', $banks, null, ['id' => 'bank_id', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group" id="banks_account_no_div" style="display: none;">
                        <label class="col-sm-3 control-label" id="bank_account_no_label">ACCOUNT#</label>
                        <div class="col-sm-5">
                            {!! Form::text('bank_account_no', null, ['id' => 'bank_account_no', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Phone</label>
                        <div class="col-sm-5">
                            {!! Form::text('phone', null, ['id' => 'phone', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);', 'placeholder' => 'Optional']) !!}
                        </div>
                    </div>

                    <div class="form-group" id="ntn_div">
                        <label class="col-sm-3 control-label">NTN / CNIC<span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            <!-- {!! Form::text('ntn', null, ['id' => 'ntn', 'class' => 'form-control',
                                'placeholder' => '_______',
                                'data-slots' => '_',
                                'data-accept' => '\w',
                                'size' => '9',
                                'onkeydown' => 'focusNext(event);']) !!}
                            <span class="help-block text-danger" style="color: red;">
                            NTN 7 digit format (3345678) & Should be valid NTN
                            </span> -->
                             {!! Form::text('ntn', null, ['id' => 'ntn', 'class' => 'form-control',
                
                                'onkeydown' => 'focusNext(event);']) !!}
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
                            {!! Form::text('city', null, ['id' => 'city', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Address <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            {!! Form::text('address', null, ['id' => 'address', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
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
                                {!! Form::text('basic_salary', 0, ['id' => 'basic_salary', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Allowance</label>
                            <div class="col-sm-5">
                                {!! Form::text('allowance', 0, ['id' => 'allowance', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            </div>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label class="col-sm-3 control-label">Deduction</label>
                            <div class="col-sm-5">
                                {!! Form::text('deduction', 0, ['id' => 'deduction', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Net Salary</label>
                            <div class="col-sm-5">
                                {!! Form::text('net_salary', 0, ['id' => 'net_salary', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
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

                    <!-- <div class="form-group"> 
                  <label class="col-sm-3 control-label">MILK SUPPLIER</label>  
                  <div class="col-sm-5"> 
                  <input type="checkbox" id="milk_supplier" name="milk_supplier" value="1">
                  </div> 
                 </div> -->




                    <div class="line-dashed"></div>
                    <center>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save
                                Account</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
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

        $("#customer_type").select2();
        $("#customer_type").next(".select2").find(".select2-selection").focus(function() {
            $("#customer_type").select2("open");
        });

        $("#province").select2();
        $("#province").next(".select2").find(".select2-selection").focus(function() {
            $("#province").select2("open");
        });

        
        $("#bank_id").select2();
        $("#bank_id").next(".select2").find(".select2-selection").focus(function() {
            $("#bank_id").select2("open");
        });

        $("#milk_supplier").select2();
        $("#milk_supplier").next(".select2").find(".select2-selection").focus(function() {
            $("#milk_supplier").select2("open");
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

        $('#party_name').on('keydown', function(e) {
            if (e.keyCode === 13) {
                $("#account_show_id").select2();
                $("#account_show_id").next(".select2").find(".select2-selection").focus(function() {
                    $("#account_show_id").select2("open");
                });
            }
        });

        $('#basic_salary, #allowance').keyup(function(){
            var basic_salary = $('#basic_salary').val();
            var allowance = $('#allowance').val();
            var total = parseInt(basic_salary)+parseInt(allowance);
            $('#net_salary').val(total);
        });





        $('.account_show_id').select2();


        function LedgerValues() {
            $value = $("#sale_type").val();
            if ($value == "Cash Sale") {
                $('#ledgerRow').hide();
            }
            if ($value == "Credit Sale") {
                $('#ledgerRow').show();
            }
        }

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
            //alert(TypeValue)
            
            // if (TypeValue == "EMPLOYEES" || TypeValue == "SATLUJ DAIRY EMPLOYEE") {
            //     $('#SalaryDiv').show();
            //     $('#EmployeeStatusDiv').show();
            // } else {
            //     $('#SalaryDiv').hide();
            //     $('#EmployeeStatusDiv').hide();
            // }
            // if(TypeValue == "SALARY"){
            //     $('#salary-form').css('display','block');
            //     $('#banks_name_div').css('display','none');
            //     $('#banks_account_no_div').css('display','none');
            //     $('#ntn_div').css('display','none');
                
            // }else{
            //     $('#salary-form').css('display','none');
            //     $('#banks_name_div').css('display','block');
            //     $('#banks_account_no_div').css('display','block');
            //     $('#ntn_div').css('display','block');
            // }
            //  if(TypeValue != "EMPLOYEES"){
            //  			$('#SalaryDiv').hide();
            //  			$('#EmployeeStatusDiv').hide();
            // }

            // if(TypeValue == "SATLUJ DAIRY EMPLOYEE"){
            // 		$('#SalaryDiv').show();
            // 		$('#EmployeeStatusDiv').show();
            // 	}
            //  if(TypeValue != "SATLUJ DAIRY EMPLOYEE"){
            //  			$('#SalaryDiv').hide();
            //  			$('#EmployeeStatusDiv').hide();
            // }



            if (TypeValue == "MILK SUPPLIER") {
                $('#RateDiv').show();
                $('#supplierDiv').show();
            }
            if (TypeValue != "MILK SUPPLIER") {
                $('#RateDiv').hide();
                $('#supplierDiv').hide();
            }
            document.getElementById('account_group_id').value = TypeId;
            document.getElementById('account_type').value = TypeValue;
        }

        var idArray = [
            'code',
            'party_name',
            'account_show_id',
            'phone',
            'ntn',
            'strn',
            'city',
            'address',
            'saveButton'
        ];

        function focusNext(e) {
            try {
                for (var i = 0; i < idArray.length; i++) {
                    if (e.keyCode === 13 && e.target.id === idArray[i]) {
                        document.querySelector(`#${idArray[i+1]}`).focus();
                    }
                }
            } catch (error) {}
        }
    </script>

<script>

</script>
@stop
