<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>PARTY LEDGER DETAIL</title>
	<link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
	<style>
    tr {
        /* line-height: 0px; */
        border: 1px solid black;
    }

    .table thead th,
    .table tbody tr td {
        border: 1px solid black;
        padding: 0px !important;
        padding-left: 5px !important;
    }
    </style>
</head>
	</br>
<body>
	<div class="container">
		<div class="row flex-lg-nowrap">
			<div class="col">
				<div class="row">
					<div class="col mb-3">
						<div class="card">
							<div class="card-body">
								<div class="e-profile">
									@include('include.header')
									<h2 class="text-center"><u>PARTY LEDGER (DETAIL)</u></h2>
									<p class="text-center font-italic"><b>From:</b> {{
										date('d/m/Y',strtotime($fromDate)) }} && <b>To:</b> {{
										date('d/m/Y',strtotime($toDate)) }}</p>
                                    <div class="row">
                                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                            <h5>PARTY NAME: {{ $party->party_name ?? '' }}</h5>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <h5>PARTY CODE: {{ $party->code ?? '' }}</h5>
                                        </div>
                                        
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <h5 class="text-left">Type: {{ $party->account_type ?? '' }}</h5>
                                        </div>
                                    </div>
                                        <br>
                                        <div class="table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr>
                                            <th>Vr.No</th>
                                                    <th>Vr.Type</th>
                                                    <th>Date</th>
                                                    <th style="display: none;">Narration</th>
                                                    <th>Description</th>
                                                    {{-- <th>Qty</th>
                                                    <th>Rate</th> --}}
                                                    <th>Cheque.No</th>
                                                    <th>Party</th>
                                                    <th>Debit</th>
                                                    <th>Credit</th>
                                                    <th>Balance</th>
											</tr>
										</thead>
										<tbody>
                                        <?php $totalOpening = 0; ?>
                                            <tr>
                                                <td colspan="6" align="center">OPENING CASH</td>
                                                {{-- <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td> --}}
                                                <td>{{ number_format(round((float) ($openingBalance->OpeningOUT ?? 0))) }}</td>
                                                <td>{{ number_format(round((float) ($openingBalance->OpeningIN ?? 0))) }}</td>

                                                @php
                                                    $openingOut = round((float) ($openingBalance->OpeningOUT ?? 0));
                                                    $openingIn = round((float) ($openingBalance->OpeningIN ?? 0));
                                                    $totalOpening = $openingOut - $openingIn;
                                                @endphp
                                                <td>{{ number_format($totalOpening) }}</td>
                                            </tr>
                                            @php
                                                $totalDebit = 0;
                                                $totalCredit = 0;
                                                $sum = 0;
                                                $totalIn = 0;
                                                $totalOut = 0;
                                                $TotalQTY = 0;
                                                $TotalRate = 0;
                                            @endphp
											@if (count($GeneralVoucher) > 0)
                                                @foreach ($GeneralVoucher as $GeneralVouchers)
                                                    <?php $sum = $sum + 1; ?>
                                                    <tr>
                                                        <td>{{ $GeneralVouchers->voucher_no }}</td>
                                                        <td>
                                                        @if ($GeneralVouchers->v_type == 'Cash Purchase')
                                                        {{ 'Cash|Purchase' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'Credit Purchase')
                                                        {{ 'Cr|Purchase' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'Sale Bill')
                                                        {{ 'SB' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'PurchaseTax Invoice')
                                                        {{ 'PTV' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'SalesTax Invoice')
                                                        {{ 'Sales Tax Invoice' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'Journal Voucher')
                                                        {{ 'JV' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'Cash Receipt')
                                                        {{ 'CR' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'Cash Payment')
                                                        {{ 'Cash Payment' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'Bank Receipt')
                                                        {{ 'Bank Receipt' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'Bank Payment')
                                                        {{ 'Bank Payment' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'Post Dated Cheque')
                                                        {{ 'PostDated Cheque' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'Purchase Return')
                                                        {{'Purchase Return' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'Credit Sale')
                                                        {{ 'Sale | CR' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'Cash Sale')
                                                        {{ 'Sale | CASH' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'Sale Return')
                                                        {{ 'Sale Return' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'Payment on Credit Bill')
                                                        {{ 'Payment on Credit Bill' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'Salary')
                                                        {{ 'Salary' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == '13TS')
                                                        {{ 'Purchase Milk| 13TS' }}
                                                        @endif
                                                        @if ($GeneralVouchers->v_type == 'FAT5')
                                                        {{ 'Purchase Milk| FAT5' }}
                                                        @endif
                                                        </td>
                                                        <td>{{ date('d/m/Y', strtotime($GeneralVouchers->date)) }}</td>
                                                        <td>
                                                            @if ($GeneralVouchers->v_type == 'SalesTax Invoice' && isset($GeneralVouchers->sales_tax) && $GeneralVouchers->sales_tax)
                                                                @php $firstDetail = $GeneralVouchers->sales_tax->saletax_details->first() ?? null; @endphp
                                                                @if($firstDetail)
                                                                    @if(isset($firstDetail->products) && $firstDetail->products)
                                                                        {{ $firstDetail->products->product_code ?? '' }} - {{ $firstDetail->products->product_name ?? '' }}
                                                                    @else
                                                                        {{ $firstDetail->product_id ?? $GeneralVouchers->narration ?? '' }}
                                                                    @endif
                                                                @else
                                                                    {{ $GeneralVouchers->narration ?? '' }}
                                                                @endif
                                                            @else
                                                                {{ $GeneralVouchers->narration ?? '' }}
                                                            @endif
                                                        </td>
                                                        <td style="display: none;">{{ $GeneralVouchers->other }}</td>
                                                        {{-- <td>{{ number_format((float) $GeneralVouchers->quantity) }}</td>
                                                        <td>{{ number_format((float) $GeneralVouchers->rate) }}</td> --}}
                                                        <td>
                                                            @if (isset($GeneralVouchers->cheque_no))
                                                            {{ $GeneralVouchers->cheque_no }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (isset($GeneralVouchers->newparty))
                                                            {{ $GeneralVouchers->newparty->party_name }}
                                                            @endif
                                                        </td>
                                                        @php
                                                            $rowDebit = round((float) ($GeneralVouchers->debit ?? 0));
                                                            $rowCredit = round((float) ($GeneralVouchers->credit ?? 0));
                                                        @endphp
                                                        <td>{{ number_format($rowDebit) }}</td>
                                                        <td>{{ number_format($rowCredit) }}</td>
                                                        @php
                                                            $totalDebit = $totalDebit + $rowDebit;
                                                            $totalCredit = $totalCredit + $rowCredit;
                                                            $TotalQTY = $TotalQTY + (float) $GeneralVouchers->quantity;
                                                            $TotalRate = $TotalRate + (float) $GeneralVouchers->rate;
                                                        @endphp
                                                        <td>{{ number_format($openingOut - $openingIn + $totalDebit - $totalCredit) }}</td>
                                                    </tr>
                                                @endforeach

                                                {{-- <tr>
                                                    <td colspan="5">
                                                        <center><b>Total Without Opening Balance</b></center>
                                                    </td>
                                                    <td><b>{{ number_format((int) $TotalQTY) }}</b></td>
                                                    <td><b>{{ number_format((int) $TotalRate) }}</b></td>
                                                    <td><b>{{ number_format((int) $totalDebit) }}</b></td>
                                                    <td><b>{{ number_format((int) $totalCredit) }}</b></td>
                                                    <td><b>{{ number_format((int) $totalDebit - $totalCredit) }}</b>
                                                    </td>
                                                </tr> --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <center><b>Total</b></center>
                                                    </td>
                                                    <td>
                                                        <b>{{ number_format($openingOut + $totalDebit) }}</b>
                                                    </td>
                                                    <td>
                                                        <b>{{ number_format($openingIn + $totalCredit) }}</b>
                                                    </td>
                                                    <td>
                                                        <b>{{ number_format($openingOut - $openingIn + $totalDebit - $totalCredit) }}</b>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="7" style="color:#FF0000;text-align:center;">No Records
                                                        found</td>
                                                </tr>
                                            @endif
										</tbody>
									</table>
                                                </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('include.powerdby')
</body>

</html>