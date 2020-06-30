<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\bot;
use App\chain;
use App\message;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function audioUpload(Request $request) {
        $audio = $request->file('audio');
        $name = $audio->getClientOriginalName();
        //md5(date('Y-m-d H:i:s')).'.'.$sound->extension();
        $audio->move('storage',$name);
        return '/storage/'.$name;
    }

    public function soundUpload(Request $request) {
        $sound = $request->file('sound');
        $name = $sound->getClientOriginalName();
        //md5(date('Y-m-d H:i:s')).'.'.$sound->extension();
        $sound->move('storage',$name);
        return ['url'=>'/storage/'.$name,'name'=>$name];
    }

    public function documentUpload(Request $request) {
        $document = $request->file('document');
        $name = md5(date('Y-m-d H:i:s')).'.'.$document->extension();
        $fileName = $document->getClientOriginalName();
        $document->move('storage',$name);
        return ['url'=>'/storage/'.$name,'name'=>$fileName];
    }

    public function videoUpload(Request $request) {
        $video = $request->file('video');
        $name = md5(date('Y-m-d H:i:s')).'.'.$video->extension();
        $fileName = $video->getClientOriginalName();
        $video->move('storage',$name);
        return ['url'=>'/storage/'.$name,'name'=>$fileName];
    }

    public function photoUpload(Request $request) {
        $photo = $request->file('photo');
        $name = md5(date('Y-m-d H:i:s')).'.'.$photo->extension();
        $fileName = $photo->getClientOriginalName();
        $photo->move('storage',$name);
        return ['url'=>'/storage/'.$name,'name'=>$fileName];
    }

    public function store(Request $request) {
        bot::where('user', Auth::user()->id)
            ->update(['status' => 0]);
        $bot = new bot;
        $bot->user = Auth::user()->id;
        $bot->name = $request->input('name');
        $bot->save();
        $chain = $request->input('chain');
        for ($i = 0; $i < sizeof($chain); $i++) {
            $ch = new chain;
            $ch->bot = $bot->id;
            $ch->index = $i;
            $ch->type = $chain[$i]['type'];
            $ch->name = $chain[$i]['name'];
            $ch->answers = json_encode($chain[$i]['answers']);
            $ch->details = json_encode($chain[$i]);
            $ch->save();
        }
    }


    public function index()
    {
        return view('home');
    }

    public function saveBotAjax(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $chain = $request->input('chain');
        bot::where([['id','=',$id]])->update(['name'=>$name]);
        chain::where([['bot','=',$id]])->delete();
        message::where([['bot','=',$id]])->delete();
        for ($i = 0; $i < sizeof($chain); $i++) {
            $ch = new chain;
            $ch->bot = $id;
            $ch->index = $i;
            $ch->type = $chain[$i]['type'];
            $ch->name = $chain[$i]['name'];
            $ch->answers = json_encode($chain[$i]['answers']);
            $ch->details = json_encode($chain[$i]);
            $ch->save();
        }

        return $request->all();
    }

    public function editBotAjax($id)
    {
        $arr = [];
        $bot = bot::where([['id','=',$id],['deleted','=',0]])->first();
        if ($bot) {
            $arr[0] = $bot->name;
            $chain = chain::where(['bot' => $id])->orderBy('id')->get();
            foreach ($chain as &$value) {
                $arr[] = json_decode($value['details'],true);
            }
        }
        return $arr;
    }

    public function editBot($id)
    {
        return view('botEdit');
    }

    //SETTINGS
    public function settings()
    {
        return view('settings');
    }
    public function settingsNotifications()
    {
        return view('settingsNotifications');
    }
    public function settingsIntegration()
    {
        return view('settingsIntegration');
    }
    public function settingsPolitics()
    {
        return view('settingsPolitics');
    }
    public function settingsAdditional()
    {
        return view('settingsAdditional');
    }
    //END SETTINGS

    public function chat()
    {
        return view('chat');
    }

    //AUTOFUNNELS
    public function autofunnels()
    {
        return view('autofunnels');
    }
    public function autofunnelsList()
    {
        return view('autofunnelsList');
    }
    //END AUTOFUNNELS

    //LIST
    public function list()
    {
        return view('list');
    }
    public function listConstants()
    {
        return view('listConstants');
    }
    //END LIST

    //STATISTICS
    public function statistics()
    {
        return view('statistics');
    }
    public function statisticsDevices()
    {
        return view('statisticsDevices');
    }
    public function statisticsPhrases()
    {
        return view('statisticsPhrases');
    }
    public function statisticsPopular()
    {
        return view('statisticsPopular');
    }
    public function statisticsLinks()
    {
        return view('statisticsLinks');
    }
    //END STATISTICS

    public function analyze() {
        return view('analyze');
    }
}
