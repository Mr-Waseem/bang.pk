@extends('app')
@section('contents')
<head>
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('include.voucher-form-styles')
</head>

    <body>
        <div class="container-fluid">
            @if (Session::has('flash_message'))
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                    style="margin-right: 20px;margin-top: 15px;">&times;</button>
                <div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix" id="panelbg">
                        <h2 class="panel-title"><b>Add Journal Voucher</b></h2>
                    </div>
                    <div class="panel-body">
                        <input id="token" type="hidden" value="{{ $encrypted_token }}">
                        @include('errors.validation')
                        {!! Form::open(['url' => 'general-voucher', 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}
                        {!! Form::text('v_type', 'Journal Voucher', ['id' => 'v_type', 'class' => 'form-control', 'style' => 'display:none']) !!}
                        <select name="biller" id="biller" class="form-control" style="display:none;" disabled>
                            <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                        </select>

                        <div class="st-wrap">
                            <div class="st-meta-section">
                                <div class="st-meta-row st-meta-row--voucher-only">
                                    <div class="st-meta-field st-meta-field--vr">
                                        <label for="voucher_no">Vr. No</label>
                                        {!! Form::text('voucher_no', $codes, ['id' => 'voucher_no', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    </div>
                                    <div class="st-meta-field st-meta-field--date">
                                        <label for="voucher_date">Vr. Date</label>
                                        <input id="voucher_date" type="date" name="voucher_date" value="<?php echo date('Y-m-d'); ?>" class="form-control" autofocus>
                                    </div>
                                </div>
                            </div>

                            <div class="st-grid-panel">
                                <div class="st-grid-scroll">
                                    <table id="myTable" class="table st-table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Account Type</th>
                                                <th>Account Name</th>
                                                <th>Narration</th>
                                                <th class="st-num">Debit</th>
                                                <th class="st-num">Credit</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="myData">
                                            <tr class="st-entry">
                                                {!! Form::hidden('product_id', null, ['id' => 'product_id']) !!}
                                                <td><input id="date" type="date" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control"></td>
                                                <td>{!! Form::select('account_type', $accountGroups, null, ['id' => 'account_type', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::select('account_head_id', $Heads, null, ['id' => 'account_head_id', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('narration', null, ['id' => 'narration', 'class' => 'form-control']) !!}</td>
                                                <td class="st-num">{!! Form::text('debit', null, ['id' => 'debit', 'class' => 'form-control', 'onkeyup' => 'DebitUp(this.value)', 'onfocus' => 'this.value=""', 'onkeypress' => 'return onlyNumberKey(event)']) !!}</td>
                                                <td class="st-num">{!! Form::text('credit', null, ['id' => 'credit', 'class' => 'form-control', 'onkeyup' => 'CreditUp(this.value);', 'onfocus' => 'this.value=""', 'onkeypress' => 'return onlyNumberKey(event)']) !!}</td>
                                                <td class="text-center"><button type="button" class="btn btn-success btn-sm btn-add-line" onclick="AddGridData()">Add</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="summary-container">
                                <div class="card summary-card">
                                    <div class="card-body py-3">
                                        <div class="summary-row">
                                            <div class="stat-item">
                                                <span class="stat-label">Total Debit</span>
                                                <input type="text" class="form-control stat-value" value="0" id="TotalDebit" name="TotalRate" disabled>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label">Total Credit</span>
                                                <input type="text" class="form-control stat-value" value="0" id="TotalCredit" name="TotalAmount" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <center>
                                <div class="form-actions">
                                    <button type="button" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm btn-save-voucher" id="btnSave" name="btnSave">Save</button>
                                </div>
                            </center>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </body>
@stop
@section('scripts')
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<script type="text/javascript">
        function initSelect2($scope) {
            $scope.find('.account_type_select, .account_head_select').select2();
        }

        $("#account_head_id").select2();
        $("#account_type").select2();

        $("#account_head_id").next(".select2").find(".select2-selection").focus(function() {
            $("#account_head_id").select2("open");
        });
        $("#account_type").next(".select2").find(".select2-selection").focus(function() {
            $("#account_type").select2("open");
        });

        $('#account_head_id').change(function() {
            $('#account_head_id').select2().trigger('select2:close');
            $("#narration").focus();
        });
    </script>

    <script type="text/javascript">
        function CreditUp(debit) {
            debit = document.getElementById("debit").value;
            if (debit == "") {
                document.getElementById("debit").value = 0;
            }
        }

        function DebitUp(credit) {
            credit = document.getElementById("credit").value;
            if (credit == "") {
                document.getElementById("credit").value = 0;
            }
        }

        function AddGridData() {
            credit = document.getElementById("credit").value;
            if (credit == "") {
                document.getElementById("credit").value = 0;
            }
            debit = document.getElementById("debit").value;
            if (debit == "") {
                document.getElementById("debit").value = 0;
            }
            if ($("#credit").val() == "" && $("#debit").val() == "") {
                document.getElementById("debit").focus();
                Swal.fire('Must enter Debit or Credit Value!');
                return;
            }
            if ($("#credit").val() == "0" && $("#debit").val() == "0") {
                document.getElementById("debit").focus();
                Swal.fire('Debit and Credit both none be zero!');
                return;
            }
            var date = document.getElementById('date').value;
            var voucherNo = document.getElementById('voucher_no').value;
            var type = document.getElementById('v_type').value;
            var headId = document.getElementById('account_head_id').value.split("_")[0];
            var narration = document.getElementById('narration').value;
            var debitVal = document.getElementById('debit').value;
            var creditVal = document.getElementById('credit').value;
            var typeValue = $('#account_type').val();
            var accountTypeHtml = $('#account_type').html();
            var accountHeadHtml = $('#account_head_id').html();
            var headValue = $('#account_head_id').val();

            var tableHtml = '<tr class="st-data-row">';
            tableHtml += '<td style="display:none;"><input type="text" class="head_id_input" value="' + headId + '"></td>';
            tableHtml += '<td style="display:none;"><input type="text" class="form-control voucher_no_input" value="' + voucherNo + '" readonly></td>';
            tableHtml += '<td style="display:none;"><input type="text" class="v_type_input" value="' + type + '"></td>';
            tableHtml += '<td><input type="date" class="form-control date_input" value="' + date + '"></td>';
            tableHtml += '<td><select class="form-control account_type_select">' + accountTypeHtml + '</select></td>';
            tableHtml += '<td><select class="form-control account_head_select">' + accountHeadHtml + '</select></td>';
            tableHtml += '<td><input type="text" class="form-control narration_input" value="' + narration + '"></td>';
            tableHtml += '<td class="st-num"><input type="number" class="form-control debit_input" value="' + debitVal + '" onkeyup="updateTotals()" onkeypress="return onlyNumberKey(event)"></td>';
            tableHtml += '<td class="st-num"><input type="number" class="form-control credit_input" value="' + creditVal + '" onkeyup="updateTotals()" onkeypress="return onlyNumberKey(event)"></td>';
            tableHtml += '<td class="text-center"><button type="button" onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="btn btn-danger btn-sm">Delete</button></td>';
            tableHtml += '</tr>';

            var $newRow = $(tableHtml);
            $newRow.find('.account_type_select').val(typeValue);
            $newRow.find('.account_head_select').val(headValue);
            initSelect2($newRow);
            $('#myData').append($newRow);

            updateTotals();
            document.getElementById("date").focus();
        }

        function updateTotals() {
            var tDebit = 0;
            var tCredit = 0;
            $('#myData tr.st-data-row').each(function() {
                var deb = parseFloat($(this).find('.debit_input').val()) || 0;
                var cred = parseFloat($(this).find('.credit_input').val()) || 0;
                tDebit += deb;
                tCredit += cred;
            });
            if (document.getElementById('TotalDebit')) {
                document.getElementById('TotalDebit').value = tDebit;
            }
            if (document.getElementById('TotalCredit')) {
                document.getElementById('TotalCredit').value = tCredit;
            }
        }

        $(document).on('change', '.account_type_select', function() {
            var account_type = $(this).val();
            var $row = $(this).closest('tr');
            $.ajax({
                url: "{{ asset('get_account_group_parties') }}?id=" + account_type,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    if (response.length == 0) {
                        $row.find('.account_head_select').html('<option>Account Not Found</option>');
                        $row.find('.head_id_input').val('');
                    } else {
                        var str = `<option value="">Select Value</option>`;
                        $.each(response, function(i, v) {
                            str += `<option value="${v.id+'_'+v.party_name}">${v.party_name}</option>`;
                        });
                        $row.find('.account_head_select').html(str);
                    }
                    $row.find('.account_head_select').select2().trigger('change');
                }
            });
        });

        $(document).on('change', '.account_head_select', function() {
            var val = $(this).val();
            var $row = $(this).closest('tr');
            if (val) {
                $row.find('.head_id_input').val(val.split('_')[0]);
            } else {
                $row.find('.head_id_input').val('');
            }
        });

        function myDeleteFunction(row) {
            Swal.fire({
                title: "Are You Sure?",
                text: "Confirm Transaction?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete it!',
                confirmButtonColor: '#28A745',
                cancelButtonText: 'No, cancel!',
                cancelButtonColor: '#DC3545',
            }).then((result) => {
                if (result.isConfirmed) {
                    $(row).remove();
                    updateTotals();
                }
            });
        }

        $("#btnSave").click(function() {
            Swal.fire({
                title: "Are You Sure?",
                text: "Confirm Transaction?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Create it!',
                confirmButtonColor: '#28A745',
                cancelButtonText: 'No, cancel!',
                cancelButtonColor: '#DC3545',
            }).then((result) => {
                if (result.isConfirmed) {
                    var voucher = new Object();
                    voucher.voucher_no = $("#voucher_no").val();
                    voucher.voucher_date = $("#voucher_date").val();
                    voucher.v_type = $("#v_type").val();
                    voucher.biller = $("#biller").val();
                    voucher.company_id = $('#company_id').val();

                    var products = [];
                    var isInvalid = false;
                    $.each($("#myData tr.st-data-row"), function(index, row) {
                        var product = new Object();
                        product.head_id = $(row).find('.head_id_input').val();
                        if (!product.head_id) {
                            isInvalid = true;
                        }
                        product.date = $(row).find('.date_input').val();
                        product.voucher_no = $(row).find('.voucher_no_input').val();
                        product.v_type = $(row).find('.v_type_input').val();
                        product.narration = $(row).find('.narration_input').val();
                        product.debit = $(row).find('.debit_input').val();
                        product.credit = $(row).find('.credit_input').val();
                        product.company_id = $('#company_id').val();
                        products.push(product);
                    });
                    if (isInvalid) {
                        Swal.fire('Error', 'Please select a valid Account Name for all rows before saving!', 'error');
                        return;
                    }

                    if (products != "") {
                        jQuery.ajax({
                            url: "{{ asset('general-voucher') }}",
                            method: "POST",
                            cache: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                voucher: JSON.stringify(voucher),
                                product_data: products
                            },
                            success: function(result) {
                                if (result == "saved") {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Transaction Submitted!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    window.location.href = "{{ asset('general-voucher/create') }}";
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                $("#spanWait").hide();
                                alert(xhr.status);
                                alert(thrownError);
                            }
                        });
                    } else {
                        document.getElementById("date").focus();
                        Swal.fire('Add your Account in Grid');
                    }
                }
            });
        });

        $('#account_type').change(function() {
            var account_type = $(this).val();
            $.ajax({
                url: "{{ asset('get_account_group_parties') }}?id=" + account_type,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    if (response.length == 0) {
                        $('#account_head_id').html('<option>Account Not Found</option>');
                    } else {
                        var str = `<option value="">Select Value</option>`;
                        $.each(response, function(i, v) {
                            str += `<option value="${v.id+'_'+v.party_name}">${v.party_name}</option>`;
                        });
                        $('#account_head_id').html(str);
                    }
                    $('#account_head_id').val('').trigger('change');
                    if (response.length != 0) {
                        $('#account_head_id').select2('open');
                    }
                }
            });
        });
    </script>
@include('include.voucher-form-add-keys')
@stop
