<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Session;
class RatingController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $taxes = Rating::OrderBy('id', 'asc')->get();
        return view('ratings.index', Compact('taxes'));
    }

    public function create()
    {
        return view('ratings.create');
    }

    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'name' => 'required',
            'review' => 'required'
        ]);
        Rating::create($request->all());
        Session::flash('flash_message', 'Rating Added Successfully!');
        return redirect('ratings/create');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = Rating::findOrFail($id);
        return view('ratings.edit', Compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'review' => 'required'
        ]);
        $update = Rating::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'Rating Updated Successfully!');
        return redirect('ratings');
    }

    public function destroy($id)
    {
        $delete = Rating::findOrFail($id);
        $delete->delete();
        Session::flash('flash_message', 'Rating Deleted Successfully!');
        return redirect('ratings');
        // return "Rating Deleted Successfully!";
    }
}
