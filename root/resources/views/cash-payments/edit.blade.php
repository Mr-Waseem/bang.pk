@extends("app")

<head>
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('include.voucher-form-styles')
</head>
@section('contents')
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
                        <h2 class="panel-title"><b>Edit Cash Payment</b></h2>
                    </div>
                    <div class="panel-body">
                        <input id="token" type="hidden" value="{{ $encrypted_token }}">
                        @include('errors.validation')
                        {!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\CashPaymentController@update', $edit->id], 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}
                        {!! Form::hidden('shop_id', null, ['id' => 'shop_id', 'class' => 'form-control']) !!}
                        {!! Form::hidden('biller', null, ['id' => 'biller', 'class' => 'form-control']) !!}
                        {!! Form::text('v_type', 'Cash Payment', ['id' => 'v_type', 'class' => 'form-control', 'style' => 'display:none']) !!}

                        <div class="st-wrap">
                            <div class="st-meta-section">
                                <div class="st-meta-row st-meta-row--voucher">
                                    <div class="st-meta-field st-meta-field--vr">
                                        <label for="voucher_no">Vr. No</label>
                                        {!! Form::text('voucher_no', null, ['id' => 'voucher_no', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    </div>
                                    <div class="st-meta-field st-meta-field--date">
                                        <label for="voucher_date">Vr. Date</label>
                                        <input id="voucher_date" type="date" name="voucher_date"
                                            value="{{ old('voucher_date', $edit->voucher_date ?? date('Y-m-d')) }}"
                                            class="form-control">
                                    </div>
                                    <div class="st-meta-field st-meta-field--account">
                                        <label for="account_id">Cash Account</label>
                                        {!! Form::select('account_id', $cashAccount, null, ['id' => 'account_id', 'class' => 'form-control']) !!}
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
                                                <td>
                                                    <input id="date" type="date" name="date"
                                                        value="<?php echo date('Y-m-d'); ?>" class="form-control" autofocus>
                                                </td>
                                                <td>
                                                    {!! Form::select('account_type', $accountGroups, null, ['id' => 'account_type', 'class' => 'form-control']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::select('account_head_id', $Accounts, null, ['id' => 'account_head_id', 'class' => 'form-control']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::text('narration', 'CASH PAID', ['id' => 'narration', 'class' => 'form-control']) !!}
                                                </td>
                                                <td class="st-num">
                                                    {!! Form::text('amount', null, ['id' => 'amount', 'class' => 'form-control', 'onfocus' => 'this.value=""']) !!}
                                                </td>
                                                <td class="st-num">
                                                    {!! Form::text('tax', null, ['id' => 'tax', 'class' => 'form-control', 'onfocus' => 'this.value=""', 'onchange' => 'changeAmount(this.value)']) !!}
                                                </td>
                                                <td class="st-num">
                                                    {!! Form::text('taxamount', null, ['id' => 'taxamount', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::select('title', $titles, null, ['id' => 'title', 'class' => 'form-control']) !!}
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-success btn-sm btn-add-line"
                                                        onclick="AddGridData()">Add</button>
                                                </td>
                                            </tr>
                                            <?php $totalAmount = 0; ?>
                                            @foreach ($edit->voucher_details as $details)
                                                @if ($details->debit != null && !array_key_exists($details->narration, $titles))
                                                    @php
                                                        $taxRow = $edit->voucher_details->first(function ($item) use ($details, $titles) {
                                                            return $item->debit != null
                                                                && $item->account_head_id == $details->account_head_id
                                                                && $item->date == $details->date
                                                                && array_key_exists($item->narration, $titles);
                                                        });
                                                        $savedTaxAmount = $taxRow ? floatval($taxRow->debit) : 0;
                                                        $netAmount = floatval($details->debit);
                                                        $grossAmount = $netAmount + $savedTaxAmount;
                                                        $selectedTitle = $taxRow ? $taxRow->narration : '';
                                                    @endphp
                                                    <tr class="st-data-row">
                                                        <td style="display:none;"><input type="text" class="head_id_input" value="{{ $details->account_head_id }}"></td>
                                                        <td style="display:none;"><input type="text" class="form-control voucher_no_input" value="{{ $details->voucher_no }}" readonly></td>
                                                        <td style="display:none;"><input type="text" class="v_type_input" value="Cash Payment"></td>
                                                        <td><input type="date" class="form-control date_input" value="{{ $details->date }}"></td>
                                                        <td>
                                                            <select class="form-control account_type_select">
                                                                <option value="">Select Value</option>
                                                                @foreach ($accountGroups as $key => $value)
                                                                    <option value="{{ $key }}" {{ $key == ($details->parties->account_group_id ?? null) ? 'selected' : '' }}>{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            @php
                                                                $accGroup = \App\Models\AccountGroup::find($details->parties->account_group_id ?? 0);
                                                                $rowHeads = \App\Models\Party::where(function ($query) use ($accGroup) {
                                                                    if ($accGroup) {
                                                                        $query->where('account_group_id', $accGroup->id);
                                                                        $query->where('company_id', session()->get('company_id'));
                                                                    } else {
                                                                        $query->where('id', -1);
                                                                    }
                                                                })->orderBy('party_name', 'asc')->get();
                                                            @endphp
                                                            <select class="form-control account_head_select">
                                                                <option value="">Select Value</option>
                                                                @foreach ($rowHeads as $party)
                                                                    <option value="{{ $party->id . '_' . $party->party_name }}" {{ $party->id == $details->account_head_id ? 'selected' : '' }}>{{ $party->party_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td><input type="text" class="form-control narration_input" value="{{ $details->narration }}"></td>
                                                        <td class="st-num"><input type="number" class="form-control amount_input" value="{{ number_format($netAmount, 2, '.', '') }}" onkeyup="updateTotals()"></td>
                                                        <td class="st-num"><input type="number" class="form-control tax_input" value="{{ $details->tax }}" onchange="changeGridAmount(this)"></td>
                                                        <td class="st-num"><input type="number" class="form-control taxamount_input" value="{{ number_format($savedTaxAmount, 2, '.', '') }}" readonly></td>
                                                        <td>
                                                            <select class="form-control title_select">
                                                                @foreach ($titles as $key => $value)
                                                                    <option value="{{ $key }}" {{ $key == $selectedTitle ? 'selected' : '' }}>{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="btn btn-danger btn-sm">Delete</button>
                                                        </td>
                                                    </tr>
                                                    <?php $totalAmount += $netAmount; ?>
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
                                    <button type="button" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm btn-save-voucher"
                                        id="btnSave" name="btnSave">Save</button>
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

        $("#account_id").select2();
        $("#account_type").select2();
        $("#account_head_id").select2();
        $("#title").select2();

        $("#account_id").next(".select2").find(".select2-selection").focus(function() {
            $("#account_id").select2("open");
        });
        $("#account_type").next(".select2").find(".select2-selection").focus(function() {
            $("#account_type").select2("open");
        });
        $("#account_head_id").next(".select2").find(".select2-selection").focus(function() {
            $("#account_head_id").select2("open");
        });
        $("#title").next(".select2").find(".select2-selection").focus(function() {
            $("#title").select2("open");
        });

        $(document).ready(function() {
            initSelect2($('#myData'));
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
            var amount = parseFloat(document.getElementById('amount').value) || 0;
            var taxAmount = parseInt((tax * amount) / 100);
            document.getElementById('taxamount').value = taxAmount;
            document.getElementById('amount').value = amount - taxAmount;
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

        function updateTotals() {
            var tAmount = 0;
            $('#myData tr.st-data-row').each(function() {
                tAmount += parseFloat($(this).find('.amount_input').val()) || 0;
            });
            $('#TotalAmount').val(tAmount);
        }

        function AddGridData() {
            if ($("#amount").val() == "" || $("#account_head_id").val() == "") {
                alert('Account Name or Amount Value Cant be Empty!');
                document.getElementById("amount").focus();
                return false;
            }

            var date = $('#date').val();
            var voucherNo = $('#voucher_no').val();
            var v_type = $('#v_type').val();
            var headTitle = $('#account_head_id').val().split("_").pop();
            var headId = $('#account_head_id').val().split("_")[0];
            var narration = $('#narration').val();
            var amount = $('#amount').val();
            var tax = $('#tax').val();
            var taxAmount = $('#taxamount').val();
            var title = $('#title').val();

            var tableHtml = '<tr class="st-data-row">';
            tableHtml += '<td style="display:none;"><input type="text" class="head_id_input" value="' + headId + '"></td>';
            tableHtml += '<td style="display:none;"><input type="text" class="form-control voucher_no_input" value="' + voucherNo + '" readonly></td>';
            tableHtml += '<td style="display:none;"><input type="text" class="v_type_input" value="' + v_type + '"></td>';
            tableHtml += '<td><input type="date" class="form-control date_input" value="' + date + '"></td>';
            tableHtml += '<td><select class="form-control account_type_select">' + $('#account_type').html() + '</select></td>';
            tableHtml += '<td><select class="form-control account_head_select">' + $('#account_head_id').html() + '</select></td>';
            tableHtml += '<td><input type="text" class="form-control narration_input" value="' + narration + '"></td>';
            tableHtml += '<td class="st-num"><input type="number" class="form-control amount_input" value="' + amount + '" onkeyup="updateTotals()"></td>';
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
            $('#date').focus();
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
                    $('#date').focus();
                }
            });
        }

        $("#btnSave").click(function() {
            var accountId = $("#account_id").val();
            if (!accountId) {
                Swal.fire('Error', 'Please select a Cash Account before saving!', 'error');
                return false;
            }

            Swal.fire({
                title: "Are You Sure?",
                text: "Confirm Transaction?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Update it!',
                confirmButtonColor: '#28A745',
                cancelButtonText: 'No, cancel!',
                cancelButtonColor: '#DC3545',
            }).then((result) => {
                if (result.isConfirmed) {
                    var voucher = new Object();
                    voucher.account_id = accountId.split("_").length > 1 ? accountId.split("_")[0] : accountId;
                    voucher.voucher_no = $("#voucher_no").val();
                    voucher.voucher_date = $("#voucher_date").val();
                    voucher.shop_id = $("#shop_id").val();
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

                    jQuery.ajax({
                        method: "PATCH",
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            voucher: JSON.stringify(voucher),
                            product_data: products
                        },
                        url: "{{ asset('cash-payments') }}/<?php echo $edit->id; ?>",
                        success: function(result) {
                            if (parseInt(result) > 0) {
                                window.location.href = "{{ asset('cash-payments') }}";
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    });
                }
            });
        });
    </script>
@include('include.voucher-form-add-keys')
@stop
