<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function index()
    {
        $recipe =  Recipe::Orderby('name')->get();
        return view('recipe.index', Compact('recipe'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|unique:recipes',
            'name' => 'required',
        ]);
        Recipe::create($request->all());
        Session::flash('flash_message', 'Recipe added Successfully!');
        return redirect('recipe');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {

        //$data = Division::findOrFail($id);
        $ID = $request->get('id');
        $code = $request->get('code');
        $name = $request->get('name');
        DB::table('recipes')
            ->where('id', $ID)
            ->update(['code' => $code, 'name' => $name]);

        Session::flash('flash_message', 'Record Updated Successfully!');
        return redirect('recipe');
    }

    public function destroy($id)
    {
        $delete = Recipe::findOrFail($id);
        $delete->delete();
        return "Recipe Deleted Successfully!";
    }
}
