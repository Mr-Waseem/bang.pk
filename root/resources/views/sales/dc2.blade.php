<html>

<head>
    <link href="{{ asset('css/bg.css') }}" rel="stylesheet">
</head>

<body style="border:double;" onload="window.print();">
    <!--<span style="float: right;margin-top: -19px;">-->
    <!--	<?php $t = time();
$t . '<br>';
echo date('d-m-Y', $t); ?>-->
    <!--</span>-->
    <!-- <h3 style="margin-left: 1250px;"><u><strong>SALE INVOICE</strong></u></h3> -->
    </br>
    <div class="row">
        <div>
            <div style="float:left; color: #1e00c6;margin-left: 2%; ">
                <b style="font-size: 23px;">{{ $newsale_detail[0]->shop->name }}</b>
            </div>
            <div style="float: right;padding: 0px 4%;">
                <u style="color: #1e00c6"><strong>DELIVERY CHALLAN</strong></u></h3>
            </div>
        </div>
    </div></br></br>

    <div class="row">
        <div>
            <div style="float:left; color: #1e00c6;margin-left: 2%;">
                <!-- <b>{{ $newsale_detail[0]->shop->name }}</b> -->
            </div>
            <div
                style="float: right;color: black;padding: 0px 8%;border: 2px solid #1e00c6;background: #1e00c6;margin-right: 2%;">
                DATE
            </div>
        </div>
    </div></br>
    <div class="row" style="margin-top: 3px;">
        <div>
            <div style="float:left; color: #1e00c6;padding: 0px 2%;">
                <b>Address: </b>{{ $newsale_detail[0]->shop->address }}
            </div>
            <div style="float: right;margin-right: -16%;">
                {{ date('d/m/Y', Strtotime($newsale_detail[0]->date)) }}

            </div>
        </div>
    </div></br>
    <div class="row" style="margin-top: 3px;">
        <div>
            <div style="float:left; color: #1e00c6;padding: 0px 2%;">
                PUNJAB, PAKISTAN.
            </div>
            <div
                style="float: right;color: black;padding: 0px 4%;border: 2px solid #1e00c6;background: #1e00c6;margin-right: 2%;">
                DC&nbsp;&nbsp;NO.
            </div>
        </div>
    </div>
    </br>
    <div class="row" style="margin-top: 3px;">
        <div>
            <div style="float:left; color: #1e00c6;padding: 0px 2%;">
                <b>Phone: </b>{{ $newsale_detail[0]->shop->phone }}
            </div>
            <div style="float: right;margin-right: -12%;">
                {{ $newsale_detail[0]->invoice_no }}
            </div>
        </div>
    </div>
    </br>
    <div class="row" style="margin-top: 3px;">
        <div>
            <div style="float:left; color: #1e00c6;padding: 0px 2%;">
                <b>Email: </b>{{ $newsale_detail[0]->shop->email }}
            </div>
            <!-- <div style="float: right;color: black;padding: 0px 3%;border: 2px solid #1e00c6;background: #1e00c6;margin-right: 2%;">
      CUSTOMER ID.
     </div> -->
        </div>
    </div></br>
    <div class="row" style="margin-top: 3px;">
        <div>
            <div style="float:left; color: #1e00c6;padding: 0px 2%; color:blue;">
                <b>BILL TO: {{ $newsale_detail[0]->parties->party_name }}</b>
            </div>
            <!-- <div style="float: right;margin-right: -12%; color:blue;">
      <b>{{ $newsale_detail[0]->parties->id }}</b>
     </div> -->
        </div>
    </div>
    </br>
    <!-- <div class="row" style="margin-top: 3px;">
    <center><u><b style="text-transform: uppercase;">{{ $newsale_detail[0]->sale_type }}</b></center></u></center>
   </div> -->
    <table style="width: 98%; border:2px solid; padding: 10px 20px; margin-left: 1%;
    margin-right: 1%;">
        <thead>
            <tr style="background:#1e00c6;">
                <th style="width:1%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">SR#</th>
                <!--<th style="border:2px solid; width:50px;"><center>Code</center></th>-->
                <th style="width:330px; border-top: 2px solid;border-bottom: 2px solid;">
                    <center>Item&nbsp;Description</center>
                </th>
                <th style="width:100px; border-top: 2px solid;border-bottom: 2px solid;">
                    <center>Quantity</center>
                </th>
                <th style="width:70px; border-top: 2px solid;border-bottom: 2px solid;">
                    <center>Pack</center>
                </th>





                <!-- <th style="width:100px; border-top: 2px solid;border-bottom: 2px solid;"><center>Discount</center></th> -->

                <th style="width:100px; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">
                    <center>Weight</center>
                </th>
            </tr>
        </thead>

        <!-- <tr style="background:  #1e00c6;">
   <th style="border:2px solid; width:50px;"><center>SR</center></th>
   <th style="border:2px solid; width:340px;"><center>Item Description</center></th>
   <th style="border:2px solid; width:100px;"><center>Quantity</center></th>

   <th style="border:2px solid; width:100px;"><center>Discount</center></th>
   <th style="border:2px solid; width:100px;"><center>Rate</center></th>
   <th style="border:2px solid; width:100px;"><center>Amount</center></th>
  </tr> -->
        <tbody>
            <?php $sum = 1;
            $quantity = 0;
            $rate = 0;
            $Weight = 0;
            $amount = 0;
            $discount = 0;
            $discountvalue = 0;
            $grossamount = 0; ?>
            @foreach ($newsale_detail[0]->sale_details as $details)
                <tr id="datafont" style="border:2px solid;">
                    <td id="tabledata">
                        <center style=" font-size:16px; font-weight: 600;">{{ $sum }}</center>
                    </td>
                    <!--<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>
   @if ($details->products != null)
   {{ $details->products->product_code }}
   @endif</center></td>-->
                    <td id="tabledata">
                        <center style="float: left; margin-left:5px; font-size:16px; font-weight: 600;">
                            @if ($details->products != null)
                                {{ $details->products->product_name }}
                            @endif
                            @if ($details->products->product_urdu != null)
                                - {{ $details->products->product_urdu }}
                            @endif

                        </center>
                        <span style="float:right;">{{ $details->uoms->uom }}</span>
                    </td>
                    <td id="tabledata" style="font-size:16px; font-weight: 600;">
                        <center>{{ number_format($details->quantity, 2) }}</center>
                    </td>
                    <td id="tabledata" style="font-size:16px; font-weight: 600;">
                        <center>{{ $details->products->pack_weight }}</center>
                    </td>

                    <td id="tabledata" style="font-size:16px; font-weight: 600;">
                        <center>
                            @if ($details->uoms->uom != 'KG')
                                {{ number_format($details->quantity * $details->products->pack_weight, 2) }}
                                @php
                                    $Weight = $Weight + (float) $details->quantity * $details->products->pack_weight;
                                @endphp
                            @else
                                {{ number_format($details->quantity, 2) }}
                                @php
                                    $Weight = $Weight + (float) $details->quantity;
                                @endphp
                            @endif
                        </center>
                    </td>
                    <!-- <td id="tabledata" style=" "><center>{{ $details->discount->discount }}%</center></td> -->
                    @php
                        $value = ($details->discount->discount / 100) * ($details->sale_rate * $details->quantity);
                        $gross = $details->sale_rate * $details->quantity;
                        
                    @endphp

                </tr>
                <?php
                
                $discount = $discount + (int) $details->discount->discount;
                $discountvalue = $discountvalue + (int) $value;
                // $grossamount = $grossamount + $gross;
                $quantity = $quantity + (float) $details->quantity;
                
                $rate = $rate + (float) $details->sale_rate;
                $grossamount = $grossamount + (float) $details->sale_amount;
                $sum = $sum + 1;
                ?>
            @endforeach
            <tr id="datafont">
                <!-- <td>Issud&nbsp;By:&nbsp;{{ $newsale_detail[0]->billers->name }}</td> -->
                <td>
                    <center></center>
                </td>
                <td>
                    <center></center>
                </td>

                <!-- <td><center></center></td> -->
                <td id="tabledata" colspan="2" style="background: #b2dee8; font-size:16px; font-weight: 600;">
                    <center>TOTAL QUANTITY</center>
                </td>
                <td id="tabledata" style="background: #b2dee8; font-size:16px; font-weight: 600;">
                    <center> {{ number_format($quantity, 2) }}</center>
                </td>

            </tr></br>
            <tr id="datafont">
                <td>
                    <center></center>
                </td>
                <td>
                    <center></center>
                </td>

                <td id="tabledata" colspan="2" style="background: #b2dee8; font-size:16px; font-weight: 600;">
                    <center>TOTAL WEIGHT</center>
                </td>
                <td id="tabledata" style="background: #b2dee8; font-size:16px; font-weight: 600;">
                    <center> {{ number_format($Weight, 2) }}</center>
                </td>

            </tr></br>


            <!-- <tr id="datafont">
   <td><center></center></td>
   <td><center></center></td>
   <td><center></center></td>
   <td id="tabledata" colspan="2" style="background: #b2dee8;"><center>DISCOUNT</center></td>
   <td id="tabledata" style="background: #b2dee8;"><center>{{ $discount }}</center></td>
  </tr> -->


        </tbody>
    </table>
    <!-- 		<table>
   <div class="row" style="margin-top: 3px;">
    <div class="col-sm-12">
    <div class="col-sm-4">
     <div style="float:left; color: #1e00c6;padding: 0px 2%; color:blue;">
      <h4><center><b style="color: #1e00c6; font-family: monospace;">PREVIOUS BALANCE</b></center></h4>
     </div>
     
    </div>
    <div class="col-sm-4">
     <div style="float:left; color: #1e00c6;padding: 0px 2%; color:blue;">
      <h4><center><b style="color: #1e00c6; font-family: monospace;">PREVIOUS BALANCE</b></center></h4>
     </div>
     
    </div>
    <div class="col-sm-4">
     <div style="float:left; color: #1e00c6;padding: 0px 2%; color:blue;">
      <h4><center><b style="color: #1e00c6; font-family: monospace;">PREVIOUS BALANCE</b></center></h4>
     </div>
     
    </div>
   </div>
   </div>
 </table> -->

    <!-- <p><strong>ISSUED BY</strong></p> -->
    <!-- <p><center style="margin-top: -28px;"><strong>APPROVED BY</strong></center></p>
 <p style="float:right; margin-top: -33px;"><strong>RECIEVED BY</strong></p></br> -->
    <!-- <p><strong><u>{{ $newsale_detail[0]->billers->name }}</u></strong></p> -->
    <!-- 	<p><center style="margin-top: -28px;"><strong>___________</strong></center></p>
 <p style="float:right; margin-top: -33px;"><strong>___________</strong></p></br> -->

</body>
</br>
@php
$debit = 0;
$credit = 0;
@endphp
@foreach ($ledgers as $ledger)
    @php
        $debit = $debit + (int) $ledger->debit;
        $credit = $credit + (int) $ledger->credit;
    @endphp
@endforeach
@php $totalBalance = $debit-$credit;@endphp
<!-- 	<table style="width:100%; border-bottom:2px dotted;">
   <tr>
    <td style="font-size: 12px; font-family: monospace;">&nbsp;&nbsp;&nbsp;PREVIOUS BALANCE:{{ $company_detail[0]->currency }}: {{ number_format($totalBalance - $grossamount - $discount) }}</td>
    <td style="font-size: 12px; font-family: monospace;">G.Total: {{ $company_detail[0]->currency }}: {{ number_format($grossamount - $discount) }}</td>
   </tr>
   <tr>
    <td style="font-size: 12px; font-family: monospace;">&nbsp;&nbsp;&nbsp;TOTAL BALANCE: {{ $company_detail[0]->currency }}:  {{ number_format($totalBalance) }}</td>
   
   </tr>
  </table>
  <br/> -->
<table style="width:100%; border-bottom:2px solid;">

    <tr>
        <td style="font-size: 12px; font-family: monospace;">&nbsp;&nbsp;&nbsp;Driver: {{ $newsale_detail[0]->driver }}
        </td>
        <td></td>
        <td style="font-size: 12px; font-family: monospace;">Vehicle#: {{ $newsale_detail[0]->vehicle }}</td>
    </tr>
    <tr>
        <td style="font-size: 12px; font-family: monospace;">&nbsp;&nbsp;&nbsp;Freight:
            {{ $newsale_detail[0]->freight }}</td>
        <td></td>
        <td style="font-size: 12px; font-family: monospace;">Returnable: {{ $newsale_detail[0]->returnable }}</td>
    </tr>
</table>
<table style="width:100%;">



    <tr>
        <td style="font-size: 12px; font-family: monospace;">&nbsp;&nbsp;&nbsp;Created By</td>
        <td style="font-size: 12px; font-family: monospace;">Checked By</td>
        <td style="font-size: 12px; font-family: monospace;">Approved By</td>
    </tr>
    <tr>
        <td style="font-size: 12px; font-family: monospace;">&nbsp;&nbsp;&nbsp;{{ $newsale_detail[0]->billers->name }}
        </td>
        <td style="font-size: 12px; font-family: monospace;">__________________</td>
        <td style="font-size: 12px; font-family: monospace;">__________________</td>
    </tr>

</table>
<!--  <p style="float: left;margin-left: 5%;font-size: 12px; font-family: monospace;">PREVIOUS BALANCE:{{ $company_detail[0]->currency }}: {{ number_format($totalBalance - $grossamount - $discount) }} </p>
 <p style="float: left;margin-left: 12%;font-size: 12px; font-family: monospace;">G.Total: {{ $company_detail[0]->currency }}: {{ number_format($grossamount - $discount) }}</p>
 <p style="float: left;margin-left: 32%;font-size: 12px; font-family: monospace;">TOTAL BALANCE: {{ $company_detail[0]->currency }}:  {{ number_format($totalBalance) }}</p></br></br> -->


<!-- <p><center style="color: #1e00c6; font-size: 12px; font-family: monospace;">NOTE: PRODUCTS ONCE SOLD ARE NOT RETURNABLE OR EXCHANGEABLE.</center></p>
 <p><center style="color: #1e00c6; font-size: 12px; font-family: monospace;">Note: You need to pay server charges per year. It may be increased or decreased according to dollar fluctuation.</center></p>
 <p><center style="color: #1e00c6; font-size: 12px; font-family: monospace;">If you have any question about this invoice, please contact</center></p>
 <p><center style="color: #1e00c6; font-size: 12px; font-family: monospace;">Issued&nbsp;By: {{ $newsale_detail[0]->billers->name }} Phone: {{ $newsale_detail[0]->shop->phone }} Email: {{ $newsale_detail[0]->shop->email }}</center></p>
 <h4><center><b style="color: #1e00c6; font-family: monospace;">THANKYOU FOR YOUR BUSINESS WITH {{ $company_detail[0]->title }}!</b></center></h4> -->

</html>
</br>
<!-- <b style="float:right; margin-right: 0px;">Developed by <u style="color:blue;">www.itlife.com.pk</u> | 0321 4197290</b> -->
