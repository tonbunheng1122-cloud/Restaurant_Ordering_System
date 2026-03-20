<?php
    namespace App\Http\Controllers\layouts; 
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    class UserwebController extends Controller
    {
    public function pages() {
        return view('layouts.userweb'); 
    }
        }
?>