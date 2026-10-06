<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GRN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <style>
        @media print {
            body {
                padding: 15px;
                font-size: 14px;
                color: #000;
            }
            .container {
                width: 100%;
            }
            .no-print {
                display: none;
            }
            .header-section {
                margin-bottom: 20px;
            }
            .table {
                border-collapse: collapse;
                width: 100%;
            }
            .table th, .table td {
                padding: 8px;
                border: 1px solid #ddd;
            }
            .table th {
                background-color: #f5f5f5;
            }
            .footer {
                margin-top: 30px;
                font-size: 12px;
            }
        }
        @media screen {
            body {
                background-color: #f8f9fa;
                padding: 20px;
            }
            .container {
                background-color: white;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
                padding: 25px;
                border-radius: 5px;
                margin-bottom: 30px;
            }
            .print-button {
                margin-bottom: 20px;
            }
        }
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #333;
        }
        .company-logo {
            max-height: 70px;
            margin-bottom: 10px;
        }
        .header-title {
            text-align: center;
            margin: 15px 0;
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        .customer-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #3498db;
        }
        .summary-row {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .divider {
            border-top: 1px dashed #ccc;
            margin: 15px 0;
        }
        .signature-area {
            margin-top: 50px;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 250px;
            margin: 40px 0 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Print Button for Screen View -->
        <div class="no-print text-right print-button">
            <button class="btn btn-primary" onclick="window.print()">Print GRN</button>
        </div>
        
        <!-- Header Section -->
        <div class="row header-section">
            <div class="col-xs-5">
                <!-- <img src="/upload/logo/logo.png" class="company-logo"> -->
				 <h1 class="header-title">{{$company->CompanyName}}</h1>
            </div>
            <div class="col-xs-7 text-right">
                <h2 class="header-title">GRN</h2>
            </div>
        </div>
        
        <div class="divider"></div>
        
        <!-- Customer and Document Details -->
        <div class="row">
            <div class="col-xs-6 customer-details">
                <h4>Customer Details</h4>
                <p><strong>Name:</strong> {{$purchase_detail->parties->party_name}}</p>
                <p><strong>Address:</strong> {{$purchase_detail->parties->address}}</p>
                <!-- <p><strong>Tel:</strong> {{$purchase_detail->parties->ntn}}</p> -->
            </div>
            <div class="col-xs-6">
                <div class="pull-right">
                    <p><strong>Date:</strong> {{date("d/m/Y", strtotime($purchase_detail->date))}}</p>
                    <!-- <p><strong>Challan Type:</strong> {{$purchase_detail->type}}</p> -->
                    <p><strong>GRN No:</strong> {{$purchase_detail->dcn_no}}</p>
                    <!-- <p><strong>Outward GPN:</strong> {{$purchase_detail->outward_gpn}}</p> -->
                </div>
            </div>
        </div>
        
        <div class="divider"></div>
        
        <!-- Product Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Product</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Unit</th>
                    <!-- <th class="text-right">Rate</th>
                    <th class="text-right">Amount</th> -->
                </tr>
            </thead>
            <tbody>
                <?php $sum = 1; $nettotal = 0; $totalqty = 0; $totalcost = 0; ?>
                @foreach ($purchase_detail->challan_details as $details)
                <tr>
                    <td><?php echo $sum; ?></td>
                    <td>{{$details->products->product_code}}</td>
                    <td>{{$details->products->product_name }}</td>
                    <td class="text-center">{{$details->quantity}}</td>
                    <td class="text-center">{{$details->uom}}</td>
                    <!-- <td class="text-right">{{number_format($details->rate, 2)}}</td>
                    <td class="text-right">{{number_format($details->amount, 2)}}</td> -->
                </tr>
                <?php 
                $totalqty = $totalqty + $details->quantity;
                $nettotal = $nettotal + $details->rate;
                $totalcost = $totalcost + $details->amount;
                ?>
                <?php $sum = $sum + 1; ?>
                @endforeach
                
                <!-- Summary Rows -->
				  <tr class="summary-row">
                    <td colspan="3" class="text-right">Total</td>
                    <td class="text-right"><?php echo number_format((int)$totalqty, 2); ?></td>
                </tr>
                <!-- <tr class="summary-row">
                    <td colspan="3" class="text-right">Total Rate</td>
                    <td class="text-right"><?php echo number_format((int)$nettotal, 2); ?></td>
                </tr>
                <tr class="summary-row">
                    <td colspan="3" class="text-right">Total Amount</td>
                    <td class="text-right"><?php echo number_format((int)$totalcost, 2); ?></td>
                </tr> -->
            </tbody>
        </table>
        
        <!-- Notes Section -->
        <div class="row">
            <div class="col-xs-12">
                <h4>Notes:</h4>
                <p>________________________________________________________________</p>
                <p>________________________________________________________________</p>
            </div>
        </div>
        
        <!-- Signature Area -->
        <div class="row signature-area">
            <div class="col-xs-4">
                <div class="signature-line"></div>
                <p>Customer Signature</p>
            </div>
            <div class="col-xs-4 col-xs-offset-4 text-right">
                <div class="signature-line"></div>
                <p>Authorized Signature</p>
            </div>
        </div>
        
        <!-- Footer -->
        @include('include.powerdby2')
    </div>

    <script>
        // Auto-print when page loads (if needed)
        window.onload = function() {
            // Uncomment the line below if you want to automatically print
            // window.print();
        };
    </script>
</body>
</html>