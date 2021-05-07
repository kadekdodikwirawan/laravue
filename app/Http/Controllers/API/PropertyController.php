<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    // all Propertys
    public function index()
    {
        $propertys = Property::all()->toArray();
        return array_reverse($propertys);
    }

    // add property
    public function add(Request $request)
    {
        $property = new Property([
            'name' => $request->name,
            'author' => $request->author
        ]);
        $property->save();

        return response()->json('The property successfully added');
    }

    // edit property
    public function edit($id)
    {
        $property = Property::find($id);
        return response()->json($property);
    }

    // update property
    public function update($id, Request $request)
    {
        $property = Property::find($id);
        $property->update($request->all());

        return response()->json('The property successfully updated');
    }

    // delete property
    public function delete($id)
    {
        $property = Property::find($id);
        $property->delete();

        return response()->json('The property successfully deleted');
    }
}