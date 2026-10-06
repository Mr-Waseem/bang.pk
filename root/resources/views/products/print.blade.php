<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Parties</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --border-color: #e0e0e0;
            --text-color: #333;
            --light-bg: #f9f9f9;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.4;
            color: var(--text-color);
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        
        .page-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 20px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        h2 {
            color: var(--primary-color);
            text-align: center;
            margin: 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--secondary-color);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 0.9em;
        }
        
        th, td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8em;
            padding: 10px 12px;
        }
        
        tr:nth-child(even) {
            background-color: var(--light-bg);
        }
        
        tr:hover {
            background-color: rgba(0,0,0,0.02);
        }
        
        .header {
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
            }
            
            th, td {
                padding: 6px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="header">
            @include('include.header')
        </div>
        
        <div class="card">
            <div class="card-body">
                <h2>ALL PRODUCTS INFORMATION</h2>
                <center><div class="report-date">Generated on: {{ date('F j, Y') }}</div>  </center>
                <table class="table table-bordered">
										<thead>
											<tr>
												<th>Sr.#</th>
												<th>Code</th>
												<th>Product&nbsp;Name</th>
												<th>CATEGORY</th>
												<th>UOM</th>
												<th>Tax%</th>
												<th>Price</th>
						
											</tr>
										</thead>
										<tbody>
											<?php $sum = 1; ?>
											@foreach ($products as $product)
												<tr>
													<td><?php echo $sum; ?></td>
													<td>{{ $product->product_code }}</td>
													<td>{{ $product->product_name }}</td>
													<td>
														@if ($product->catagories != null)
															{{ $product->catagories->catagory_name }}
														@else
															<span style="color:red;">{{ 'NO CATAGORY' }}</span>
														@endif
													</td>
			
													<td>{{ $product->uom }}</td>
													<td style="display: none">{{ $product->pack_type }}</td>
													<td style="display: none">{{ $product->pack_weight }}</td>
													<td>{{ number_format($product->tax) }}</td>
													<td>{{ number_format($product->product_price) }}</td>
													<td style="display: none">{{ number_format($product->alert) }}</td>
													
			
													
												</tr>
												<?php $sum = $sum + 1; ?>
											@endforeach
										</tbody>
									</table>
            </div>
        </div>
        
        @if($company_detail[0]->white_label == 0)
            @include('include.powerdby2')
        @endif
    </div>
</body>
</html>