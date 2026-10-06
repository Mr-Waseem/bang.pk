	<?php
use App\Models\Setting;
$settings = Setting::where('id', 1)->first();
?>
<div class="container" style="width: 100%;">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p style="float: right; font-size: 12px;">{{$settings->website}} &emsp;&emsp;{{$settings->email}} &emsp;&emsp;{{$settings->phone}}</p>
            </div>
        </div>
    </div>