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
                        {!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\BankReceiptController@update', $edit->id], 'class' => 'form-horizontal']) !!}
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
                                        {!! Form::text('voucher_no', null, ['id' => 'voucher_no', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    </div>
                                    <div class="st-meta-field st-meta-field--date">
                                        <label for="voucher_date">Vr. Date</label>
                                        {!! Form::date('voucher_date', null, ['id' => 'voucher_date', 'class' => 'form-control']) !!}
                                    </div>
                                    <div class="st-meta-field st-meta-field--account">
                                        <label for="account_id">Bank Or Cheque</label>
                                        {!! Form::select('account_id', $debitAccount, $edit->account_id, ['id' => 'account_id', 'class' => 'form-control']) !!}
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
                                            <?php $totalAmount = 0; ?>
                                            @foreach ($edit->voucher_details as $details)
                                                @if ($details->debit != null)
                                                    @php
                                                        $savedTaxAmount = floatval($details->taxAmount ?? 0);
                                                        $savedAmount = floatval($details->debit) - $savedTaxAmount;
                                                        $party_id = $details->head_id;
                                                        $accGroup = null;
                                                        if ($details->newparty) {
                                                            $accGroup = \App\Models\AccountGroup::find($details->newparty->account_group_id);
                                                        }
                                                        $rowHeads = \App\Models\Party::where(function ($q) use ($accGroup, $party_id) {
                                                            if ($accGroup) {
                                                                $q->where('account_group_id', $accGroup->id)->where('company_id', session()->get('company_id'));
                                                            } else {
                                                                $q->where('id', -1);
                                                            }
                                                        })->orWhere('id', $party_id)->orderBy('party_name', 'asc')->get();
                                                    @endphp
                                                    <tr class="st-data-row">
                                                        <td style="display:none;"><input type="text" class="head_id_input" value="{{ $details->head_id }}"></td>
                                                        <td style="display:none;"><input type="text" class="form-control voucher_no_input" value="{{ $details->voucher_no }}" readonly></td>
                                                        <td style="display:none;"><input type="text" class="v_type_input" value="Bank Receipt"></td>
                                                        <td style="display:none;"><input type="text" class="bank_id_input" value=""></td>
                                                        <td><input type="date" class="form-control date_input" value="{{ $details->date }}"></td>
                                                        <td><input type="text" class="form-control cheque_no_input" value="{{ $details->cheque_no }}"></td>
                                                        <td>
                                                            <select class="form-control account_type_select">
                                                                <option value="">Select</option>
                                                                @foreach ($accountGroups as $key => $value)
                                                                    <option value="{{ $key }}" {{ $key == ($details->newparty->account_group_id ?? null) ? 'selected' : '' }}>{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control account_head_select">
                                                                <option value="">Select</option>
                                                                @foreach ($rowHeads as $party)
                                                                    <option value="{{ $party->id . '_' . $party->party_name }}" {{ $party->id == $details->head_id ? 'selected' : '' }}>{{ $party->party_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td><input type="text" class="form-control narration_input" value="{{ $details->narration }}"></td>
                                                        <td class="st-num"><input type="number" class="form-control amount_input" value="{{ number_format($savedAmount, 2, '.', '') }}" onkeyup="updateTotals()"></td>
                                                        <td class="st-num"><input type="number" class="form-control tax_input" value="{{ $details->tax }}" onchange="changeGridAmount(this)"></td>
                                                        <td class="st-num"><input type="number" class="form-control taxamount_input" value="{{ number_format($savedTaxAmount, 2, '.', '') }}" readonly></td>
                                                        <td>
                                                            <select class="form-control title_select">
                                                                @foreach ($titles as $key => $value)
                                                                    <option value="{{ $key }}" {{ $key == ($details->title ?? '') ? 'selected' : '' }}>{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="text-center"><button type="button" onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="btn btn-danger btn-sm">Delete</button></td>
                                                    </tr>
                                                    <?php $totalAmount += $savedAmount; ?>
                                                @endif
                                            @endforeach
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
                                                <input type="text" class="form-control stat-value" id="TotalAmount" name="TotalAmount" value="{{ $totalAmount }}" disabled>
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

    $("#account_head_id").next(".select2").find(".select2-selection").on('focus', function() { $("#account_head_id").select2("open"); });
    $("#account_id").next(".select2").find(".select2-selection").on('focus', function() { $("#account_id").select2("open"); });
    $("#account_type").next(".select2").find(".select2-selection").on('focus', function() { $("#account_type").select2("open"); });
    $("#title").next(".select2").find(".select2-selection").on('focus', function() { $("#title").select2("open"); });

    $(document).ready(function() {
        initSelect2($('#myData'));
    });

    $('#account_id').change(function() { $('#account_id').select2('close'); $("#date").focus(); });
    $('#account_head_id').change(function() { $('#account_head_id').select2('close'); $("#narration").focus(); });

    $('#account_type').change(function() {
        var at = $(this).val();
        $.ajax({
            url: "{{ asset('get_account_group_parties') }}?id=" + at,
            type: 'get',
            dataType: 'json',
            success: function(res) {
                if (res.length == 0) {
                    $('#account_head_id').html('<option value="">Account Not Found</option>');
                } else {
                    var s = `<option value="">Select</option>`;
                    $.each(res, function(i, v) {
                        s += `<option value="${v.id+'_'+v.party_name}">${v.party_name}</option>`;
                    });
                    $('#account_head_id').html(s);
                }
                $('#account_head_id').val('').trigger('change');
                $('#account_head_id').select2('open');
            }
        });
    });

    $(document).on('change', '.account_type_select', function() {
        var at = $(this).val(), $r = $(this).closest('tr');
        $.ajax({
            url: "{{ asset('get_account_group_parties') }}?id=" + at,
            type: 'get',
            dataType: 'json',
            success: function(res) {
                if (res.length == 0) {
                    $r.find('.account_head_select').html('<option>Not Found</option>');
                    $r.find('.head_id_input').val('');
                } else {
                    var s = `<option value="">Select</option>`;
                    $.each(res, function(i, v) {
                        s += `<option value="${v.id+'_'+v.party_name}">${v.party_name}</option>`;
                    });
                    $r.find('.account_head_select').html(s);
                }
                $r.find('.account_head_select').select2().trigger('change');
            }
        });
    });

    $(document).on('change', '.account_head_select', function() {
        var v = $(this).val(), $r = $(this).closest('tr');
        if (v) {
            $r.find('.head_id_input').val(v.split('_')[0]);
        } else {
            $r.find('.head_id_input').val('');
        }
    });

    function changeAmount(tax) {
        var amount = parseFloat(document.getElementById('credit').value) || 0;
        var taxAmount = parseInt((tax * amount) / 100);
        document.getElementById('taxamount').value = taxAmount;
        document.getElementById('credit').value = amount - taxAmount;
    }

    function updateTotals() {
        var t = 0;
        $('#myData tr.st-data-row').each(function() {
            t += parseFloat($(this).find('.amount_input').val()) || 0;
        });
        document.getElementById('TotalAmount').value = t;
    }

    function changeGridAmount(el) {
        var $r = $(el).closest('tr'), tax = parseFloat($(el).val()) || 0, amt = parseFloat($r.find('.amount_input').val()) || 0;
        var ta = parseInt((tax * amt) / 100);
        $r.find('.taxamount_input').val(ta);
        $r.find('.amount_input').val(amt - ta);
        updateTotals();
    }

    function AddGridData() {
        var account_head_val = $('#account_head_id').val();
        if (!account_head_val || account_head_val == "") {
            Swal.fire('Please select an Account Name');
            return;
        }

        var bank_val = $('#bank_id').val();
        var bankId = bank_val ? bank_val.split("_")[0] : "";
        var headTitle = account_head_val.split("_").pop();
        var headId = account_head_val.split("_")[0];
        var date = $('#date').val();
        var voucherNo = $('#voucher_no').val();
        var chequeNo = $('#cheque_no').val();
        var vType = $('#v_type').val();
        var narration = $('#narration').val();
        var credit = $('#credit').val();
        var tax = $('#tax').val();
        var taxAmount = $('#taxamount').val();
        var title = $('#title').val();

        var h = '<tr class="st-data-row">';
        h += '<td style="display:none;"><input type="text" class="head_id_input" value="' + headId + '"></td>';
        h += '<td style="display:none;"><input type="text" class="form-control voucher_no_input" value="' + voucherNo + '" readonly></td>';
        h += '<td style="display:none;"><input type="text" class="v_type_input" value="' + vType + '"></td>';
        h += '<td style="display:none;"><input type="text" class="bank_id_input" value="' + bankId + '"></td>';
        h += '<td><input type="date" class="form-control date_input" value="' + date + '"></td>';
        h += '<td><input type="text" class="form-control cheque_no_input" value="' + chequeNo + '"></td>';
        h += '<td><select class="form-control account_type_select">' + $('#account_type').html() + '</select></td>';
        h += '<td><select class="form-control account_head_select">' + $('#account_head_id').html() + '</select></td>';
        h += '<td><input type="text" class="form-control narration_input" value="' + narration + '"></td>';
        h += '<td class="st-num"><input type="number" class="form-control amount_input" value="' + credit + '" onkeyup="updateTotals()"></td>';
        h += '<td class="st-num"><input type="number" class="form-control tax_input" value="' + tax + '" onchange="changeGridAmount(this)"></td>';
        h += '<td class="st-num"><input type="number" class="form-control taxamount_input" value="' + taxAmount + '" readonly></td>';
        h += '<td><select class="form-control title_select">' + $('#title').html() + '</select></td>';
        h += '<td class="text-center"><button type="button" onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="btn btn-danger btn-sm">Delete</button></td>';
        h += '</tr>';

        var $nr = $(h);
        $nr.find('.account_type_select').val($('#account_type').val());
        $nr.find('.account_head_select').val(headId + '_' + headTitle);
        $nr.find('.title_select').val(title);
        initSelect2($nr);

        $('#myData').append($nr);
        updateTotals();
        $("#account_type").select2('open').focus();
    }

    function myDeleteFunction(row) {
        Swal.fire({
            title: "Are You Sure?",
            text: "Delete this row?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            confirmButtonColor: '#28A745',
            cancelButtonText: 'No',
            cancelButtonColor: '#DC3545'
        }).then((r) => {
            if (r.isConfirmed) {
                $(row).remove();
                updateTotals();
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
            text: "Confirm Update?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Update!',
            confirmButtonColor: '#28A745',
            cancelButtonText: 'No',
            cancelButtonColor: '#DC3545'
        }).then((result) => {
            if (result.isConfirmed) {
                var voucher = {};
                voucher.voucher_no = $("#voucher_no").val();
                voucher.voucher_date = $("#voucher_date").val();
                voucher.account_id = $("#account_id").val().split("_")[0];
                voucher.v_type = $("#v_type").val();
                voucher.biller = $("#biller").val();
                voucher.company_id = $('#company_id').val();
                var products = [], isInvalid = false;
                $.each($("#myData tr.st-data-row"), function(i, row) {
                    var p = {};
                    p.head_id = $(row).find('.head_id_input').val();
                    if (!p.head_id) isInvalid = true;
                    p.date = $(row).find('.date_input').val();
                    p.voucher_no = $(row).find('.voucher_no_input').val();
                    p.cheque_no = $(row).find('.cheque_no_input').val();
                    p.v_type = $(row).find('.v_type_input').val();
                    p.bank_id = $(row).find('.bank_id_input').val();
                    p.narration = $(row).find('.narration_input').val();
                    p.amount = $(row).find('.amount_input').val();
                    p.company_id = $('#company_id').val();
                    p.tax = $(row).find('.tax_input').val();
                    p.taxAmount = $(row).find('.taxamount_input').val();
                    p.title = $(row).find('.title_select').val();
                    products.push(p);
                });
                if (isInvalid) {
                    Swal.fire('Error', 'Select valid Account Name for all rows!', 'error');
                    return false;
                }
                jQuery.ajax({
                    method: "PATCH",
                    cache: false,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: { voucher: JSON.stringify(voucher), product_data: products },
                    url: "{{ asset('bank-receipts') }}/<?php echo $edit->id; ?>",
                    success: function(result) {
                        if (parseInt(result) > 0) {
                            window.location.href = "{{ asset('bank-receipts') }}";
                        }
                    },
                    error: function(xhr, ao, te) { alert(xhr.status); alert(te); }
                });
            }
        });
    });
    </script>
@include('include.voucher-form-add-keys')
@stop
