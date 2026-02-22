<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class settingController extends Controller
{
   public function pageSetting(){
        return view('admin.itemMenu.setting');
    } 
}
