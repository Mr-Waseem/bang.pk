@extends("app")

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css"
    type="text/css" />
</head>
@section('contents')
    <h1 class="page-title">Add Product</h1>
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
        <li><a href="{{ asset('products') }}">Products</a></li>
        <li class="active"><strong>Add Product</strong></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Add Product</h3>
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
                        <label class="col-sm-3 control-label">Product Code <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            {{-- {!! Form::text('product_code1', $codes, ['id' => 'product_code1', 'class' => 'form-control', 'autofocus' => 'autofocus', 'disabled' => 'disabled']) !!} --}}
                            {!! Form::text('product_code', null, ['id' => 'product_code', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);', 
                              
                                'onkeyup' => 'hsCodeKeyUp1($(this).val());', 
                                'autofocus' => 'autofocus']) !!}
                            <span class="help-block text-danger" style="color: red;">
                            Define your own code, No need HS Code in case of POS
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Product Name <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            {!! Form::text('product_name', null, ['id' => 'product_name', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Product UOM <span style="color:red;">*</span></label>
                        <div class="col-sm-5">
                            {!! Form::hidden('uom_id', null, ['id' => 'uom_id', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            {!! Form::hidden('uom', null, ['id' => 'uom', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                            {!! Form::select('uoms', $uoms, null, ['id' => 'uoms', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
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
                                Product</button>
                        </div>
                    </center>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')

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

        function hsCodeKeyUp(hsCode) { 
            $.ajax({
                type: "GET",
                url: "{{ asset('hscode-ajax') }}?hs_code=" + hsCode,
                success: function(result) {
                    if (result.length > 0) {
                        var option = `<option selected>Select Uom</option>`;
                            $.each(result, function(i, v) {
                                option +=`<option value="${v.uoM_ID}_${v.description}">${v.description}</option>`;
                            });
                            $('#uoms').html(option);
                    }
                    else{
                    $('#uom_id').val("").removeAttr('readonly');
                    $('#uom').val("").removeAttr('readonly');
                }
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
        
        $("#catagory_id").select2();
        $("#catagory_id").next(".select2").find(".select2-selection").focus(function() {
        $("#catagory_id").select2("open");
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
