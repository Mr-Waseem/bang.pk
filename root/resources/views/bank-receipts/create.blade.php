@extends("app")
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
                        <h2 class="panel-title"><b>Bank Receipt Voucher</b></h2>
                    </div>
                    <div class="panel-body">
                        <input id="token" type="hidden" value="{{ $encrypted_token }}">
                        @include('errors.validation')
                        {!! Form::open(['url' => 'cheque-payments', 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}
                        {!! Form::text('v_type', 'Bank Receipt', ['id' => 'v_type', 'class' => 'form-control', 'style' => 'display:none']) !!}
                        <select name="biller" id="biller" class="form-control" style="display:none;" disabled>
                            <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                        </select>

                        <div class="st-wrap">
                            <div class="st-meta-section">
                                <div class="st-meta-row st-meta-row--voucher">
                                    <div class="st-meta-field st-meta-field--vr">
                                        <label for="voucher_no">Vr. No</label>
                                        {!! Form::text('voucher_no', $codes, ['id' => 'voucher_no', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    </div>
                                    <div class="st-meta-field st-meta-field--date">
                                        <label for="voucher_date">Vr. Date</label>
                                        <input id="voucher_date" type="date" name="voucher_date" value="<?php echo date('Y-m-d'); ?>" class="form-control" autofocus>
                                    </div>
                                    <div class="st-meta-field st-meta-field--account">
                                        <label for="account_id">Bank Or Cheque</label>
                                        {!! Form::select('account_id', $debitAccount, null, ['id' => 'account_id', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="st-grid-panel">
                                <div class="st-grid-scroll">
                                    <table id="myTable" class="table st-table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Cheque No</th>
                                                <th>Account Type</th>
                                                <th>Account Name</th>
                                                <th>Narration</th>
                                                <th class="st-num">Amount</th>
                                                <th class="st-num">Tax</th>
                                                <th class="st-num">Tax Amount</th>
                                                <th>Title</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="myData">
                                            <tr class="st-entry">
                                                {!! Form::hidden('product_id', null, ['id' => 'product_id']) !!}
                                                <td><input id="date" type="date" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control"></td>
                                                <td>{!! Form::text('cheque_no', null, ['id' => 'cheque_no', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::select('account_type', $accountGroups, null, ['id' => 'account_type', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::select('account_head_id', $Accounts, null, ['id' => 'account_head_id', 'class' => 'form-control']) !!}</td>
                                                <td style="display:none;">{!! Form::select('bank_id', $banks, null, ['id' => 'bank_id', 'class' => 'form-control livesearch']) !!}</td>
                                                <td>{!! Form::text('narration', 'Bank Receipt', ['id' => 'narration', 'class' => 'form-control']) !!}</td>
                                                <td class="st-num">{!! Form::text('credit', null, ['id' => 'credit', 'class' => 'form-control', 'onfocus' => 'this.value=""', 'onkeypress' => 'return onlyNumberKey(event)']) !!}</td>
                                                <td class="st-num">{!! Form::text('tax', null, ['id' => 'tax', 'class' => 'form-control', 'onfocus' => 'this.value=""', 'onkeypress' => 'return onlyNumberKey(event)', 'onchange' => 'changeAmount(this.value)']) !!}</td>
                                                <td class="st-num">{!! Form::text('taxamount', null, ['id' => 'taxamount', 'class' => 'form-control', 'disabled' => 'disabled']) !!}</td>
                                                <td>{!! Form::select('title', $titles, null, ['id' => 'title', 'class' => 'form-control']) !!}</td>
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
                                                <span class="stat-label">Total Amount</span>
                                                <input type="text" class="form-control stat-value" id="TotalAmount" name="TotalAmount" value="0" disabled>
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
            $scope.find('.account_type_select, .account_head_select, .title_select').select2();
        }

        $("#account_head_id").select2();
        $("#account_id").select2();
        $("#account_type").select2();
        $("#title").select2();
        $('.livesearch').select2();

        $("#account_head_id").next(".select2").find(".select2-selection").focus(function() { $("#account_head_id").select2("open"); });
        $("#account_id").next(".select2").find(".select2-selection").focus(function() { $("#account_id").select2("open"); });
        $("#account_type").next(".select2").find(".select2-selection").focus(function() { $("#account_type").select2("open"); });
        $("#title").next(".select2").find(".select2-selection").focus(function() { $("#title").select2("open"); });

        $('#account_id').change(function() {
            $('#account_id').select2('close');
            $("#date").focus();
        });

        $('#account_head_id').change(function() {
            $('#account_head_id').select2('close');
            $("#narration").focus();
        });

        $('#account_type').change(function() {
            var account_type = $(this).val();
            $.ajax({
                url: "{{ asset('get_account_group_parties') }}?id=" + account_type,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    if (response.length == 0) {
                        $('#account_head_id').html('<option value="">Account Not Found</option>');
                    } else {
                        var str = `<option value="">Select Value</option>`;
                        $.each(response, function(i, v) {
                            str += `<option value="${v.id+'_'+v.party_name}">${v.party_name}</option>`;
                        });
                        $('#account_head_id').html(str);
                    }
                    $('#account_head_id').val('').trigger('change');
                    $('#account_head_id').select2('open');
                }
            });
        });

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

        function changeAmount(tax) {
            var amount = parseFloat(document.getElementById('credit').value) || 0;
            var taxAmount = parseInt((tax * amount) / 100);
            document.getElementById('taxamount').value = taxAmount;
            document.getElementById('credit').value = amount - taxAmount;
        }

        function updateTotals() {
            var tAmount = 0;
            $('#myData tr.st-data-row').each(function() {
                tAmount += parseFloat($(this).find('.amount_input').val()) || 0;
            });
            $('#TotalAmount').val(tAmount);
        }

        function changeGridAmount(element) {
            var $row = $(element).closest('tr');
            var tax = parseFloat($(element).val()) || 0;
            var amount = parseFloat($row.find('.amount_input').val()) || 0;
            var taxAmount = parseInt((tax * amount) / 100);
            $row.find('.taxamount_input').val(taxAmount);
            $row.find('.amount_input').val(amount - taxAmount);
            updateTotals();
        }

        function AddGridData() {
            if ($("#credit").val() == "" || $("#account_head_id").val() == "") {
                document.getElementById("credit").focus();
                Swal.fire('Account Name or Amount Value Cant be Empty!');
                return;
            }

            var date = $('#date').val();
            var voucherNo = $('#voucher_no').val();
            var chequeNo = $('#cheque_no').val();
            var v_type = $('#v_type').val();
            var headTitle = $('#account_head_id').val().split("_").pop();
            var headId = $('#account_head_id').val().split("_")[0];
            var bankValue = $('#bank_id').val();
            var bankId = bankValue ? bankValue.split("_")[0] : "";
            var narration = $('#narration').val();
            var credit = $('#credit').val();
            var tax = $('#tax').val();
            var taxAmount = $('#taxamount').val();
            var title = $('#title').val();

            var tableHtml = '<tr class="st-data-row">';
            tableHtml += '<td style="display:none;"><input type="text" class="head_id_input" value="' + headId + '"></td>';
            tableHtml += '<td style="display:none;"><input type="text" class="form-control voucher_no_input" value="' + voucherNo + '" readonly></td>';
            tableHtml += '<td style="display:none;"><input type="text" class="v_type_input" value="' + v_type + '"></td>';
            tableHtml += '<td style="display:none;"><input type="text" class="bank_id_input" value="' + bankId + '"></td>';
            tableHtml += '<td><input type="date" class="form-control date_input" value="' + date + '"></td>';
            tableHtml += '<td><input type="text" class="form-control cheque_no_input" value="' + chequeNo + '"></td>';
            tableHtml += '<td><select class="form-control account_type_select">' + $('#account_type').html() + '</select></td>';
            tableHtml += '<td><select class="form-control account_head_select">' + $('#account_head_id').html() + '</select></td>';
            tableHtml += '<td><input type="text" class="form-control narration_input" value="' + narration + '"></td>';
            tableHtml += '<td class="st-num"><input type="number" class="form-control amount_input" value="' + credit + '" onkeyup="updateTotals()"></td>';
            tableHtml += '<td class="st-num"><input type="number" class="form-control tax_input" value="' + tax + '" onchange="changeGridAmount(this)"></td>';
            tableHtml += '<td class="st-num"><input type="number" class="form-control taxamount_input" value="' + taxAmount + '" readonly></td>';
            tableHtml += '<td><select class="form-control title_select">' + $('#title').html() + '</select></td>';
            tableHtml += '<td class="text-center"><button type="button" onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="btn btn-danger btn-sm">Delete</button></td>';
            tableHtml += '</tr>';

            var $newRow = $(tableHtml);
            $newRow.find('.account_type_select').val($('#account_type').val());
            $newRow.find('.account_head_select').val(headId + '_' + headTitle);
            $newRow.find('.title_select').val(title);
            initSelect2($newRow);

            $('#myData').append($newRow);
            updateTotals();
            $("#account_type").select2('open').focus();
        }

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
                    document.getElementById("date").focus();
                }
            });
        }

        $("#btnSave").click(function() {
            if ($('#account_id').val() == '') {
                Swal.fire('Select Bank Account First');
                return false;
            }
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
                    voucher.account_id = $("#account_id").val().split("_")[0];
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
                        product.cheque_no = $(row).find('.cheque_no_input').val();
                        product.v_type = $(row).find('.v_type_input').val();
                        product.bank_id = $(row).find('.bank_id_input').val();
                        product.narration = $(row).find('.narration_input').val();
                        product.amount = $(row).find('.amount_input').val();
                        product.company_id = $('#company_id').val();
                        product.tax = $(row).find('.tax_input').val();
                        product.taxAmount = $(row).find('.taxamount_input').val();
                        product.title = $(row).find('.title_select').val();
                        products.push(product);
                    });

                    if (isInvalid) {
                        Swal.fire('Error', 'Please select a valid Account Name for all rows before saving!', 'error');
                        return false;
                    }

                    if (products != "") {
                        jQuery.ajax({
                            method: "POST",
                            cache: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                voucher: JSON.stringify(voucher),
                                product_data: products
                            },
                            url: "{{ asset('bank-receipts') }}",
                            success: function(result) {
                                if (parseInt(result) > 0) {
                                    window.location.href = "{{ asset('bank-receipts/create') }}";
                                    window.open("{{ asset('bank-receipts') }}/" + result);
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                $("#spanWait").hide();
                                alert(xhr.status);
                                alert(thrownError);
                            }
                        });
                    } else {
                        Swal.fire('Add your Account in Grid');
                    }
                }
            });
        });
    </script>
@include('include.voucher-form-add-keys')
@stop
