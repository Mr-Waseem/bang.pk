<?php
use App\Setting;
use App\SystemLogo;
$settings  = Setting::where('id', '1')->get();
$logo  = SystemLogo::where('id', '1')->get();
?>
<div class="row" style="border-bottom: 2px solid;">
  <div class="col-12 col-sm-auto mb-3">
    <div class="mx-auto" style="width: 140px;">
      <!-- <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
        <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">140x140</span>
      </div> -->
      <img src="{{asset('/upload/logo')}}/{{$logo[0]->image}}" style="height: 140px; width: 140px;">
    </div>
  </div>
  <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
    <div class="text-center text-sm-left mb-2 mb-sm-0">
      <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap" style="color:black; font-weight: 700;">{{$settings[0]->title}}</h4>
      <p class="mb-0" style="color:black; font-weight: 700;">Phone: {{$settings[0]->phone}}</p>
      {{-- <p class="mb-0" style="color:black; font-weight: 700;">Phone: {{$settings[0]->phone2}}</p> --}}
      <p class="mb-0" style="color:black; font-weight: 700;">Email: {{$settings[0]->email}}</p>
      {{-- <p class="mb-0" style="color:black; font-weight: 700;">Website: {{$settings[0]->website}}</p> --}}
      <!-- <div class="text-muted"><small style="color:black; font-weight: 700;">Admission Date: {{$settings[0]->email}}</small></div> -->

    </div>
    <div class="text-center text-sm-right">
      <!-- <span class="badge badge-secondary">administrator</span> -->
      <!-- <div class="text-muted"><small>{{$settings[0]->address}}</small></div> -->
      <!-- <div><small>{{$settings[0]->address}}</small></div> -->
      <br/>
      <!-- {{-- <div><small style="color:black; font-weight: 700;">Address: 
      {!! nl2br(e($settings[0]->address)) !!}</small></div> --}}
      {{-- <div><small style="color:black; font-weight: 700;">ONE CALL SOLUTION</small></div> --}}
      <b class="mb-0" style="color:black; font-weight: 700;">ONE CALL SOLUTION</b><br/>
      {{-- <div><small style="color:black; font-weight: 700;">UAN: 1111-8-1111</small></div> --}}
      <b class="mb-0" style="color:black; font-weight: 700;">UAN: 1111-8-1111</b>
      <div><small style="color:black; font-weight: 700;">0320 0777773</small></div>
      <div><small style="color:black; font-weight: 700;">0320 0777774</small></div>
      {{-- <div><small style="color:black; font-weight: 700;">Address: 
      {!! nl2br(e($settings[0]->address2)) !!}</small></div> --}}
      {{-- <div><small style="color:black; font-weight: 700;">STRN: {{$settings[0]->city}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NTN: {{$settings[0]->state}}</small></div>
      <div><small style="color:black; font-weight: 999; font-size:16px;">NTN: {{$settings[0]->ntn}}</small></div> --}}
    </div> -->
  </div>
</div>