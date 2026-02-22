<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class menuController extends Controller
{
   public function pageMenu(){
        return view('admin.itemMenu.menu');
    } 
}
