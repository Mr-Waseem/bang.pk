@extends("app")

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{Asset('css/select2.min.css')}}" rel="stylesheet" />
</head>
@section('contents')
    <body>
        <style>
            .col-md-1 {
    width: 7.9%;
}
        </style>
        {{-- <div class="container-fluid">
            @if (Session::has('flash_message'))
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                    style="margin-right: 20px;margin-top: 15px;">&times;</button>
                <div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
            @endif
            @if (Session::has('error_message'))
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                    style="margin-right: 20px;margin-top: 15px;">&times;</button>
                <div class="alert alert-danger"> {{ Session::get('error_message') }} </div>
            @endif
        </div> --}}
        @if(Session::has('error'))
        <div class="alert alert-danger">
            <strong>Error!</strong> {{ Session::get('error') }}
            @if(Session::has('error_details'))
            <br>Details: {{ Session::get('error_details') }}
            @endif
            @if(Session::has('error_code'))
            <br>Code: {{ Session::get('error_code') }}
            @endif
        </div>
        @endif
        <div class="container-fluid">
            @if (Session::has('flash_message'))
                <div class="alert alert-success alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"
                        style="margin-right: 4%;">&times;</a>
                    <strong>Success!</strong> {{ Session::get('flash_message') }}
                </div>
            @endif
            @if (Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"
                        style="margin-right: 4%;">&times;</a>
                    <strong>Success!</strong> {{ Session::get('error_message') }}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix" id="panelbg">
                        <h2 class="panel-title"><b>Credit Note</b></h2>
                    </div>
                    <div class="panel-body">
                        <input id="token" type="hidden" value="{{ $encrypted_token }}">
                        @include('errors.validation')
                        {!! Form::open(['url' => 'credit-note', 'class' => 'form-horizontal']) !!}
                        <div class="row">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Date</label>
                                <div class="col-sm-2">
                                    
                                        <input id="date" type="date" name="date" class="form-control"
                                          value="<?php echo date('Y-m-d'); ?>" autofocus>
                                    
                                </div>
                                <div class="col-sm-3">
                                </div>
                                <label class="col-sm-1 control-label">Vr#</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        {!! Form::text('invoice_no1', $codes, [
                                            'id' => 'invoice_no1',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled',
                                        ]) !!}
                                        {!! Form::hidden('invoice_no', $codes, ['id' => 'invoice_no', 'class' => 'form-control']) !!}

                                    </div>
                                </div>
                                <!-- <label class="col-sm-1 control-label">ST Inv#</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        {!! Form::text('ref_usin', null, ['id' => 'ref_usin','data-index' => '1','onkeypress' => 'return onlyNumberKey(event)', 'class' => 'form-control']) !!}
                                        {!! Form::hidden('invoice_no', $codes, ['id' => 'invoice_no', 'class' => 'form-control']) !!}
                                    
                                    </div>
                                </div> -->
                              
                                <label class="col-sm-1 control-label" style="display:none;">Sale&nbsp;Type</label>
                                <div class="col-sm-2">
                                    <select style="display:none;" class="form-control" onchange="LedgerValues();"
                                        id="sale_type" name="sale_type">
                                        <option style="display:none;" value="Credit Note">SalesTax Invoice</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                            <label class="col-sm-1 control-label">Scenario</label>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                    {!! Form::select('scenario_id', $scenarios, null, ['id' => 'scenario_id', 'class' => 'form-control', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                </div>
                                <label class="col-sm-1 control-label">FBR Inv#</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        {!! Form::text('ref_usin', null, ['id' => 'ref_usin','data-index' => '1','onkeypress' => 'return onlyNumberKey(event)', 'class' => 'form-control']) !!}
                                        {!! Form::hidden('invoice_no', $codes, ['id' => 'invoice_no', 'class' => 'form-control']) !!}
                                    
                                    </div>
                                </div>
                                
                               
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">

                                <label style="display:none;" class="col-sm-1 control-label">OutWard&nbsp;No</label>
                                <div class="col-sm-2" style="display:none;">
                                    {!! Form::text('dcn_no', null, ['id' => 'dcn_no', 'class' => 'form-control']) !!}
                                </div>
                                <label style="display:none;" class="col-sm-1 control-label">P&nbsp;Order</label>
                                <div class="col-sm-2" style="display:none;">
                                    <div id="year-view" class="input-group date">
                                        {!! Form::text('p_order', null, ['id' => 'p_order', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Select&nbsp;Party</label>
                                {!! Form::hidden('party_id', null, ['id' => 'party_id', 'class' => 'form-control']) !!}
                                <div class="col-sm-3">
                                        {!! Form::select('party_name', $customers, null, [
                                            'id' => 'party_name',
                                            'onchange' => 'javascript:PartyKeyUp($(this).val());',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                        ]) !!}
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::text('address', null, [
                                        'id' => 'address',
                                        'class' => 'form-control',
                                        'placeholder' => 'Address',
                                        'disabled' => 'disabled',
                                    ]) !!}
                                </div>
                                <div class="col-sm-2">
                                    {!! Form::text('ntn', null, [
                                        'id' => 'ntn',
                                        'class' => 'form-control',
                                        'placeholder' => 'NTN',
                                        'disabled' => 'disabled',
                                    ]) !!}
                                </div>

                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <table id="myTable">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <tr>
                                                    {!! Form::hidden('product_id', null, ['id' => 'product_id', 'class' => 'form-control']) !!}
                                                    {!! Form::hidden('invoice_no', $codes, ['id' => 'invoice_no', 'class' => 'form-control']) !!}
                                                    {!! Form::hidden('sale_type1', 'Credit Note', ['id' => 'sale_type1', 'class' => 'form-control']) !!}
                                                   
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-left: 1%; margin-right: 1%;">
                                                            <label for="H.S" class="control-label">H.S Code</label>
                                                            {!! Form::text('product_code', null, [
                                                                'id' => 'product_code',
                                                                'data-index' => '3',
                                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group"
                                                            style="margin-left: 1%; margin-right: 1%;">
                                                            <label for="Name" class="control-label">
                                                                Product Name</label>
                                                            {!! Form::select('product_name', $products, null, [
                                                                'id' => 'product_name',
                                                                'data-index' => '4',
                                                                'onchange' => 'ProductKeyUp($(this).val())',
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                            {{-- {!! Form::select('product_name', $products, null, ['id' => 'product_name', 'onchange' => 'ProductKeyUp($(this).val().split("_").pop(), $(this).val().split("_")[0]);', 'class' => 'form-control']) !!}  --}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-left: 1%; margin-right: 1%;">
                                                            <label for="Name" class="control-label">Unit</label>
                                                            {{-- {!! Form::select('uom_id', $uoms, null, ['id' => 'uom_id','onkeyup' => 'UomKeyUp($(this).val())', 'class' => 'form-control']) !!} --}}
                                                            {!! Form::text('uom_id', null, ['id' => 'uom_id', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group" style="margin-right: 1%;margin-left: 1%;">
                                                            <label for="password" class="control-label">Quantity</label>
                                                            {!! Form::text('quantity', null, [
                                                                'id' => 'quantity',
                                                                'data-index' => '5',
                                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                                'onkeyup' => 'QuantityKeyUp($(this).val())',
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1%;width: 100%;margin-left: 1%;">
                                                            <label for="password" class="control-label">Price</label>
                                                            {!! Form::text('price_per_unit', null, [
                                                                'id' => 'price_per_unit',
                                                                'data-index' => '6',
                                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                                'onkeyup' => 'SaleRateKeyUpForm($(this).val())',
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1%;width: 100%;margin-left: 1%;">
                                                            <label for="password" class="control-label">S.T%</label>
                                                            {!! Form::text('stvalue', null, ['id' => 'stvalue', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1%;width: 100%;margin-left: 1%;">
                                                            <label for="password" class="control-label">Tax Value</label>
                                                            {!! Form::text('taxvalue', null, ['id' => 'taxvalue', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1px; margin-left: 1px;">
                                                            <label for="password" class="control-label">Extra%</label>
                                                            {!! Form::text('extratax', null, [
                                                                'id' => 'extratax',
                                                                'data-index' => '7',
                                                                'onkeyup' => 'ExtraTaxkeyup($(this).val());',
                                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1px; margin-left: 1px;">
                                                            <label for="password" class="control-label">ExtraVal</label>
                                                            {!! Form::text('extraTaxValue1', null, [
                                                                'id' => 'extraTaxValue1',
                                                                // 'data-index' => '8',
                                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                                // 'onkeyup' => 'AddGridData()',
                                                                'class' => 'form-control',
                                                                'disabled'=>'disabled'
                                                            ]) !!}
                                                            {!! Form::hidden('extraTaxValue', null, [
                                                                'id' => 'extraTaxValue',
                                                                // 'data-index' => '8',
                                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                                // 'onkeyup' => 'AddGridData()',
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1px; margin-left: 1px;">
                                                            <label for="password" class="control-label">Val ExTax</label>
                                                            {!! Form::text('ValueExTax', null, ['id' => 'ValueExTax', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1px; margin-left: 1px;">
                                                            <label for="password" class="control-label">IncTax</label>
                                                            {!! Form::text('amount', null, ['id' => 'amount', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <button style="margin-top:25px;" class="btn btn-primary" type="button" onkeyup  = 'AddGridData()' onclick='AddGridDataClick()' data-index=8> <i
                                                            class="icon-plus"
                                                           title="Add Row"></i></button>
                                                    </div>
                                                    </div>
                                                    {{-- <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1px; margin-left: 1px;">
                                                            <label for="password" class="control-label">Delete</label>
                                                            {!! Form::text('amount', null, ['id' => 'amount', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                        </div>
                                                    </div> --}}
                                                </tr>
                                                <table id="myData">
                                                </table>
                                            </div>
                                            <div class="row">
                                                <tr>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                        </div>
                                                    </div>
                                                </tr>
                                            </div>
                                        </div>
                                    </table><br><br>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading clearfix">

                                    <div class="container">

                                    <div class="col-xs-2" style="display:none;"><label class="radio-inline"
                                            style=""><input type="checkbox" name="autocash" id="autocash"
                                                value="yes">Auto&nbsp;Cash</label> </div>
                                    <div class="col-xs-2" style=""><b>Total Qty</b> <input type="text"
                                            value="0" id="TotalRate" name="TotalRate" disabled> </div>
                                    <div class="col-xs-2" style=""><b>Total Tax</b> <input type="text"
                                            value="0" id="TotalTax1" name="TotalTax1" disabled> </div>
                                    <div class="col-xs-2" style=""> <b>Value Ex.Tax</b> <input
                                            type="text" value="0" id="TotalExTax" name="TotalExTax"
                                            disabled> </div>
                                    <div class="col-xs-2"> <b>Value Inc.Tax</b> <input type="text"
                                            value="0" id="TotalAmount" name="TotalAmount" disabled> </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <center>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" id="btnSave"
                                    name="btnSave">Save</button>
                            </div>
                        </center>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
@section('scripts')
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Select2-->
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script>

$(document).ready(function() {
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    // alert("working");
                    event.preventDefault();
                    var $this = $(event.target);
                    var index = parseFloat($this.attr('data-index'));
                    // alert(index);
                    $('[data-index="' + (index + 1).toString() + '"]').focus();
                    return false;
                    // $("#price").focus();
                }
            });
        });




        $(document).ready(function() {
            $("#party_name").select2();
            $("#party_name").next(".select2").find(".select2-selection").focus(function() {
                $("#party_name").select2("open");
            });
            // $("#party_name").on("focus", function() {
            //     $(document).ready(function() {
            //         $(window).keydown(function(event) {
            //             if (event.keyCode == 13) {
            //                 event.preventDefault();
            //                 var $this = $(event.target);
            //                 var index = parseFloat($this.attr('data-index'));
            //                 // alert('inside');
            //                 $("#product_code").focus();
            //                 $('[data-index="' + (index + 1).toString() + '"]').focus();
            //                 return false;
            //             }
            //         });
            //     });
            //     $("#party_name").select2("open")
            //     //  event.preventDefault();
            // });
        });
        $(document).ready(function() {

            $("#product_name").select2();
            $("#product_name").next(".select2").find(".select2-selection").focus(function() {
                $("#product_name").select2("open");
            });

            $("#scenario_id").select2();
            $("#scenario_id").next(".select2").find(".select2-selection").focus(function() {
            $("#scenario_id").select2("open");
            });

            // $("#product_name").on("focus", function() {
            //     $(document).ready(function() {
            //         $(window).keydown(function(event) {
            //             if (event.keyCode == 13) {

            //                 event.preventDefault();
            //                 var $this = $(event.target);
            //                 var index = parseFloat($this.attr('data-index'));
            //                 // alert('inside');
            //                 $("#quantity").focus();
            //                 $('[data-index="' + (index + 1).toString() + '"]').focus();
            //                 return false;
            //             }
            //         });
            //     });
            //     $("#product_name").select2("open");
            // });
        });

        // function onlyNumberKey(evt) {

        //     // Only ASCII character in that range allowed
        //     var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        //     if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        //         return false;
        //     return true;
        // }
        function onlyNumberKey(evt) { 
              // Only ASCII character in that range allowed 
              var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
          }
    </script>


    <script type="text/javascript">
        function FurtherTaxes() {
            var checkbox = document.getElementById('FurtherTax');
            if (checkbox.checked = true) {
                document.getElementById('extratax').value = 3;
            }
        }

        function AddGridData() {
            var date = document.getElementById('date').value;
            var InvoiceNo = document.getElementById('invoice_no').value;
            var Party = document.getElementById('party_name').value;
            var ProductId = document.getElementById('product_id').value;
            var ProductCode = document.getElementById('product_code').value;
            var ProductID = document.getElementById('product_name').value.split("_")[0];
            var ProductName = document.getElementById('product_name').value.split("_")[2];
            
            // var ProductName = document.getElementById('product_name').value.split("_").pop();
            var UOM = document.getElementById('uom_id').value.split("_").pop();
            var UOMID = document.getElementById('uom_id').value.split("_")[0];
            var Quantity = document.getElementById('quantity').value;
            var Price = document.getElementById('price_per_unit').value;
            var STValue = document.getElementById('stvalue').value;
            var TaxValue = document.getElementById('taxvalue').value;
            var ExtraTax = document.getElementById('extratax').value;
            var ExtraTaxValue = document.getElementById('extraTaxValue').value;
            var ValueExTax = document.getElementById('ValueExTax').value;
            var Amount = document.getElementById('amount').value;
            var TotalTax = parseInt(TaxValue) + parseInt(ExtraTaxValue);
            
            // document.getElementById('extraTaxValue1').value  =ExtraTaxValue;
            var TotalRate = document.getElementById('TotalRate').value;
           
            var TotalTax = document.getElementById('TotalTax1').value;
            var TotalExTax = document.getElementById('TotalExTax').value;
            var TotalAmount = document.getElementById('TotalAmount').value;
            // alert(Party);
            //    alert(Party);
            if(Party==0){
                // alert("Product Not Selected.");
                $("#party_name").focus();
               $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {

                            event.preventDefault();
                            var $this = $(event.target);
                            var index = parseFloat($this.attr('data-index'));
                            // alert('inside');
                            $("#product_code").focus();
                            $('[data-index="' + (index + 1).toString() + '"]').focus();
                            return false;
                        }
                    });
                });
            }
          else if(ProductID==0)
            {
                // alert("Product Not Selected.");
               $("#product_name").focus();
               $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {

                            event.preventDefault();
                            var $this = $(event.target);
                            var index = parseFloat($this.attr('data-index'));
                            // alert('inside');
                            $("#quantity").focus();
                            $('[data-index="' + (index + 1).toString() + '"]').focus();
                            return false;
                        }
                    });
                });
            }
           else if(Quantity==0)
            {
                // alert("Quantity Cannot Be Zero.");
               $("#quantity").focus();
            }
           else if(Price==0)
            {
                // alert("Price Cannot Be Zero.");
               $("#price_per_unit").focus();
            }
            else
            {

            // var totalPrice = parseInt(TotalRate) + parseInt(Price);
            // var TotalTaxAmount = parseInt(TotalTax) + parseInt(TaxValue);
            // var TotalExTaxAmount = parseInt(TotalExTax) + parseInt(ValueExTax);
            // var TotalincTaxAmount = parseInt(TotalAmount) + parseInt(Amount);
        
            // document.getElementById('TotalRate').value = totalPrice;
            // document.getElementById('TotalTax').value = TotalTaxAmount;
            // document.getElementById('TotalExTax').value = TotalExTaxAmount;
            // document.getElementById('TotalAmount').value = TotalincTaxAmount;
            
           var divhtml = '<table>';
            var tableHtml = '<tr >';
            // tableHtml += '<td class="text-center"><i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-cancel icon-larger red-color" title="Delete Row"></i> </td>';
            //tableHtml += '<td>'+ ProductId +'</td>';
            //0
            tableHtml +=
                `<td style="display:none;">
                    <input id="test" value="${ProductId}" type="text" class="form-control" disabled>
                    <input id="product_id1" name="product_id1[]" value="${ProductId}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ ProductCode +'</td>';
            //1
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ProductCode}" type="text" class="form-control" style="margin-left: 15%; width: 62%;" disabled>
                    <input id="product_code" name="product_code[]" value="${ProductCode}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ ProductName +'</td>';
            //2
            tableHtml +=
                `<td style="display:none;">
                    <input id="test" value="${ProductID}" type="text" class="form-control" disabled>
                </td>`;
            //3
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ProductName}" type="text" class="form-control" style="margin-left: 5%; width: 160%;" disabled>
                    <input id="product_name" value="${ProductName}" name="product_name[]" type="hidden" >
                </td>`;
            //tableHtml += '<td>'+ PackingType +'</td>';
            //tableHtml += '<td>'+ UOM +'</td>';
            //4
            tableHtml +=
                `<td style="display:none;">
                    <input id="test" value="${UOMID}" type="text" class="form-control" disabled>
                    <input id="uom_id" name="uom_id[]" value="${UOMID}" type="hidden">
                </td>`;
            //5
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${UOM}" type="text" class="form-control" style="margin-left: 98%; width: 62%;" disabled>
                </td>`;
            //tableHtml += '<td>'+ Quantity +'</td>';
            //6
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="quantityy" value="${Quantity}" type="text" class="form-control" style="margin-left: 89%;width: 62%;" onkeyup="salequantity($(this).val(), $(this).closest('tr').index());">
                    <input id="quantity" name="quantity[]" value="${Quantity}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ Price +'</td>';
            //7
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="ratee" value="${Price}" type="text" class="form-control" style="margin-left:80%; width: 65%;" onkeyup="salerate($(this).val(), $(this).closest('tr').index());">
                    <input id="rate" name="rate[]" value="${Price}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ STValue +'</td>';
            //8
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${STValue}" type="text" class="form-control" style="margin-left:72%; width: 62%;" disabled>
                    <input id="stvalue" name="stvalue[]" value="${STValue}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ TaxValue +'</td>';
            //9
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${TaxValue}" type="text" class="form-control" style="margin-left:63%; width: 65%;" disabled>
                    <input id="taxvalue" name="taxvalue[]" value="${TaxValue}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ ExtraTax +'</td>';
            //10
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ExtraTax}" type="text" class="form-control" style="margin-left:55%; width: 62%;" disabled>
                    <input id="extratax" name="extratax[]" value="${ExtraTax}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ ExtraTaxValue +'</td>';
            //11
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ExtraTaxValue}" type="text" class="form-control" style="margin-left:46%; width: 62%;" disabled>
                    <input id="extraTaxValue" name="extraTaxValue[]" value="${ExtraTaxValue}" type="hidden">
                </td>`;
            //12
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ValueExTax}" type="text" class="form-control" style="margin-left:37%; width: 62%;" disabled>
                    <input id="excvalue" name="excvalue[]" value="${ValueExTax}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ Amount +'</td>';
            //13
            tableHtml +=
                `<td style="padding-top:2px;">
                    <input id="test" value="${Amount}" type="text" class="form-control" style="margin-left:28%; width:62%" disabled>
                    <input id="incvalue" name="incvalue[]" value="${Amount}" type="hidden">    
                </td>`;
            //14
            tableHtml +=
                `<td style="display:none;">
                    <input id="test" value="${TotalTax}" type="text" class="form-control" style="margin-left:21%; width: 65%;" disabled>
                    <input id="TotalTax" name="TotalTax[]" value="${TotalTax}" type="hidden">      
                </td>`;
            //15
            tableHtml +=
                `<td style="padding-right:10px;padding-left:10px;">
                    <button class="btn btn-red" id="test" type="button" style="padding-top:22%;padding-bottom:12%; width: 100%;" onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));"> <i
                     class="icon-trash"
                    title="Delete Row" style="margin-bottom:3px;"></i></button>      
                </td>`;
            tableHtml += '</tr>';
            divhtml += '</table>';
            $('#myData').append(tableHtml);
            // document.getElementById("product_code").focus();
            $('#product_name').select2('open');
            TotalQty1();
            TotalTax1();
            TotalExTax1();
            TotalGrandAmount();
            
        }
        }

        function TotalQty1() {
            var tableData = document.getElementById('myData');
            var sum = 0;
            for (var i = 0; i < tableData.rows.length; i++) {
                if (tableData.rows[i].cells[6].getElementsByTagName('input')[0].value == '') {
                    sum += 0;
                } else {
                    sum += parseFloat(tableData.rows[i].cells[6].getElementsByTagName('input')[0].value);
                }   
            }
            document.getElementById('TotalRate').value = sum.toLocaleString('en-US');
        }

        function TotalTax1() {
            var tableData = document.getElementById('myData');
            var sum = 0;
            for (var i = 0; i < tableData.rows.length; i++) {
                if (tableData.rows[i].cells[9].getElementsByTagName('input')[0].value == '') {
                    sum += 0;
                } else {
                    sum += parseFloat(tableData.rows[i].cells[9].getElementsByTagName('input')[0].value);
                }   
            }
            document.getElementById('TotalTax1').value = sum.toLocaleString('en-US');
        }

        function TotalExTax1() {
            var tableData = document.getElementById('myData');
            var sum = 0;
            for (var i = 0; i < tableData.rows.length; i++) {
                // alert(34);
                if (tableData.rows[i].cells[12].getElementsByTagName('input')[0].value == '') {
                    sum += 0;
                } else {
                    sum += parseFloat(tableData.rows[i].cells[12].getElementsByTagName('input')[0].value);
                    // alert(sum);
                }   
            }
            document.getElementById('TotalExTax').value = sum.toLocaleString('en-US');
        }

        function TotalGrandAmount() {
            var tableData = document.getElementById('myData');
            var sum = 0;
            for (var i = 0; i < tableData.rows.length; i++) {
                // alert(34);
                if (tableData.rows[i].cells[13].getElementsByTagName('input')[0].value == '') {
                    sum += 0;
                } else {
                    sum += parseFloat(tableData.rows[i].cells[13].getElementsByTagName('input')[0].value);
                    // alert(sum);
                }   
            }
            document.getElementById('TotalAmount').value = sum.toLocaleString('en-US');
        }
        function AddGridDataClick() {
            var date = document.getElementById('date').value;
            var InvoiceNo = document.getElementById('invoice_no').value;
            var Party = document.getElementById('party_name').value;
            var ProductId = document.getElementById('product_id').value;
            var ProductCode = document.getElementById('product_code').value;
            var ProductID = document.getElementById('product_name').value.split("_")[0];
            var ProductName = document.getElementById('product_name').value.split("_")[2];
            // var ProductName = document.getElementById('product_name').value.split("_").pop();
            var UOM = document.getElementById('uom_id').value.split("_").pop();
            var UOMID = document.getElementById('uom_id').value.split("_")[0];
            var Quantity = document.getElementById('quantity').value;
            var Price = document.getElementById('price_per_unit').value;
            var STValue = document.getElementById('stvalue').value;
            var TaxValue = document.getElementById('taxvalue').value;
            var ExtraTax = document.getElementById('extratax').value;
            var ExtraTaxValue = document.getElementById('extraTaxValue').value;
            var ValueExTax = document.getElementById('ValueExTax').value;
            var Amount = document.getElementById('amount').value;
            var TotalTax = parseInt(TaxValue) + parseInt(ExtraTaxValue);

          
            // document.getElementById('extraTaxValue1').value  =ExtraTaxValue;
          
          
          
          
            var TotalRate = document.getElementById('TotalRate').value;
            var TotalTax = document.getElementById('TotalTax1').value;
            var TotalExTax = document.getElementById('TotalExTax').value;
            var TotalAmount = document.getElementById('TotalAmount').value;
            //    alert(Party);
            if(Party==0){
                // alert("Product Not Selected.");
                $("#party_name").focus();
               $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {

                            event.preventDefault();
                            var $this = $(event.target);
                            var index = parseFloat($this.attr('data-index'));
                            // alert('inside');
                            $("#product_code").focus();
                            $('[data-index="' + (index + 1).toString() + '"]').focus();
                            return false;
                        }
                    });
                });
            }
          else if(ProductID==0)
            {
                // alert("Product Not Selected.");
               $("#product_name").focus();
               $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {

                            event.preventDefault();
                            var $this = $(event.target);
                            var index = parseFloat($this.attr('data-index'));
                            // alert('inside');
                            $("#quantity").focus();
                            $('[data-index="' + (index + 1).toString() + '"]').focus();
                            return false;
                        }
                    });
                });
            }
           else if(Quantity==0)
            {
                // alert("Quantity Cannot Be Zero.");
               $("#quantity").focus();
            }
           else if(Price==0)
            {
                // alert("Price Cannot Be Zero.");
               $("#price_per_unit").focus();
            }
            else
            {

                
            // var totalPrice = parseInt(TotalRate) + parseInt(Price);
            // var TotalTaxAmount = parseInt(TotalTax) + parseInt(TaxValue);
            // var TotalExTaxAmount = parseInt(TotalExTax) + parseInt(ValueExTax);
            // var TotalincTaxAmount = parseInt(TotalAmount) + parseInt(Amount);
            

            // document.getElementById('TotalRate').value = totalPrice;
            // document.getElementById('TotalTax1').value = TotalTaxAmount;
            // document.getElementById('TotalExTax').value = TotalExTaxAmount;
            // document.getElementById('TotalAmount').value = TotalincTaxAmount;
          
          
           
           var divhtml = '<table>';
            var tableHtml = '<tr >';
            // tableHtml += '<td class="text-center"><i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-cancel icon-larger red-color" title="Delete Row"></i> </td>';
            //tableHtml += '<td>'+ ProductId +'</td>';
            //0
            tableHtml +=
                `<td style="display:none;">
                    <input id="test" value="${ProductId}" type="text" class="form-control" disabled>
                    <input id="product_id1" name="product_id1[]" value="${ProductId}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ ProductCode +'</td>';
            //1
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ProductCode}" type="text" class="form-control" style="margin-left: 15%; width: 62%;" disabled>
                    <input id="product_code" name="product_code[]" value="${ProductCode}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ ProductName +'</td>';
            //2
            tableHtml +=
                `<td style="display:none;">
                    <input id="test" value="${ProductID}" type="text" class="form-control" disabled>
                </td>`;
            //3
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ProductName}" type="text" class="form-control" style="margin-left: 5%; width: 160%;" disabled>
                    <input id="product_name" value="${ProductName}" name="product_name[]" type="hidden" >
                </td>`;
            //tableHtml += '<td>'+ PackingType +'</td>';
            //tableHtml += '<td>'+ UOM +'</td>';
            //4
            tableHtml +=
                `<td style="display:none;">
                    <input id="test" value="${UOMID}" type="text" class="form-control" disabled>
                    <input id="uom_id" name="uom_id[]" value="${UOMID}" type="hidden">
                </td>`;
            //5
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${UOM}" type="text" class="form-control" style="margin-left: 98%; width: 62%;" disabled>
                </td>`;
            //tableHtml += '<td>'+ Quantity +'</td>';
            //6
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="quantityy" value="${Quantity}" type="text" class="form-control" style="margin-left: 89%;width: 62%;" onkeyup="salequantity($(this).val(), $(this).closest('tr').index());">
                    <input id="quantity" name="quantity[]" value="${Quantity}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ Price +'</td>';
            //7
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="ratee" value="${Price}" type="text" class="form-control" style="margin-left:80%; width: 65%;" onkeyup="salerate($(this).val(), $(this).closest('tr').index());">
                    <input id="rate" name="rate[]" value="${Price}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ STValue +'</td>';
            //8
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${STValue}" type="text" class="form-control" style="margin-left:72%; width: 62%;" disabled>
                    <input id="stvalue" name="stvalue[]" value="${STValue}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ TaxValue +'</td>';
            //9
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${TaxValue}" type="text" class="form-control" style="margin-left:63%; width: 65%;" disabled>
                    <input id="taxvalue" name="taxvalue[]" value="${TaxValue}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ ExtraTax +'</td>';
            //10
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ExtraTax}" type="text" class="form-control" style="margin-left:55%; width: 62%;" disabled>
                    <input id="extratax" name="extratax[]" value="${ExtraTax}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ ExtraTaxValue +'</td>';
            //11
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ExtraTaxValue}" type="text" class="form-control" style="margin-left:46%; width: 62%;" disabled>
                    <input id="extraTaxValue" name="extraTaxValue[]" value="${ExtraTaxValue}" type="hidden">
                </td>`;
            //12
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ValueExTax}" type="text" class="form-control" style="margin-left:37%; width: 62%;" disabled>
                    <input id="excvalue" name="excvalue[]" value="${ValueExTax}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ Amount +'</td>';
            //13
            tableHtml +=
                `<td style="padding-top:2px;">
                    <input id="test" value="${Amount}" type="text" class="form-control" style="margin-left:28%; width:62%" disabled>
                    <input id="incvalue" name="incvalue[]" value="${Amount}" type="hidden">    
                </td>`;
            //14
            tableHtml +=
                `<td style="display:none;">
                    <input id="test" value="${TotalTax}" type="text" class="form-control" style="margin-left:21%; width: 65%;" disabled>
                    <input id="TotalTax" name="TotalTax[]" value="${TotalTax}" type="hidden">      
                </td>`;
            //15
            tableHtml +=
                `<td style="padding-right:10px;padding-left:10px;">
                    <button class="btn btn-red" id="test" type="button" style="padding-top:22%;padding-bottom:12%; width: 100%;" onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));"> <i
                     class="icon-trash"
                    title="Delete Row" style="margin-bottom:3px;"></i></button>      
                </td>`;
            tableHtml += '</tr>';
            divhtml += '</table>';
            $('#myData').append(tableHtml);
            // document.getElementById("product_code").focus();
            $('#product_name').select2('open');
            TotalQty1();
            TotalTax1();
            TotalExTax1();
            TotalGrandAmount();
        }
        }
        function salequantity(quantity, RowIndex) {
            console.log(quantity);
            
            var rate = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('7')").find('input').val();
            var tax = ((($('tr:eq(' + RowIndex + ')', myData).find("td:eq('8')").find('input').val())*rate)/100)*quantity;
            // var tax =( $('tr:eq(' + RowIndex + ')', myData).find("td:eq('9')").find('input').val())/(qty);
            var totalrate = quantity *rate;
            var totalinctax = parseFloat(totalrate)+parseFloat(tax);
            // alert(RowIndex);
            // alertify.confirm(totalinctax);
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('9')").find('input').val(tax);
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('12')").find('input').val(totalrate);
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('13')").find('input').val(totalinctax);
            $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {

                            event.preventDefault();
                            var $this = $(event.target);
                            var index = parseFloat($this.attr('data-index'));
                            // alert('inside');
                            $("#ratee").focus();
                            $('[data-index="' + (index + 1).toString() + '"]').focus();
                            return false;
                        }
                    });
                });
        }
        function salerate(rate, RowIndex) {
            
            var qty = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('6')").find('input').val();
            var tax = ((($('tr:eq(' + RowIndex + ')', myData).find("td:eq('8')").find('input').val())*rate)/100)*qty;
            // var tax =( $('tr:eq(' + RowIndex + ')', myData).find("td:eq('9')").find('input').val())/(qty);
            var totalrate = qty *rate;
            var totalinctax = parseFloat(totalrate)+parseFloat(tax);
            // console.log(totalinctax);
            // alertify.confirm(totalinctax);
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('9')").find('input').val(tax);
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('12')").find('input').val(totalrate);
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('13')").find('input').val(totalinctax);
            $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {

                            event.preventDefault();
                            var $this = $(event.target);
                            var index = parseFloat($this.attr('data-index'));
                            // alert('inside');
                            $("#product_code").focus();
                            $('[data-index="' + (index + 1).toString() + '"]').focus();
                            return false;
                        }
                    });
                });
        }
        

       
        function LedgerValues() {
            $value = $("#sale_type").val();
            if ($value == "Cash Sale") {
                $('#ledgerRow').hide();
            }
            if ($value == "Credit Sale") {
                $('#ledgerRow').show();
            }
        }

        function TotalRecords() {
            var rowCount = document.getElementById('myTable').rows.length;
            alert("Total Number of Records Are: " + rowCount);
        }

        function DCMouseUp(value) {
            $.ajax({
                type: "GET",
                url: "{{ asset('dcmouseup-ajax') }}?dc_no=" + value,
                success: function(data) {
                    if (data.length > 0) {

                        var partyID = data[0].party_id;
                        var partyName = data[0].party_name;
                        var partyAddress = data[0].address;
                        var partyNTN = data[0].ntn;
                        document.getElementById("party_id").value = partyID;
                        document.getElementById("party_name").value = partyName;
                        document.getElementById("address").value = partyAddress;
                        document.getElementById("ntn").value = partyNTN;

                        $.each(data, function(key, value) {
                            var newRow =
                                '<tr>' +
                                '<td style="display:none;"><input id="test" value="${ProductId}" type="text" class="form-control" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${ProductCode}" type="text" class="form-control" style="margin-left: 14%; width: 65%;" disabled></td>' +

                                '<td style="padding-top:20px;"><input id="test" value="${ProductName}" type="text" class="form-control" style="margin-left: 7%; width: 153%;" disabled></td>' +
                                '<td style="display:none;"><input id="test" value="${UOMID}" type="text" class="form-control" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${UOM}" type="text" class="form-control" style="margin-left: 88%; width: 65%;" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${Quantity}" type="text" class="form-control" style="    margin-left: 80%;width: 65%;" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${Price}" type="text" class="form-control" style="margin-left:72%; width: 65%;" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${STValue}" type="text" class="form-control" style="margin-left:64%; width: 65%;" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${TaxValue}" type="text" class="form-control" style="margin-left:56%; width: 65%;" disabled></td>' +

                                '<td style="padding-top:20px;"><input id="test" value="${ExtraTax}" type="text" class="form-control" style="margin-left:47%; width: 65%;" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${ExtraTaxValue}" type="text" class="form-control" style="margin-left:39%; width: 65%;" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${ValueExTax}" type="text" class="form-control" style="margin-left:29%; width: 65%;" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${Amount}" type="text" class="form-control" style="margin-left:21%; width: 65%;" disabled></td>' +
                                '<td style="display:none;"><input id="test" value="${TotalTax}" type="text" class="form-control" style="margin-left:21%; width: 65%;" disabled></td>' +
                                '</tr>';
                            $('#myData').append(newRow);

                        });
                    }
                }
            })
        }

        function SaleRateKeyUp(SaleRate, RowIndex) {

            var quantity = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('6')").text();
            var tax = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('9')").val();
        }

        function QuantityKeyUp(quantity) {
            var tax = document.getElementById('stvalue').value;
            var extratax = document.getElementById('extratax').value;
            var price = document.getElementById('price_per_unit').value;
            var totaltax = (price / 100 * tax) * quantity;
            var extratax = (price / 100 * extratax) * quantity;
            document.getElementById('taxvalue').value = totaltax;
            document.getElementById('extraTaxValue').value = extratax;
            var valueWithoutTax = quantity * price;
            document.getElementById('ValueExTax').value = valueWithoutTax;
            total = (quantity * price) + totaltax + extratax;
            document.getElementById('amount').value = total;
            // if (event.keyCode == 13) {
            //         // event.preventDefault();
            //         var $this = $(event.target);
            //         var index = parseFloat($this.attr('data-index'));
            //         // alert(index);
            //         $('[data-index="' + (index + 1).toString() + '"]').focus();
            //         return false;
            //     }

        }

        function SaleRateKeyUpForm(price) {
            var quantity = document.getElementById('quantity').value;
            var stvalue = document.getElementById('stvalue').value;
            //tax value
            var tax = (stvalue / 100 * price) * quantity;
            document.getElementById('taxvalue').value = tax;

            //extra tax value
            var extrataxvalue = document.getElementById('extratax').value;
            var extratax = (extrataxvalue / 100 * price) * quantity;
            document.getElementById('extraTaxValue').value = extratax;

            var total = quantity * price;
            var totalValue = total + tax + extratax;
            document.getElementById('ValueExTax').value = total;
            document.getElementById('amount').value = totalValue;
        }

        function ExtraTaxkeyup(taxvalue) {

            var quantity = document.getElementById('quantity').value;
            var price = document.getElementById('price_per_unit').value;
            var stvalue = document.getElementById('stvalue').value;
            var tax = (stvalue / 100 * price) * quantity;
            var extratax = (taxvalue / 100 * price) * quantity;

            document.getElementById('extraTaxValue').value = extratax;
            document.getElementById('extraTaxValue1').value = extratax;
            var total = quantity * price;
            var totalValue = total + tax + extratax;
            document.getElementById('ValueExTax').value = total;
            document.getElementById('amount').value = totalValue;

        }

        function TaxValueKeyUp(TaxValue, RowIndex) {
            var quantity = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('6')").text();
            var price = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('8')").find('input').val();
            var ExtraTax = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('11')").find('input').val();

            var TotalTax = parseInt(TaxValue / 100 * price * quantity);
            var TotalExtraTax = parseInt(ExtraTax / 100 * price * quantity);
            var TotalValue = price * quantity;
            var InclusiveValue = TotalTax + TotalValue;
            $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('10')").text(TotalTax);
            $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('12')").text(TotalExtraTax);
            $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('13')").text(InclusiveValue);

        }

        // on javascript onclick on product dropdown 
        function CodeKeyUp(codeValue) {
            $.ajax({
                type: "GET",
                url: "{{ asset('saletab-ajax') }}?code=" + codeValue,
                success: function(result) {
                    if (result.length > 0) {
                        $('#product_name').val(result[0].product_name);
                        $('#product_id').val(result[0].id);
                        $("#packing_type").val(result[0].catagory_name);
                        $("#price_per_unit").val(result[0].price_per_unit);
                        $("#uom").val(result[0].uom);
                        $("#stvalue").val(result[0].stvalue);

                        var price = $("#price_per_unit").val();
                        var quantity = $("#quantity").val();
                        var stvalue = $("#stvalue").val();
                        var tax = parseInt((stvalue / 100 * price) * quantity);

                        document.getElementById('taxvalue').value = tax;
                        valueWithoutTax = quantity * price;
                        document.getElementById('value').value = valueWithoutTax;
                        var total = price * quantity;
                        var grand = tax + total;
                        document.getElementById('amount').value = grand;
                        document.getElementById('grand_total').value = grand;
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        function ProductKeyUp(product) {
           
            $("#quantity").focus();
            document.getElementById('quantity').focus;
            var productID = document.getElementById('product_name').value.split("_")[0];
            var productCode = document.getElementById('product_name').value.split("_")[1];
            var productName = document.getElementById('product_name').value.split("_")[2];
            var productTax = document.getElementById('product_name').value.split("_")[3];
            var productprice = document.getElementById('product_name').value.split("_")[4];
            var unit = document.getElementById('product_name').value.split("_")[5];


            document.getElementById('product_id').value = productID;
            document.getElementById('product_code').value = productCode;
            document.getElementById('price_per_unit').value = productprice;
            document.getElementById('stvalue').value = productTax;
            document.getElementById('uom_id').value = unit;
            // $("#product_code").focus();
            

        }

        // on javascript onclick on product dropdown 
        function ProductKeyUps(ProductName, ProductID) {
            $.ajax({
                type: "GET",
                url: "{{ asset('taxproductkeyup-ajax') }}?product_ID=" + ProductID,
                success: function(result) {
                    if (result.length > 0) {
                        $('#product_code').val(result[0].product_code);
                        $('#product_id').val(result[0].id);
                        $("#packing_type").val(result[0].catagory_name);
                        $("#price_per_unit").val(result.product_price);
                        $("#uom").val(result[0].uom);
                        $("#stvalue").val(result[0].tax);


                        var price = $("#price_per_unit").val();
                        var quantity = $("#quantity").val();
                        var stvalue = $("#stvalue").val();
                        var extratax = $("#extratax").val();
                        var tax = parseInt((stvalue / 100 * price) * quantity);
                        var extratax = parseInt((extratax / 100 * price) * quantity);
                        document.getElementById('taxvalue').value = tax;
                        document.getElementById('extraTaxValue').value = extratax;
                        var total = price * quantity;
                        var grand = tax + extratax + total;
                        document.getElementById('value').value = total;
                        document.getElementById('amount').value = grand;
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        function PartyKeyUp(partyID) {
           
            $.ajax({
                type: "GET",
                url: "{{ asset('taxpartyonchange-ajax') }}?party_ID=" + partyID,
               
                success: function(result) {
                    // alert();
                    if (result.length > 0) {
                        
                        $('#party_id').val(result[0].id);
                        $('#address').val(result[0].address);
                        $('#strn').val(result[0].strn);
                        $('#ntn').val(result[0].ntn);
                    }else{
                        $('#party_id').val("");
                        $('#address').val("");
                        $('#strn').val("");
                        $('#ntn').val("");
                    }
                }
            })
        }

        //on product Mouse up 
        function productMouseUp(productName, rowIndex) {
            $.ajax({
                type: "GET",
                url: "{{ asset('productonchange-ajax') }}?product_name=" + productName,
                success: function(result) {
                    if (result.length > 0) {
                        $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('0')").find('input').val(result[0]
                            .id);
                        $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('1')").find('input').val(result[0]
                            .product_code);
                        $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val(result[0]
                            .remaining_quantity);
                        $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val(result[0]
                            .unit_cost);

                        var salePrice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input')
                            .val();

                        var discount = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('select')
                            .val().split("_").pop();
                        var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input')
                            .val();
                        var price = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input')
                            .val();
                        var grand = (price * quantity) - (((discount / 100)) * price * quantity);
                        $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(grand);

                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        function salepriceMouseUp(salePrice, rowIndex) {
            var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val();
            var saleprice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val();
            var grand = quantity * saleprice;
            $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(grand);
        }

        $("#product_codess").keyup(function() {
            if ($("#product_code").val() != "0") {
                $.ajax({
                    type: "GET",
                    url: "{{ asset('getfirstProduct-ajax') }}?saletab_id=" + $("#product_code").val(),
                    success: function(result) {
                        if (result.length > 0) {
                            $("#product_id").val(result[0].id);
                            $("#product_name").val(result[0].product_english);
                            $("#unit_cost").val(result[0].product_price);

                            var quantity = document.getElementById('quantity').value;
                            var cost = document.getElementById('unit_cost').value;
                            var discount = document.getElementById('discount_id').value.split("_")
                                .pop();
                            //var tax = document.getElementById('tax_id').value.split("_").pop();
                            var totalDiscount = ((discount / 100) * quantity * cost);
                            var total = quantity * cost;
                            document.getElementById('total_cost').value = total - totalDiscount;
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
            }
        });
           
        function myDeleteFunction(row) {
       
            alertify.confirm("Are you sure you want to delete this row?", function(e) {
                if (e) {
                    // var TotalRate = document.getElementById('TotalRate').value;
                    // var rate = $(row).find("td:eq('7')").find("input").val();
                    // var grandRate = parseInt(TotalRate) - parseInt(rate);
                    // document.getElementById('TotalRate').value = grandRate;

                    // var TotalTax = document.getElementById('TotalTax').value;
                    // var tax = $(row).find("td:eq('9')").find("input").val();
                    // var grandTax = parseInt(TotalTax) - parseInt(tax);
                    // document.getElementById('TotalTax').value = grandTax;

                    // var TotalExTax = document.getElementById('TotalExTax').value;
                    // var Extax = $(row).find("td:eq('12')").find("input").val();
                    // var grandExTax = parseInt(TotalExTax) - parseInt(Extax);
                    // document.getElementById('TotalExTax').value = grandExTax;

                    // var TotalAmount = document.getElementById('TotalAmount').value;
                    // var Inctax = $(row).find("td:eq('13')").find("input").val();
                    // var grandIncTax = parseInt(TotalAmount) - parseInt(Inctax);
                    // document.getElementById('TotalAmount').value = grandIncTax;

                    $(row).remove();
                    TotalQty1();
                        TotalTax1();
                        TotalExTax1();
                        TotalGrandAmount();
                } else {
                    alertify.alert("Row Deleting Cancelled!");
                }
            });
        }

        function DiscountNew(discount, rowIndex) {
            var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val();
            var discountnew = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('select').val().split("_")
                .pop();
            var price = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val();
            var totalDiscount = ((discountnew / 100) * quantity * price);
            var total = quantity * price;
            $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(total - totalDiscount);
        }

        // on javascript onclick on product dropdown
        function quantityMouseUp(quantity, rowIndex) {
            var code = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('1')").find('input').val();
            var remainingquantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('8')").find('input').val();
            if (quantity > remainingquantity) {
                alert("Invalid! Your Remaining Stock is: " + quantity);
                e.preventdefault();
            }
            var price = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val();
            var discount = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('select').val().split("_").pop();

            var totalDiscount = ((discount / 100) * quantity * price);
            var total = quantity * price;
            $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(total - totalDiscount);
        }
    </script>
     
@stop
