<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use Illuminate\Support\Facades\Session;
class ClientsController extends Controller
{
           public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $taxes = Clients::OrderBy('id', 'asc')->get();
        return view('clients.index', Compact('taxes'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $data = $request->only(['name']);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $destination = base_path('../upload/clients');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $imageName);
            $data['logo'] = $imageName;
        }

        Clients::create($data);

        Session::flash('flash_message', 'Client Added Successfully!');
        return redirect('clients/create');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = Clients::findOrFail($id);
        return view('clients.edit', Compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $update = Clients::findOrFail($id);
        $data = $request->only(['name']);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $destination = base_path('../upload/clients');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $imageName);
            // delete old logo if exists
            if ($update->logo) {
                $oldPath = $destination . '/' . $update->logo;
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
            $data['logo'] = $imageName;
        }

        $update->update($data);
        Session::flash('flash_message', 'Client Updated Successfully!');
        return redirect('clients');
    }

    public function destroy($id)
    {
        $delete = Clients::findOrFail($id);
        
        // Delete logo file if exists
        if ($delete->logo) {
            $logoPath = base_path('../upload/clients/' . $delete->logo);
            if (file_exists($logoPath)) {
                @unlink($logoPath);
            }
        }
        
        $delete->delete();
        Session::flash('flash_message', 'Client Deleted Successfully!');
        return redirect('clients');
    }
}
