<title>Appointment Form</title>
<style>

body{
    margin-top:20px;
    background:#f8f8f8
}
</style>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

<script src="{{asset('js-details/test.js')}}"></script>
<link href="{{asset('css-details/test.css')}}" rel="stylesheet">
{{-- Debug: {{ config('database.connections.mysql.database') }} --}}
<br/>

<div class="container">
<div class="row flex-lg-nowrap">
  <!-- <div class="col-12 col-lg-auto mb-3" style="width: 200px;">
    <div class="card p-3">
      <div class="e-navlist e-navlist--active-bg">
        <ul class="nav">
          <li class="nav-item"><a class="nav-link px-2 active" href="./overview.html"><i class="fa fa-fw fa-bar-chart mr-1"></i><span>Overview</span></a></li>
          <li class="nav-item"><a class="nav-link px-2" href="./users.html"><i class="fa fa-fw fa-th mr-1"></i><span>CRUD</span></a></li>
          <li class="nav-item"><a class="nav-link px-2" href="./settings.html"><i class="fa fa-fw fa-cog mr-1"></i><span>Settings</span></a></li>
        </ul>
      </div>
    </div>
  </div> -->

  <div class="col">
    <div class="row">
      <div class="col mb-3">
        <div class="card">
          <div class="card-body">
            <div class="e-profile">

              @include("include.header")
              <!-- <b style="float:right;">Date: {{date("d/m/Y", Strtotime($details[0]->created_at))}}</b>
              <br/> -->
              <h3 style="text-align: center;"><u>APPOINTMENT LETTER FOR {{$details[0]->type}}</u></h3>
              <div class="row" style="">
  <div class="col-12 col-sm-auto mb-3">
    <div class="mx-auto" style="width: 140px;">
      <!-- <span class="badge badge-secondary">administrator</span> -->
      <!-- <div class="text-muted"><small>{{$settings[0]->address}}</small></div> -->
      <!-- <div><small>{{$settings[0]->address}}</small></div> -->
      <br/>
      <!-- <div><small style="color:black; font-weight: 700;">Address: 
      {!! nl2br(e($settings[0]->address)) !!}</small></div>
      <div><small style="color:black; font-weight: 700;">Address: 
      {!! nl2br(e($settings[0]->address2)) !!}</small></div>
      <div><small style="color:black; font-weight: 700;">City: {{$settings[0]->city}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;State: {{$settings[0]->state}}</small></div> -->
      <div><small style="color:black; font-weight: 999; font-size:16px;">Dear Sir!</small></div>
      <!-- <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
        <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">140x140</span>
      </div> -->
      
    </div>
  </div>
  <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
    <div class="text-center text-sm-left mb-2 mb-sm-0">
     
     
      
      <!-- <div class="text-muted"><small style="color:black; font-weight: 700;">Admission Date: {{$settings[0]->email}}</small></div> -->

    </div>
    @if($details[0]->image)
     <div class="text-center text-sm-right">
      <img src="/{{$details[0]->image}}" style="height: 140px; width: 140px;">
    </div>
    @endif
  </div>
</div>









              <div class="row">
                <!-- <div class="col-12 col-sm-auto mb-3">
                  <div class="mx-auto" style="width: 140px;">
                     <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                      <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">140x140</span>
                    </div>
                    <img src="{{asset('/root/upload/childs')}}/{{$details[0]->image}}" style="height: 140px; width: 140px;  border: 1px solid;">

                    @if($details[0]->image != null)
                    <img src="{{asset('/root/upload/childs')}}/{{$details[0]->image}}" style="height: 140px; width: 140px; border: 1px solid;">
                    @else
                    <img src="{{asset('/root/upload/dummy.png')}}" style="height: 140px; width: 140px; border: 1px solid;">
                    @endif
                    
                  </div>

                </div> -->
                <!-- <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                  <div class="text-center text-sm-left mb-2 mb-sm-0">
                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap" style="color:black; font-weight: 700;">Employee Name: {{$details[0]->name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registration No: {{$details[0]->id}}</h4>
       

                  </div>
          
                </div> -->
              </div>
              <!-- <ul class="nav nav-tabs">
                <li class="nav-item"><a href="" class="active nav-link">Settings</a></li>
              </ul> -->
              <div class="tab-content pt-3">
                <div class="tab-pane active">
                  <form class="form">
                    <div class="row">
                      <div class="col">
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <u><b>I am pleased to inform you that you have been appointed for the role of {{$details[0]->type}} at {{$settings[0]->title}}. This is an official letter confirming your employment which starts from {{date("d/m/Y", Strtotime($details[0]->date))}} under the folowing terms and conditions.</b></u>
                            </div>
                          </div>
                          <!-- <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Religion: </label>&nbsp;&nbsp;&nbsp;<u><b>{{$details[0]->religion}}</b></u>
                            </div>
                          </div> -->
                         <!--  <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">CNIC:</label>
                              <u><b>{{$details[0]->cnic}}</b></u>
                            </div>
                          </div><div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Education: </label>
                              <u><b>{{$details[0]->education}}</b></u>
                            </div>
                          </div> -->
                        </div>

                    

                        <div class="row">
                          <div class="col">
                            <div class="form-group">
    <!--                        <table style="border: 2px solid; width: 100%;-->
    <!--height: 200px;">-->
    <!--                          <tr>-->
    <!--                            <td></td>-->
    <!--                          </tr>-->
    <!--                        </table>-->
       <!--<u><b>1: Your Salary will commence at {{number_format($details[0]->employee->salary)}}/- per month.</b></u><br/>-->
      <u><b>2: Duty timnigs are 9am to 7pm.</b></u><br/>
      <!--<u><b>3: Company will provide you 15 days with Paid leave after one year.</b></u><br/>-->
      <u><b>4: Probation period will be 90 days.</b></u><br/><br/>
      <u><b>Note: After one year salary will be increased on your performance</b></u>
                            </div>
                          </div>
                        <!--   <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Postal Address: </label>
                              <u><b>{{$details[0]->temporary}}</b></u>
                            </div>
                          </div> -->

                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Employee Name:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><b>{{$details[0]->employee->party_name}}</b></u>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Employee Phone:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><b>{{$details[0]->employee->phone}}</b></u>
                            </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Address:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><b>{{$details[0]->employee->address}}</b></u>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Salary:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><b>{{$details[0]->employee->salary}}</b></u>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <!-- <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Address:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><b>{{$details[0]->employee->address}}</b></u>
                            </div>
                          </div> -->
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Signature:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><b>_________________________________________</b></u>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <!-- <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Permanent Address:</label> <u><b>{{$details[0]->permanent}}</b></u>
                            </div>
                          </div> -->
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">RECOMMENDATIONS: </label><br/>
                      <u><b>1: Civil ID Copy.</b></u><br/>
      <u><b>2: Passport size picture.</b></u><br/>
      <u><b>3: One reference from your family member.</b></u><br/>
      <u><b>Please sign and return this letter to signal your acceptance of this offer and all its terms. Congratulations and welcome to {{$settings[0]->system_name}}. </b></u><br/><br/>
                            </div>
                          </div>

                        </div>

                      
                       
                        </table>
                        <div class="mb-2" style="text-align: center;"><b><h2><u>CNIC (FRONT | BACK)</u></h2></b></div>
                        

<div class="row" style="border-bottom: 2px solid;">
  
  <div class="col-12 col-sm-4 mb-5">
    @if($details[0]->id_front)
    <div class="mx-auto" style="">
      <img src="/{{$details[0]->id_front}}" style="width: 125%;">
    </div>
    @endif
  </div>
   <div class="col-12 col-sm-2 mb-5">
    
  </div>
  <div class="col-12 col-sm-4 mb-5">
    @if($details[0]->id_back)
    <div class="mx-auto" style="">
      <!-- <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
        <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">140x140</span>
      </div> -->
      <img src="/{{$details[0]->id_back}}" style="width: 125%;">
    </div>
    @endif
  </div>

<!--   <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
    <div class="text-center text-sm-left mb-2 mb-sm-0">
    


    </div>
    <div class="text-center text-sm-right">
     <div class="mx-auto" style="">

      <img src="/{{$details[0]->id_back}}" style="">
    </div>
    </div>
  </div> -->
</div>


                      

                        <!-- <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Father:</label>&nbsp;&nbsp;&nbsp;<u><b>{{$details[0]->reference_father}}</b></u>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">CNIC: </label>
                              &nbsp;&nbsp;&nbsp;<u><b>{{$details[0]->reference_cnic}}</b></u>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Address: </label>
                              &nbsp;&nbsp;&nbsp;<u><b>{{$details[0]->reference_address}}</b></u>
                            </div>
                          </div>

                        </div> -->
                        <br/><br/><br/><br/>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">GM Signature</label>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">DM Signature</label>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">CEO Signature</label>
                            </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">_______________________________________</label>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">_______________________________________</label>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">_______________________________________</label>
                            </div>
                          </div>
                        </div>

                       
                      </div>
                    </div>
                     
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    
    </div>

  </div>
</div>
</div>