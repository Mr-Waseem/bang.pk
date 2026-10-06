<br><br><br>
<h1 style="font-size: 40px;text-align: center;font-weight: 900;letter-spacing: 0px;margin-top:-50px;">{{ session()->get('company_name') }}</h1>
<p style="font-weight:900; text-align: center;margin-top:10px;margin-bottom:10px;">
    <b>STRN: {{ session()->get('company_strn') }} 
        &emsp;NTN: {{ session()->get('company_ntn') }}
        <!--&emsp;Brand: Excel Lighting-->
    </b>
</p>
<Address style="text-align: center;">{{ session()->get('company_address') }}</Address>