<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class reportController extends Controller
{
    public function pageReport(){
        return view('admin.itemMenu.report');
    } 
}
