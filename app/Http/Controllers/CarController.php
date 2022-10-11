<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CarController extends BaseController
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'brand' => 'required|max:255',
            'plate' => 'required|max:255|unique:cars',
            'model' => 'required|max:255',
            'employe_id' => 'numeric',
        ]);

        $car = Car::create($validatedData);
        return $this->responseMessage('success', 'Car created successfully', $car);
    }

    public function edit(Request $request, $id)
    {
        $validatedData = $request->validate([
            'brand' => 'required|max:255',
            'plate' => 'required|max:255|unique:cars,plate,'.$id,
            'model' => 'required|max:255',
            'employe_id' => 'numeric',
        ]);
        $car = Car::find($request->id);
        if ($car) {
            $car->update($validatedData);
            return $this->responseMessage('success', 'Car updated succesfully', $car);
        } else {
            return $this->responseMessage('error', 'No such car was found.', 422);
        }

    }

    public function index()
    {
        if (!Cache::has('cars')) {
            $cars = Cache::rememberForever('cars', function () {
                return Car::all();
            });
        } else {
            $cars = Cache::get('cars');
        }
        return $this->responseMessage('success', '', $cars);


    }

    public function delete($id)
    {
        $car = Car::find($id);
        if ($car) {
            $car->delete();
            return $this->responseMessage('success', 'Car was deleted');
        } else {
            return $this->responseMessage('error', 'No such car was found.', '', 422);
        }
    }

    public function car($id){
        $car=Car::find($id);
        if($car){
            return $this->responseMessage('success','',$car);
        }else{
            return $this->responseMessage('error','No such car was found.','',422);
        }
    }
}
