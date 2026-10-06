<title>Employment Form</title>
<style>

body{
    margin-top:20px;
    background:#f8f8f8
}
</style>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

<script src="{{asset('js/test.js')}}"></script>
<link href="{{asset('css/test.css')}}" rel="stylesheet">
<br/>


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



              {{-- @include("/include.header") --}}
              {{-- <b style="float:right;">Date: {{date("d/m/Y", Strtotime(12-12-2020))}}</b>
              <br/> --}}
              <h3 style="text-align: center;" onclick="window.print();"><u>JOBCARD</u></h3>
             
              <!-- <ul class="nav nav-tabs">
                <li class="nav-item"><a href="" class="active nav-link">Settings</a></li>
              </ul> -->
              <div class="tab-content pt-3">
                <div class="tab-pane active">
                  {{-- <form class="form"> --}}
                    <div class="row">
                      <div class="col">
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Date:</label>&nbsp;&nbsp;&nbsp;<u><b>{{date("d/m/Y", strtotime($order[0]->created_at))}} | {{date("h:i:a", strtoTime($order[0]->created_at))}}</b></u>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">JobCard No: </label>&nbsp;&nbsp;&nbsp;<u><b>{{$order[0]->id}}</b></u>
                            </div>
                          </div>
                         <!--  <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">CNIC:</label>
                              <u><b>{{$order[0]->cnic}}</b></u>
                            </div>
                          </div><div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Education: </label>
                              <u><b>{{$order[0]->education}}</b></u>
                            </div>
                          </div> -->
                        </div>

                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Reached Date:</label>
                              &nbsp;&nbsp;&nbsp;<u><b> {{date("d/m/Y", strtotime($order[0]->date))}}</b></u>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Reached Time: </label>
                              &nbsp;&nbsp;&nbsp;<u><b>{{$order[0]->time}}</b></u>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <label style="color:black; font-weight: 700;">Member Name:</label>
                                &nbsp;&nbsp;&nbsp;<u><b> 
                                    @if($order[0]->users) 
                                    {{$order[0]->users->name}}
                                    @endif</b></u>
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label style="color:black; font-weight: 700;">Email: </label>
                                &nbsp;&nbsp;&nbsp;<u><b>@if($order[0]->users) 
                                    {{$order[0]->users->email}}
                                    @endif</b></u>
                              </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                  <label style="color:black; font-weight: 700;">Phone:</label>
                                  &nbsp;&nbsp;&nbsp;<u><b> @if($order[0]->users)
                                    {{$order[0]->users->phone}}
                                    @endif</b></u>
                                </div>
                              </div>
                              <div class="col">
                                <div class="form-group">
                                  <label style="color:black; font-weight: 700;">City: </label>
                                  &nbsp;&nbsp;&nbsp;<u><b>{{$order[0]->users->city->name}}</b></u>
                                </div>
                              </div>
                          </div>

                          {{-- <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <label style="color:black; font-weight: 700;">Society:</label>
                                &nbsp;&nbsp;&nbsp;<u><b> @if($order[0]->users) 
                                    {{$order[0]->users->name}} | {{$order[0]->users->id}}
                                    @endif</b></u>
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label style="color:black; font-weight: 700;">Phase: </label>
                                &nbsp;&nbsp;&nbsp;<u><b>@if($order[0]->users) 
                                    {{$order[0]->users->email}}
                                    @endif</b></u>
                              </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                  <label style="color:black; font-weight: 700;">Block:</label>
                                  &nbsp;&nbsp;&nbsp;<u><b> @if($order[0]->users)
                                    {{$order[0]->users->phone}}
                                    @endif</b></u>
                                </div>
                              </div>
                              <div class="col">
                                <div class="form-group">
                                  <label style="color:black; font-weight: 700;">Ho: </label>
                                  &nbsp;&nbsp;&nbsp;<u><b>{{$order[0]->users->city->name}}</b></u>
                                </div>
                              </div>
                          </div> --}}

                          <div class="row">
                            <!-- <div class="col">
                              <div class="form-group">
                                <label style="color:black; font-weight: 700;">Permanent Address:</label> <u><b>{{$order[0]->permanent}}</b></u>
                              </div>
                            </div> -->
                            <div class="col">
                              <div class="form-group">
                                <label style="color:black; font-weight: 700;">Address: </label>
                                &nbsp;&nbsp;&nbsp;<u><b>@if($order[0]->users->society->name)Society: {{$order[0]->users->society->name}}@endif, @if($order[0]->users->phase->name)Phase: {{$order[0]->users->phase->name}}@endif, @if($order[0]->users->block->name)Block {{$order[0]->users->block->name}}@endif, @if($order[0]->users->road)Road: {{$order[0]->users->road}}@endif, @if($order[0]->users->street)Street: {{$order[0]->users->street}}@endif, @if($order[0]->users->city->name)City: {{$order[0]->users->city->name}}@endif.</b></u>
                              </div>
                            </div>
  
                          </div>


                        <div class="row">
                          <!-- <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Permanent Address:</label> <u><b>{{$order[0]->permanent}}</b></u>
                            </div>
                          </div> -->
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Customer Message: </label>
                              &nbsp;&nbsp;&nbsp;<u><b>{{$order[0]->message}}</b></u>
                            </div>
                          </div>

                        </div>

                      
                         <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Service Name</th>
                                    <th>Quantity</th>
                                    <th>Unit.Price</th>
                                    <th>Total.Pice</th>
                                </tr>
                            </thead>
                            <tbody id="items">
                                @php $quantity=0; $total = 0; @endphp
					            @foreach($order[0]->order_details as $orders)
                                <tr>
                                    <td>{{$orders->services_prices->name}}</td>
						<td>{{$orders->quantity}}</td>
						<td>{{number_format($orders->price)}}</td>
						<td>{{number_format($orders->total)}}</td>
                                </tr>
                                @php 
					$quantity = $quantity + $orders->quantity; 
					$total = $total + $orders->total; 
					@endphp
					@endforeach

                    <tr>
						<td>TOTAL QUANTITY</td>
						<td>{{$quantity}}</td>
						<td>TOTAL PRICE</td>
						<td>{{number_format($total)}}</td>
					</tr>


                            </tbody>
                        </table><br/>
                        {{-- <div class="mb-2" style="text-align: center;"><b><h2><u>Reference Information</u></h2></b></div> --}}



         
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">CUSTOMER</label>&nbsp;<u><br/><br/>_______________________________________</u>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">SUPERVISOR:</label>&nbsp;<u><b><br/><br/>_______________________________________</b></u>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">ACCOUNTANT:</label>&nbsp;<u><b><br/><br/>_______________________________________</b></u>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">DM:</label>&nbsp;<u><b><br/><br/>_______________________________________</b></u>
                            </div>
                          </div>
                        </div>
                        {{-- <br/><br/><br/><br/>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Company Signature:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><b>_______________________________________</b></u>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label style="color:black; font-weight: 700;">Company Stamp:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><b>_________________________________________</b></u>
                            </div>
                          </div>
                        </div> --}}

                      </div>
                    </div>
                    

                  {{-- </form> --}}

            

                </div>
              </div>
            
