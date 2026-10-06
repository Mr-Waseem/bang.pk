<head>
    <link href="{{ asset('css/bg.css') }}" rel="stylesheet">
</head>
<center>
    <h3><u><b id="systemTitle">{{ $company_detail[0]->system_name }}</b></u></h3>
</center>
<center><b id="systemDetail">{{ $company_detail[0]->address }}</b></center>
<center><b id="systemDetail">PH :{{ $company_detail[0]->phone }}</b>
    <center>
        <center><b id="systemDetail">Email :{{ $company_detail[0]->email }}</b>
            <center>
                <br>
                <span style="float: right;margin-top: -19px " id="systemDetail">
                    @php
                        $t = time();
                        $t . '<br>';
                        echo date('d/m/Y', $t);
                    @endphp
                </span>
