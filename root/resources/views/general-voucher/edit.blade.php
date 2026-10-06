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
                        <h2 class="panel-title"><b>Edit Journal Voucher</b></h2>
                    </div>
                    <div class="panel-body">
                        <input id="token" type="hidden" value="{{ $encrypted_token }}">
                        @include('errors.validation')
                        {!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\GeneralVoucherController@update', $edit->id], 'class' => 'form-horizontal']) !!}
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
                                        {!! Form::text('voucher_no', $edit->voucher_no, ['id' => 'voucher_no', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
                                    </div>
                                    <div class="st-meta-field st-meta-field--date">
                                        <label for="voucher_date">Vr. Date</label>
                                        {!! Form::date('voucher_date', $edit->voucher_date, ['id' => 'voucher_date', 'class' => 'form-control']) !!}
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
                                                {!! Form::hidden('product_id', null, ['id' => 'product_id', 'class' => 'form-control']) !!}
                                                <td><input id="date" type="date" name="add_date" value="<?php echo date('Y-m-d'); ?>" class="form-control"></td>
                                                <td>{!! Form::select('account_type', $accountGroups, null, ['id' => 'account_type', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::select('add_account_head_id', $Heads, null, ['id' => 'account_head_id', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('add_narration', 'OPENING BALANCE', ['id' => 'narration', 'class' => 'form-control']) !!}</td>
                                                <td class="st-num">{!! Form::text('add_debit', 0, ['id' => 'debit', 'class' => 'form-control']) !!}</td>
                                                <td class="st-num">{!! Form::text('add_credit', 0, ['id' => 'credit', 'class' => 'form-control']) !!}</td>
                                                <td class="text-center"><button type="button" class="btn btn-success btn-sm btn-add-line" onclick="AddGridData()">Add</button></td>
                                            </tr>
                                            <?php $TotalDebit = 0; $TotalCredit = 0; ?>
                                            @foreach ($edit->voucher_details as $details)
                                                <tr class="st-data-row">
                                                    <td style="display:none;"><input id="account_head_id" name="account_head_id[]" value="{{ $details->account_head_id }}" type="text" class="form-control head_id_input"></td>
                                                    <td><input id="date" name="date[]" value="{{ $details->date }}" type="date" class="form-control date_input"></td>
                                                    <td>
                                                        <select name="account_type[]" class="form-control account_type_select">
                                                            <option value="">Select Value</option>
                                                            @foreach($accountGroups as $key => $value)
                                                                <option value="{{ $key }}" {{ $key == ($details->parties->account_group_id ?? null) ? 'selected' : '' }}>{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $accGroup = \App\Models\AccountGroup::find($details->parties->account_group_id ?? 0);
                                                            $rowHeads = \App\Models\Party::where(function($query) use($accGroup) {
                                                                if($accGroup) {
                                                                    $query->where('account_group_id', $accGroup->id);
                                                                    $query->where('company_id', session()->get('company_id'));
                                                                    if($accGroup->name == "PURCHASES") $query->orWhere('account_type', 'PURCHASES');
                                                                    if($accGroup->name == "SALES") $query->orWhere('account_type', 'SALES');
                                                                    if($accGroup->name == "ADVANCE INCOME TAX") $query->orWhere('account_type', 'ADVANCE INCOME TAX');
                                                                    if($accGroup->name == "STOCK INVENTORY") $query->orWhere('account_type', 'STOCK INVENTORY');
                                                                } else {
                                                                    $query->where('id', -1);
                                                                }
                                                            })->orderBy('party_name', 'asc')->get();
                                                        @endphp
                                                        <select name="add_account_head_id[]" class="form-control account_head_select">
                                                            <option value="">Select Value</option>
                                                            @foreach($rowHeads as $party)
                                                                <option value="{{ $party->id.'_'.$party->party_name }}" {{ $party->id == $details->account_head_id ? 'selected' : '' }}>{{ $party->party_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input id="narration" name="narration[]" value="{{ $details->narration }}" type="text" class="form-control narration_input"></td>
                                                    <td class="st-num"><input id="debit" name="debit[]" value="{{ $details->debit }}" type="text" class="form-control debit_input" onkeyup="updateTotals()" onkeypress="return onlyNumberKey(event)"></td>
                                                    <td class="st-num"><input id="credit" name="credit[]" value="{{ $details->credit }}" type="text" class="form-control credit_input" onkeyup="updateTotals()" onkeypress="return onlyNumberKey(event)"></td>
                                                    <td class="text-center"><button type="button" onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="btn btn-danger btn-sm">Delete</button></td>
                                                    @php
                                                        $TotalDebit = $TotalDebit + $details->debit;
                                                        $TotalCredit = $TotalCredit + $details->credit;
                                                    @endphp
                                                </tr>
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
                                                <span class="stat-label">Total Debit</span>
                                                <input type="text" class="form-control stat-value" value="{{ $TotalDebit }}" id="TotalDebit" name="TotalDebit" disabled>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label">Total Credit</span>
                                                <input type="text" class="form-control stat-value" value="{{ $TotalCredit }}" id="TotalCredit" name="TotalCredit" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <center>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm" id="btnSaves" name="btnSaves">Save</button>
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

        $(document).ready(function() {
            $("#account_type").select2();
            $("#account_head_id").select2();
            initSelect2($('#myData'));
        });

        function AddGridData() {
            var date = document.getElementById('date').value;
            var headId = document.getElementById('account_head_id').value.split("_")[0];
            var narration = document.getElementById('narration').value;
            var debit = document.getElementById('debit').value;
            var credit = document.getElementById('credit').value;
            var typeValue = $('#account_type').val();
            var accountTypeHtml = $('#account_type').html();
            var accountHeadHtml = $('#account_head_id').html();
            var headValue = $('#account_head_id').val();

            var tableHtml = '<tr class="st-data-row">';
            tableHtml += `<td style="display:none;"><input id="account_head_id" name="account_head_id[]" value="${headId}" type="text" class="form-control head_id_input"></td>`;
            tableHtml += `<td><input id="date" name="date[]" value="${date}" type="date" class="form-control date_input"></td>`;
            tableHtml += `<td><select name="account_type[]" class="form-control account_type_select">${accountTypeHtml}</select></td>`;
            tableHtml += `<td><select name="add_account_head_id[]" class="form-control account_head_select">${accountHeadHtml}</select></td>`;
            tableHtml += `<td><input id="narration" name="narration[]" value="${narration}" type="text" class="form-control narration_input"></td>`;
            tableHtml += `<td class="st-num"><input id="debit" name="debit[]" value="${debit}" type="text" class="form-control debit_input" onkeyup="updateTotals()"></td>`;
            tableHtml += `<td class="st-num"><input id="credit" name="credit[]" value="${credit}" type="text" class="form-control credit_input" onkeyup="updateTotals()"></td>`;
            tableHtml += `<td class="text-center"><button type="button" onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="btn btn-danger btn-sm">Delete</button></td>`;
            tableHtml += '</tr>';

            var $newRow = $(tableHtml);
            $('#myData').append($newRow);
            $newRow.find('.account_type_select').val(typeValue).select2();
            $newRow.find('.account_head_select').val(headValue).select2();
            updateTotals();
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
                        var str = '';
                        $.each(response, function(i, v) {
                            str += `<option value="${v.id+'_'+v.party_name}">${v.party_name}</option>`;
                        });
                        $('#account_head_id').html(str);
                    }
                    $('#account_head_id').val('').trigger('change');
                }
            });
        });
    </script>
@include('include.voucher-form-add-keys')
@stop
