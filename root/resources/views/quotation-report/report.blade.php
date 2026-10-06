<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<!-- <body onload="window.print();"> -->

<body>
	<button onclick="goBack()" class="btn" id="Backbutton" autofocus>Go Back</button>
    <button class="btn btn-primary" id="Printbutton" onclick="hideBtn()">Print <i class="fa fa-print"></i></button>
    <div class="content-wrapper">
        <section class="content">
            @include('header.report')

            <div class="panel panel-default">
                <div class="panel-heading"><b>Quotation Report&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Account ID:
                        {{ $party[0]->id }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name: {{ $party[0]->party_name }}</b></div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Vr.No</th>
                                <th>Date</th>
                                <th>Validity Date</th>
                                <th>Party</th>
                                <th>Reference</th>
                                <th>Our Best Prices</th>
                                <th>Note</th>
                                <th>Best Regards</th>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Rate</th>
                                <th>GST</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sum = 1;
                            $gst = 0;
                            $amount = 0; ?>

                            @if (count($quotations) > 0)
                                @foreach ($quotations[0]->quotation_details as $quotation)
                                    <tr>
                                        <td>{{ $sum }}</td>
                                        <td>{{ $quotations[0]->vr_no }}</td>
                                        <td>{{ date('d/m/Y', strtotime($quotations[0]->created_at)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($quotations[0]->to_date)) }}</td>
                                        <td>{{ $quotations[0]->parties->party_name }}</td>
                                        <td>{{ $quotations[0]->reference }}</td>
                                        <td>{{ $quotations[0]->best_prices }}</td>
                                        <td>{{ $quotations[0]->note }}</td>
                                        <td>{{ $quotations[0]->best_regards }}</td>
                                        <td>{{ $quotation->products->product_name }}</td>
                                        <td>{{ $quotation->description }}</td>
                                        <td>{{ $quotation->rate }}</td>
                                        <td>{{ $quotation->gst }}</td>
                                        <td>{{ $quotation->amount }}</td>

                                        <!-- <td>
      @if ($quotation->narration == null)
INV#:{{ $quotation->invoice_no }}
@endif
      {{ $quotation->narration }}
     </td> -->

                                        <?php
                                        $gst = $gst + $quotation->gst;
                                        $amount = $amount + $quotation->amount;
                                        $sum = $sum + 1;
                                        ?>


                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="12">
                                        <center><b style="float:right;">Total</b></center>
                                    </td>

                                    <td>{{ $gst }}</td>
                                    <td>{{ $amount }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="14" style="color:#FF0000;text-align:center;">No Records found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

<script>
	function goBack() {
        window.history.back()
    }

    function hideBtn() {
        document.getElementById('Backbutton').style.display = 'none';
        document.getElementById('Printbutton').style.display = 'none';
        window.print();
    }
</script>

</body>

</html>
