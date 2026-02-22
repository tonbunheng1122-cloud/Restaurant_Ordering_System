<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class tableController extends Controller
{
    public function pageAlltable(){
        return view('admin.itemMenu.alltable');
    } 
    public function pageAddtable(){
        return view('admin.itemMenu.addtable');
    }
}
