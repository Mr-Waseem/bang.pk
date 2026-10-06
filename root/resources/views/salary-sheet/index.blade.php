<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SALARY SHEET</title>
    <link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap4/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        tr {
            line-height: 0px;
        }

        .table thead th,
        .table td {
            border: 1px solid black;
        }

    </style>
</head>

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
                                    <h3 class="text-center mt-3"><u>SALARY SHEET</u></h3>
                                    <p class="text-center">
                                        <small class="font-weight-bold">Period: {{ $fromDate }} to
                                            {{ $toDate }}</small>
                                    </p>
                                </div>
                                <br>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Name</th>
                                            <th>CNIC</th>
                                            <th>Designation</th>
                                            <th>Deduction</th>
                                            <th>Basic Pay</th>
                                            <th>Allowance</th>
                                            <th>Deduction</th>
                                            <th>Net Pay</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $key=>$value)
                                            @php
                                                $total = 0;
                                                $total += $value->basic_salary + $value->allowance;
                                                $deduction = 0;
                                                $deduction = $total - $value->deduction;
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->party_name }}</td>
                                                <td>{{ $value->cnic }}</td>
                                                <td>{{ $value->designation }}</td>
                                                <td>{{ $value->status }}</td>
                                                <td>{{ number_format($value->basic_salary) }}</td>
                                                <td>{{ number_format($value->allowance) }}</td>
                                                <td>{{ number_format($deduction) }}</td>
                                                <td>{{ number_format($total - $deduction) }}</td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" align="center"><b class="text-danger">Record Not
                                                        Found</b></td>
                                            </tr>
                                        @endforelse
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
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p class="text-right">POWERED BY: PROFESSIONAL ACCOUNTING SERVICES &emsp;&emsp; EMAIL:
                    info@paservices.pk</p>
            </div>
        </div>
    </div>

</body>

</html>
