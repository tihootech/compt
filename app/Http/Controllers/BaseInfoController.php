<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coach;
use App\Models\Place;
use App\Models\Field;
use App\Models\Salon;

class BaseInfoController extends Controller
{
    public function getData()
    {
        return [
            'salons' => Salon::with('places')->get(),
            'places' => Place::all(),
            'coachs' => Coach::all(),
            'fields' => Field::all(),
        ];
    }

    public function upsertData(Request $request, $type, $id=0)
    {
        // create validation rules
        if ($type == 'field') {
            $validationRules = [
                'name' => 'required|string',
            ];
        }
        if ($type == 'salon') {
            $validationRules = [
                'name' => 'required|string',
                'address' => 'required|string',
            ];
        }
        if ($type == 'coach') {
            $validationRules = [
                'name' => 'required|string',
                'field_id' => 'required|exists:fields,id',
                'degree' => 'required|string',
                'exp' => 'nullable|string',
            ];
        }

        // insert or update data in db
        $data = $request->validate($validationRules);
        $class = 'App\Models\\'.ucfirst($type);
        $object = $class::updateOrCreate(compact('id'), $data);

        // return suceess
        return ['success' => true, 'type' => $type.'s', 'object' => $object];
    }

    public function mangePlaces(Request $request, Salon $salon)
    {
        foreach ($request->all() as $pData) {
            if (isset($pData['id']) && $pData['id']) {
                $place = Place::find($pData['id']);
                $place->update($pData);
            }else {
                $pData['salon_id'] = $salon->id;
                Place::create($pData);
            }
        }
        return ['success' => true];
    }

    public function deleteData($type, $id)
    {
        $class = 'App\Models\\'.ucfirst($type);
        $object = $class::find($id);
        $object->delete();
        return ['success' => true];
    }
}
