<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function employeeList(){
        return view('employee-list');
    }

    public function employeeForm(){
        return view('employee-form');
    }

    public function carsList(){
        return view('cars-list');
    }

    public function carsForm(){
        return view('cars-form');
    }

    public function giveCar(){
        return view('give-car-form');
    }

    public function employeesCars(){
        return view('employees-cars');
    }
}
