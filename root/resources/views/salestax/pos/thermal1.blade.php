<!DOCTYPE html>
<html lang="en">
@php 
$settings =0;
use App\Models\Setting;
$settings = Setting::where('id', 1)->get();
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Thermal Receipt</title>
    <style>
        * {
            font-size: 12px;
            font-family: 'Times New Roman';
        }
        
        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
        }
        
        td.description,
        th.description {
            width: 75px;
            max-width: 75px;
        }
        
        td.quantity,
        th.quantity {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }
        
        td.price,
        th.price {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }
        
        .centered {
            text-align: center;
            align-content: center;
        }
        
        .ticket {
            width: 255px;
            max-width: 200px;
        }
        
        /* img {
            max-width: inherit;
            width: inherit;
        } */
        
    </style>
</head>
<body onload="window.print(); setTimeout(window.close, 0.00);">
    <div class="ticket"><br/>
    {{-- <img src="{{ URL::asset('root/upload/logo/thermal-receipt-logo.png') }}" alt="Logo">  --}}
        <b><center style="font-size:200%">{{session()->get('company_name')}}</center></b>
        <center style="font-size:100%;margin-top:3px;margin-bottom:5px;" >NTN: {{session()->get('company_ntn')}}&emsp; STRN:  {{session()->get('company_strn')}}</center>
        <p><b style="font-size:130%">Bill.No: {{$newsale_detail[0]->invoice_no}}</p>
           
        {{-- <p><b style="font-size:130%">FBR#: {{$newsale_detail[0]->fbr_invoice_no}}</p> --}}
        {{-- <p><b style="font-size:130%">Type:{{$sales->category}}</b></p> --}}
        @if($newsale_detail[0]->parties->party_name)
        <p style="margin-top: -10px;">
        <b style="font-size:130%">Name: {{$newsale_detail[0]->parties->party_name}}</b></p>
         <p style="margin-top: -10px;margin-bottom: -10px;"><b style="font-size:130%">Phone: {{$newsale_detail[0]->parties->phone}}
    </b></p>
         @endif
          <!--<p><b style="margin-top: -10px;font-size:130%">-->
          <!--  @if( session()->get('company_ntn_show')==1)-->
          <!--     NTN: {{ $newsale_detail[0]->parties->ntn }}<br>          -->
          <!--  @else          -->
          <!--  @endif-->
          <!--  @if( session()->get('company_strn_show')==1)-->
          <!--      STRN: {{ $newsale_detail[0]->parties->strn }}-->
          <!--  @else            -->
          <!--  @endif-->
          <!--  </b></p>-->
        {{-- <p class="centered mb-2">{{$newsale_detail[0]->address}}</p> --}}
        {{-- <p class="centered mb-2">{{$newsale_detail[0]->parties->address}}</p> --}}
        <p> <b style="font-size:130%">Date: {{date("d/m/Y", strtotime($newsale_detail[0]->date))}} Time: {{date("h:i", strtotime($newsale_detail[0]->created_at))}}</b></p>
        <table>
            <thead align="center">
                <tr>
                    <th class="item">Product</th>
                    <th class="quantity">Qty</th>
                    <th class="price">Rate</th>
                    <th class="price">Tax%</th>
                    <th class="total">Price</th>
                </tr>
            </thead>
            <tbody align="center">
                @php
                //  $sum = 1;
                $quan = 0;
                $rate = 0;
                $price=0;
                $ValueExcTax = 0;
                $STValue = 0;
                $amount = 0;
               
                @endphp
                @foreach ($newsale_detail[0]->saletax_details as $value)
                <tr>
                    <td class="description">{{ $value->products->product_name  }}</td>
                    <td class="quantity">{{ number_format($value->quantity) }}</td>
                    <td class="quantity">{{ number_format($value->rate) }}</td>
                    <td class="quantity">{{ number_format($value->stvalue) }}</td>
                    <td class="price">{{ number_format($value->price) }}</td>
                </tr>
                {{-- <tr>
                    <td colspan="4" class="comment">Comment:&nbsp;{{ $value->comments}}</td> 
                </tr> --}}
                {{-- @empty --}}
                {{-- <tr>
                    <td colspan="3">Record Not Found</td>
                </tr> --}}
            @php
                    $quan = $quan + $value->quantity;
                    $rate = $rate + $value->rate;
                    $price = $price + $value->price;
                    $ValueExcTax = $ValueExcTax + $value->quantity * $value->rate;
                    $STValue = $STValue + $value->taxvalue;
                    $amount = $amount + $value->total;
                // $sum = $sum + 1;
                @endphp
                @endforeach
            </tbody>
            <tfoot align="center">
                <tr>
                    <td><b style="font-size:130%">Sub Total:</b></td>
                    <td><b style="font-size:130%">{{ number_format( $quan) }}</b></td>
                    <td><b style="font-size:130%">
                        {{-- {{ number_format( $rate) }} --}}
                    </b></td>
                    <td><b style="font-size:130%">
                        {{-- {{ number_format( $rate) }} --}}
                    </b></td>
                    <td><b style="font-size:130%">{{ number_format($price) }}</b></td>
                </tr>
                {{-- <tr>
                    <td><b style="font-size:100%">Exc.ST:</b></td>
                    <td><b style="font-size:100%">
                        {{ number_format( $quan) }}
                    </b></td>
                    <td><b style="font-size:100%">
                        {{ number_format( $rate) }}
                    </b></td>
                    <td><b style="font-size:100%">{{ number_format((int) $ValueExcTax) }}</b></td>
                </tr> --}}
                <tr>
                    <td><b style="font-size:100%">Tax.Val:</b></td>
                    <td><b style="font-size:100%">
                        {{-- {{ number_format( $quan) }} --}}
                    </b></td>
                    <td><b style="font-size:100%">
                        {{-- {{ number_format( $rate) }} --}}
                    </b></td>
                    <td><b style="font-size:100%">
                        {{-- {{ number_format( $rate) }} --}}
                    </b></td>
                    <td><b style="font-size:100%">{{ number_format((int) $STValue) }}</b></td>
                </tr>
                <tr>
                    <td><b style="font-size:130%">Grand Total:</b></td>
                    <td><b style="font-size:130%">
                        {{-- {{ number_format( $quan) }} --}}
                    </b></td>
                    <td><b style="font-size:130%">
                        {{-- {{ number_format( $rate) }} --}}
                    </b></td>
                    <td><b style="font-size:130%">
                        {{-- {{ number_format( $rate) }} --}}
                    </b></td>
                    <td><b style="font-size:130%">{{ number_format((int) $amount) }}</b></td>
                </tr>
               
            </tfoot>
        </table>
        {{-- <p><b style="font-size:200%"><center>Total PKR: {{ number_format($totalAmount) }}</center></b></p> --}}
        @if(($newsale_detail[0]->fbr_invoice_no)==!null)
    <div class='container'>
       
        <p>FBR.Inv#: {{ $newsale_detail[0]->fbr_invoice_no }}</p>
        
       {{-- {{  QRCode::text({{ $newsale_detail[0]->fbr_invoice_no }})->svg()}} --}}
       <img src="{{Asset('root\upload\logo\fbrlogo.jpg')}}" style="height: 35px;"></> 
       <input id="text" type="text" 
            value={{ $newsale_detail[0]->fbr_invoice_no }} style="display:none;Width:20%"
             /> 

      <img id='barcode' style='margin-left:110px' 
            {{-- src= {{ $newsale_detail[0]->fbr_invoice_no }}  --}}
            src="https://api.qrserver.com/v1/create-qr-code/?data= {{ $newsale_detail[0]->fbr_invoice_no }}&amp;size=50x50'" 
            alt="" 
            title="FBR Invoice" 
            width="40" 
            height="40" />
          
              
    </div>
    @else
    @endif
            <p class="centered">Thanks for your purchase!
                <br><b style="font-size:130%">{{session()->get('company_phone')}}</b>
            </p>
    
           
        
        {{-- <button id="btnPrint" class="hidden-print">Print</button> --}}
        <script>
            const $btnPrint = document.querySelector("#btnPrint");
            $btnPrint.addEventListener("click", () => {
                document.querySelector("#btnPrint").style.display = 'none';
                window.print();
            });
        </script>
         {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
         <script type="text/javascript">
             function generateBarCode()
             {
                 var nric = $('#text').val();
                 var url = 'https://api.qrserver.com/v1/create-qr-code/?data=' + nric + '&amp;size=50x50';
                 $('#barcode').attr('src', url);
             }
         </script> --}}
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                var data = $('div svg rect').css();
                // alert(data);
            });
        </script> --}}
    </body>
    
    </html>