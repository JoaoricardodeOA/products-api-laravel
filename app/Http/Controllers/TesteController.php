<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TesteController extends Controller
{
    public function data(){
        $user = DB::select("select * from tb_products where name='notebook'");
        dump($user);
    }
}
