<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class productController extends Controller
{
    public function pageAllproduct(){
        return view('admin.itemMenu.allproduct');
    } 
    public function pageAddproduct() {
       return view('admin.itemMenu.addproduct');
    }
}