<div class="row" style="border-bottom: 2px solid;">
    <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
        <div class="text-center text-sm-left mb-2 mb-sm-0">
            <h3 class="pt-sm-2 pb-1 mb-0 text-nowrap" style="color:black;">From: {{ session()->get('company_name') }}
            </h3>
            <p class="mb-0" style="color:black; font-weight: 700;">Phone:
                {{ session()->get('company_phone') }}</p>
            <p class="mb-0" style="color:black; font-weight: 700;">Email:
                {{ session()->get('company_email') }}</p>

        </div>
        <div class="text-center text-sm-right">
            <br />
            <div><small style="color:black; font-weight: 700;">Address:
                    {{ session()->get('company_address') }}</small></div>
            <div><small style="color:black; font-weight: 999; font-size:16px;">NTN:
                    {{ session()->get('company_ntn') }}</small></div>
        </div>
    </div>
</div>
<script>
    function printInvoice() {
        document.querySelector('.btn-info').style.display = 'none';
        window.print();
    }
</script>
