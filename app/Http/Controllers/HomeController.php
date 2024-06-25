<?php

namespace App\Http\Controllers;

use App\Http\Traits\HomeTrait;

class HomeController extends Controller
{
    use HomeTrait;
  //Constract...........................................
    public function __construct()
    {
        $this->middleware('auth');
    }

//Index........................................................
    public function index()
    {
       try{
        return $this->indexTrait();
       }catch (\Exception $e)
       {
        return redirect()->route('home')->with('error', 'Failed to Upload home page'  );
       }
           
    }
}


 


