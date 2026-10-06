	<?php
use App\Models\Setting;
$settings = Setting::where('id', 1)->first();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <p class="text-right">Phone: {{$settings->phone}} &emsp;&emsp; EMAIL: {{$settings->email}}
            </p>
            <p class="text-center text-capitalize mt-5">This is system generated invoice no signature required</p>
        </div>
    </div>
</div>
