<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Whatsapp\WhatsappRepositoryEloquent;

class MainController extends Controller
{

    protected $whatsapp;

    public function index()
    {
        //$this->whatsapp = new WhatsappRepositoryEloquent;
        return view('welcome');
        //http://bot.e-market.kz/
    }
}
