<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class categoryController extends Controller
{
    public function pageAllcategory(){
        return view('admin.itemMenu.allcategory');
    }    
    public function pageAddcategory(){
        return view('admin.itemMenu.addcategory');
    }
}