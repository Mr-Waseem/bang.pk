<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Appointment;
use App\Models\Setting;
use App\Models\SystemLogo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Appointment::with('employee')->OrderBy('id', 'desc')->get();
        return view('appointments.index', Compact('data'));
    }

    public function create()
    {
        $code = Appointment::OrderBy('id', 'asc')->get();

        //return $code;
        if (count($code) > 0) {
            $codes = (int)$code->last()->voucher_no + 1;
        } else {
            $codes = 1;
        }


        $employess = Party::where('account_type', 'EMPLOYEES')->pluck('party_name', 'id');
        //return $employess;
        return view('appointments.create', Compact('employess', 'codes'));
    }

    public function store(Request $request)
    {
        //return $request->all();
        $this->validate($request, [
            'voucher_no' => 'required',
            'date' => 'required',
            'type' => 'required'
        ]);
        $users = new Appointment();
        //dd($request->all());
        $users->voucher_no = $request->get('voucher_no');
        $users->date = $request->get('date');
        $users->type = $request->get('type');
        $users->employee_id = $request->get('employee_id');
        $users->image = bcrypt($request->get('image'));
        $users->id_front = $request->get('id_front');
        $users->id_back = $request->get('id_back');
        $users->created_by = Auth::User()->name;
        $users->save();


        if (!is_null($request->file('image'))) {
            $file = $request->file('image');
            $imageName = $request->file('image')->getClientOriginalName();
            $name = date('mdYHis') . uniqid() . $imageName;
            $file->move(public_path('upload/appointment'), $name);
            $users->image = 'upload/appointment/' . $name;
            $users->save();
        }

        if (!is_null($request->file('id_front'))) {
            $file = $request->file('id_front');
            $imageName = $request->file('id_front')->getClientOriginalName();
            $name = date('mdYHis') . uniqid() . $imageName;
            $file->move(public_path('upload/appointment/front'), $name);
            $users->id_front = 'upload/appointment/front/' . $name;
            $users->save();
        }

        if (!is_null($request->file('id_back'))) {
            $file = $request->file('id_back');
            $imageName = $request->file('id_back')->getClientOriginalName();
            $name = date('mdYHis') . uniqid() . $imageName;
            $file->move(public_path('upload/appointment/back'), $name);
            $users->id_back = 'upload/appointment/back/' . $name;
            $users->save();
        }

        Session::flash('flash_message', 'Appointment Added Successfully!');
        return redirect('appointments/create');
    }

    public function show($id)
    {
        $details = Appointment::with('employee')->where('id', $id)->get();
        //return $details;
        $settings  = Setting::where('id', '1')->get();
        $logo  = SystemLogo::where('id', '1')->get();
        return view('appointments.details', Compact('details', 'settings', 'logo'));
    }

    public function edit($id)
    {
        $edit = Appointment::FindOrFail($id);
        $employess = Party::where('account_type', 'EMPLOYEES')->pluck('party_name', 'id');
        return view('appointments.edit', Compact('edit', 'employess'));
    }

    public function update(Request $request, $id)
    {
        //return $request->all();
        $this->validate($request, [
            'voucher_no' => 'required',
            'date' => 'required',
            'type' => 'required'
        ]);
        $update = Appointment::findOrFail($id);
        //return $update;
        $update->update($request->all());

        if (!is_null($request->file('image'))) {
            $file = $request->file('image');
            $imageName = $request->file('image')->getClientOriginalName();
            $name = date('mdYHis') . uniqid() . $imageName;
            $file->move(public_path('upload/appointment'), $name);
            $update->image = 'upload/appointment/' . $name;
            $update->save();
        }

        if (!is_null($request->file('id_front'))) {
            $file = $request->file('id_front');
            $imageName = $request->file('id_front')->getClientOriginalName();
            $name = date('mdYHis') . uniqid() . $imageName;
            $file->move(public_path('upload/appointment/front'), $name);
            $update->id_front = 'upload/appointment/front/' . $name;
            $update->save();
        }

        if (!is_null($request->file('id_back'))) {
            $file = $request->file('id_back');
            $imageName = $request->file('id_back')->getClientOriginalName();
            $name = date('mdYHis') . uniqid() . $imageName;
            $file->move(public_path('upload/appointment/back'), $name);
            $update->id_back = 'upload/appointment/back/' . $name;
            $update->save();
        }

        Session::flash('flash_message', 'Appointment Updated Successfully!');
        return redirect('appointments');
    }

    public function destroy($id)
    {
        $delete = Appointment::findOrFail($id);
        $delete->delete();
        Session::flash('flash_message', 'Appointment Letter Deleted Successfully!');
        return redirect('appointments');
        return "Appointment Letter Successfully Deleted!";
    }
}
