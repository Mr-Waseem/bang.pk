@extends("app")

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css"
    type="text/css" />
</head>
@section('contents')
    <h1 class="page-title">{{ !empty($isServiceTaxAuthority) ? 'Add Service' : 'Add Product' }}</h1>
    <div id="ajax-loader" class="ajax-loader" aria-hidden="true">
        <div class="ajax-loader__spinner" role="status" aria-label="Loading"></div>
    </div>
    <div class="container-fluid">
    @if (Session::has('flash_message'))
        <div class="alert alert-success alert-dismissible show" role="alert" style="position: relative;">
            {{ Session::get('flash_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); padding: 0.5rem; line-height: 1; background: transparent; border: 0; font-size: 1.5rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>
    <!-- Breadcrumb -->
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
        <li><a href="{{ asset('products') }}">{{ !empty($isServiceTaxAuthority) ? 'Services' : 'Products' }}</a></li>
        <li class="active"><strong>{{ !empty($isServiceTaxAuthority) ? 'Add Service' : 'Add Product' }}</strong></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">{{ !empty($isServiceTaxAuthority) ? 'Add Service (' . $systemType . ')' : 'Add Product' }}</h3>
                </div>
                <div class="panel-body">
                    @include('errors.validation')
                    {!! Form::open(['url' => 'products', 'class' => 'form-horizontal', 'id' => 'productsForm']) !!}
                    {!! Form::hidden('has_recipe', 0, ['id' => 'has_recipe']) !!}
                    @if(session()->get('company_id'))
                    <!-- For Company -->
                    {!! Form::hidden('company_id',session()->get('company_id'),['id'=>'company_id']) !!}
                    @else
                    <!-- For admin -->
                    {!! Form::hidden('company_id',0,['id'=>'company_id']) !!}
                    @endif
					
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ !empty($isServiceTaxAuthority) ? 'Service Code' : 'H.S Code' }} <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            @if(!empty($isServiceTaxAuthority))
                                {!! Form::text('product_code', null, [
                                    'id' => 'product_code',
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Service Code',
                                    'required' => 'required',
                                    'autofocus' => 'autofocus',
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
                            {!! Form::text('product_name', null, ['id' => 'product_name', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ !empty($isServiceTaxAuthority) ? 'Service UOM' : 'Product UOM' }} <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            {!! Form::hidden('uom_id', null, ['id' => 'uom_id', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            {!! Form::hidden('uom', null, ['id' => 'uom', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            {!! Form::select('uoms', $uoms, null, ['id' => 'uoms', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);'] + (empty($isServiceTaxAuthority) ? ['disabled' => 'disabled'] : [])) !!}
                            <small id="uom-loading" class="text-muted" style="display: none;">{{ !empty($isServiceTaxAuthority) ? 'Service UOM loading...' : 'Product UOM loading...' }}</small>
                        </div>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label">Select Catagory</label>
                        <div class="col-sm-5">
                            {!! Form::select('catagory_id', $catagories, null, ['id' => 'catagory_id', 'onkeydown' => 'focusNext(event);', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label">Pack Type</label>
                        <div class="col-sm-5">
                            {!! Form::select('pack_type', ['BAG' => 'BAG', 'DRUM' => 'DRUM', 'CANS' => 'CANS', 'BOTTLES' => 'BOTTLES', 'COTTON' => 'COTTON'], null, ['id' => 'pack_type', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label">Pack Weight</label>
                        <div class="col-sm-5">
                            {!! Form::text('pack_weight', 50, ['id' => 'pack_weight', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Purchase Price</label>
                        <div class="col-sm-5">
                            {!! Form::text('product_cost', 0.0, ['id' => 'product_cost', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Sale Price</label>
                        <div class="col-sm-5">
                            {!! Form::text('product_price', 0.0, ['id' => 'product_price', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="col-sm-3 control-label">Tax% <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            {!! Form::text('tax', 18, ['id' => 'tax', 'class' => 'form-control','onkeypress' => 'return onlyNumberKey(event)', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tax%<span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            {!! Form::select('tax', $tax, null, ['id' => 'tax', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label">Quanity Alert</label>
                        <div class="col-sm-5">
                            {!! Form::text('alert', 10, ['id' => 'alert', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>

                    <div class="form-group" style="display:none;">
                        {!! Form::text('publisher_id', 1, ['id' => 'publisher_id', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        {!! Form::text('type', 'type', ['id' => 'type', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        <label class="col-sm-3 control-label">Year</label>
                        <div class="col-sm-5">
                            {!! Form::text('year', null, ['id' => 'year', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                        </div>
                    </div>
                    <div class="line-dashed"></div>
                    <center>
                        <div class="form-actions">
                            <button type="submit" id="saveButton" onkeydown="submitForm();" class="btn btn-primary">Save
                                {{ !empty($isServiceTaxAuthority) ? 'Service' : 'Product' }}</button>
                        </div>
                    </center>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')

<style>
    .ajax-loader {
        position: fixed;
        inset: 0;
        display: none;
        background: rgba(255, 255, 255, 0.6);
        z-index: 9999;
    }
    .ajax-loader.is-active {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .ajax-loader__spinner {
        width: 52px;
        height: 52px;
        border: 5px solid #e0e0e0;
        border-top-color: #2c7be5;
        border-radius: 50%;
        animation: ajax-spin 0.9s linear infinite;
    }
    @keyframes ajax-spin {
        to { transform: rotate(360deg); }
    }
</style>

<script>

</script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        var idArray = ["product_code", "product_name", "uom_id","uom", "catagory_id", "pack_type", "pack_weight", "product_cost",
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
                    // alert(result[0].description);
                    if (result.length > 0) {
                        document.getElementById('uoms').removeAttribute('disabled');
                        // $('#uom_id').val(result[0].uoM_ID).prop('readonly', true);
                        // $('#uom').val(result[0].description).prop('readonly', true);
                        var option = `<option value="" selected>Select Uom</option>`;
                            $.each(result, function(i, v) {
                                option +=
                                    `<option value="${v.uoM_ID}_${v.description}">${v.description}</option>`;
                                    // `<option value="${v.id}">${v.code} - ${v.product_name}</option>`;

                            });
                            $('#uoms').html(option).val("").trigger('change');
                            // $('#qty1').focus();
                    }
                    else{
                    var option = `<option value="" selected>No UOM!</option>`;
                    $('#uoms').html(option);
                    $('#uom_id').val("").removeAttr('readonly');
                    $('#uom').val("").removeAttr('readonly');
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

        
        $("#uoms").select2();
        $("#uoms").next(".select2").find(".select2-selection").focus(function() {
        $("#uoms").select2("open");
        });
        
        if (!isServiceTaxAuthority) {
            $("#product_code").select2();
            $("#product_code").next(".select2").find(".select2-selection").focus(function() {
            $("#product_code").select2("open");
            });
        }
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
