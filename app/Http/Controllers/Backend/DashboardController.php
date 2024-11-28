<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        try{
            return view('backend.dashboard'); 
        }catch(\Exception $e){
            \Log::info($e->getMessage().' '.$e->getFile().' '.$e->getCode());
        }
    }
}
