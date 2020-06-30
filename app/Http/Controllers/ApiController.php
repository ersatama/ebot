<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\bot;
use App\chain;
use App\message;
use Auth;
use App\Repositories\bot\botRepositoryEloquent;
use App\Repositories\chain\chainRepositoryEloquent;

class ApiController extends Controller
{
    protected $bot;
    protected $chain;

    public function __construct()
    {

        $this->middleware('auth');
        $this->bot = new botRepositoryEloquent;
        $this->chain = new chainRepositoryEloquent;

    }

    public function analyze($page) {

        $bot   = $this->bot->get((int) $page - 1);
        $limit = $this->bot->limit();
        $out = [[],$limit];

        foreach ($bot as $key=>$value) {
            $chain = $this->chain->countByBotId($value['id']);
            $url   = '/bot/'.$value['id'];
            $out[0][] = [
                'id'    => $value['id'],
                'name'  => $value['name'],
                'chain' => $chain,
                'url'   => $url
            ];
        }

        return $out;

    }

}
