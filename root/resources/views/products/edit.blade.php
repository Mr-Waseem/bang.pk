@extends("app")

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css"
        type="text/css" />
</head>
@section('contents')
    <h1 class="page-title">{{ !empty($isServiceTaxAuthority) ? 'Edit Service' : 'Edit Product' }}</h1>
    <!-- Breadcrumb -->
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
        <li><a href="{{ asset('products') }}">{{ !empty($isServiceTaxAuthority) ? 'Services' : 'Products' }}</a></li>
        <li class="active"><strong>{{ !empty($isServiceTaxAuthority) ? 'Edit Service' : 'Edit Product' }}</strong></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">{{ !empty($isServiceTaxAuthority) ? 'Edit Service (' . $systemType . ')' : 'Edit Product' }}</h3>
                </div>
                <div class="panel-body">
                    @include('errors.validation')
                    {!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\ProductController@update', $edit->id], 'class' => 'form-horizontal', 'id' => 'productsForm']) !!}
                    {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ !empty($isServiceTaxAuthority) ? 'Service Code' : 'H.S Code' }} <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            @if(!empty($isServiceTaxAuthority))
                                {!! Form::text('product_code', $edit->product_code, [
                                    'id' => 'product_code',
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Service Code',
                                    'required' => 'required',
                                    'onkeydown' => 'focusNext(event);',
                                ]) !!}
                            @else
                                {!! Form::select('product_code', $hscodes, null, ['id' => 'product_code', 'onchange' => 'hsCodeKeyUp($(this).val());',  'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                                <span class="help-block text-danger" style="color: red;">
                                HS CODE Format (2711.1910)
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ !empty($isServiceTaxAuthority) ? 'Service Name' : 'Product Name' }} <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            {!! Form::text('product_name', null, ['id' => 'product_name', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ !empty($isServiceTaxAuthority) ? 'Service UOM' : 'Product UOM' }} <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            {!! Form::hidden('uom_id', null, ['id' => 'uom_id', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            {!! Form::hidden('uom', null, ['id' => 'uom', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            {!! Form::select('uoms', $uoms, ($edit->uom_id ? $edit->uom_id . '_' . $edit->uom : null), ['id' => 'uoms', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);'] + (empty($isServiceTaxAuthority) ? ['disabled' => 'disabled'] : [])) !!}
                            <small id="uom-loading" class="text-muted" style="display: none;">{{ !empty($isServiceTaxAuthority) ? 'Service UOM loading...' : 'Product UOM loading...' }}</small>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label class="col-sm-3 control-label">Select Type</label>
                        <div class="col-sm-5">
                            {!! Form::select('type', ['Battery' => 'Battery', 'Koils' => 'Koils', 'Fixtures' => 'Fixtures', 'Lights' => 'Lights', 'Pole' => 'Pole'], null, ['id' => 'type', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label class="col-sm-3 control-label">Select Catagory</label>
                        <div class="col-sm-5">
                            {!! Form::select('catagory_id', $catagories, null, ['id' => 'catagory_id', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label">Pack Type</label>
                        <div class="col-sm-5">
                            {!! Form::select('pack_type', ['BAG' => 'BAG', 'DRUM' => 'DRUM', 'CANS' => 'CANS', 'BOTTLES' => 'BOTTLES', 'COTTON' => 'COTTON'], $edit->pack_type, ['id' => 'pack_type', 'class' => 'form-control']) !!}

                        </div>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label">Pack Weight</label>
                        <div class="col-sm-5">
                            {!! Form::text('pack_weight', null, ['id' => 'pack_weight', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Purchase Price</label>
                        <div class="col-sm-5">
                            {!! Form::text('product_cost', null, ['id' => 'product_cost', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Sale Price</label>
                        <div class="col-sm-5">
                            {!! Form::text('product_price', null, ['id' => 'product_price', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tax%<span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            {!! Form::select('tax', $tax, null, ['id' => 'tax', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label">Quanity Alert</label>
                        <div class="col-sm-5">
                            {!! Form::text('alert', 10, ['id' => 'alert', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label class="col-sm-3 control-label">Year</label>
                        <div class="col-sm-5">
                            {!! Form::text('year', null, ['id' => 'year', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="line-dashed"></div>
                    <center>
                        <div class="form-actions">
                            <button type="submit" onkeydown="submitForm();" class="btn btn-primary">Update {{ !empty($isServiceTaxAuthority) ? 'Service' : 'Product' }}</button>
                        </div>
                    </center>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        var idArray = ["product_code", "product_name", "uom", "catagory_id", "pack_type", "pack_weight", "product_cost",
            "product_price", "tax", "alert", "saveButton"
        ];

        const isServiceTaxAuthority = @json(!empty($isServiceTaxAuthority));

        function hsCodeKeyUp(hsCode) { 
            if (isServiceTaxAuthority) {
                return;
            }
            $('#uom-loading').show();
            $.ajax({
                type: "GET",
                url: "{{ asset('hscode-ajax') }}?hs_code=" + hsCode,
                success: function(result) {
                    if (result.length > 0) {
                        var option = `<option value="" selected>Select Uom</option>`;
                        $.each(result, function(i, v) {
                            option += `<option value="${v.uoM_ID}_${v.description}">${v.description}</option>`;
                        });
                        $('#uoms').select2('destroy');
                        $('#uoms').html(option).prop('disabled', false).val("");
                        $('#uoms').select2();
                        $('#uom_id').val('');
                        $('#uom').val('');
                    } else {
                        var option = `<option value="" selected>No UOM!</option>`;
                        $('#uoms').select2('destroy');
                        $('#uoms').html(option).prop('disabled', false).val("");
                        $('#uoms').select2();
                        $('#uom_id').val('');
                        $('#uom').val('');
                    }
                },
                complete: function() {
                    $('#uom-loading').hide();
                }
            });
        }
        function focusNext(e) {
            try {
                for (var i = 0; i < idArray.length; i++) {
                    if (e.keyCode === 13 && e.target.id === idArray[i]) {
                        document.querySelector(`#${idArray[i+1]}`).focus();
                    }
                }
            } catch (error) {}
        }


        $("#tax").select2();
        $("#tax").next(".select2").find(".select2-selection").focus(function() {
        $("#tax").select2("open");
        });
        
        $("#catagory_id").select2();
        $("#catagory_id").next(".select2").find(".select2-selection").focus(function() {
        $("#catagory_id").select2("open");
        });
        $("#uoms").select2();
        if (!isServiceTaxAuthority) {
            // Keep UOM dropdown disabled initially (showing saved value from DB)
            $("#uoms").prop('disabled', true).trigger('change');
        }
        if (!isServiceTaxAuthority) {
            $("#product_code").select2();
            $("#product_code").next(".select2").find(".select2-selection").focus(function() {
            $("#product_code").select2("open");
            });
        }
        $('#uoms').on('change', function() {
            var value = $(this).val() || '';
            var parts = value.split('_');
            if (parts.length >= 2) {
                $('#uom_id').val(parts[0]);
                $('#uom').val(parts.slice(1).join('_'));
            } else {
                $('#uom_id').val('');
                $('#uom').val('');
            }
        });
        $('#party_name').on('keydown', function(e) {
            if (e.keyCode === 13) {
                $("#account_show_id").select2();
                $("#account_show_id").next(".select2").find(".select2-selection").focus(function() {
                    $("#account_show_id").select2("open");
                });
            }
        });

        function submitForm() {
            $("#productsForm").submit();
        }
    </script>
    <script>

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
