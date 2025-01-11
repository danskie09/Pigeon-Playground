<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;

class Secretary extends Controller
{
    //

    public function show(){
        $residents = Resident::all();
        return view('secretary.residents' ,compact('residents'));
    }



    public function dashboard(){
        return view('secretary.dashboard');
    }



    public function activity(){
        return view('secretary.activity');
    }








    
}
