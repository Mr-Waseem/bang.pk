<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catagory;
use Illuminate\Support\Facades\Session;
use Excel;

class CatagoryController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $catagories = Catagory::OrderBy('catagory_name', 'asc')->get();
    return view('catagories.index', Compact('catagories'));
  }

  public function create()
  {
    return view('catagories.create');
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'catagory_code' => 'required',
      'catagory_name' => 'required'
    ]);
    Catagory::create($request->all());
    Session::flash('flash_message', 'Catagory Added Successfully!');
    return redirect('catagories/create');
  }

  public function show($id)
  {
    //
  }

  public function edit($id)
  {
    $edit = Catagory::findOrFail($id);
    return view('catagories.edit', Compact('edit'));
  }

  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'catagory_code' => 'required',
      'catagory_name' => 'required'
    ]);
    $update = Catagory::findOrFail($id);
    $update->update($request->all());
    Session::flash('flash_message', 'Catagory Updated Successfully!');
    return redirect('catagories');
  }

  public function destroy($id)
  {
    $delete = Catagory::findOrFail($id);
    $delete->delete();
    return "Catagory Deleted Successfully!";
  }

  public function createImportExcel()
  {
    return view('catagories.importExcel.create');
  }


  public function ImportExcel(Request $request)
  {
    $this->validate($request, [
      'import_file' => 'required'
    ]);
    $path = $request->file('import_file')->getRealPath();
    $results = Excel::load($path)->get();
    if (!empty($results) && $results->count()) {
      foreach ($results as $rows) {
        foreach ($rows as $row) {
          if (($row->catagory_name) != null) {
            Catagory::create([
              'catagory_code'  => $row->catagory_code,
              'catagory_name'  => $row->catagory_name,
            ]);
          }
        }
      }
    }

    Session::flash('flash_message', 'Excel Sheet Imported Successfully!');
    return redirect('catagories/importExcel/create');
  }
}
