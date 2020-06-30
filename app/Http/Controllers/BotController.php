<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\req;
use App\bot;
use App\chain;
use App\message;
use App\Repositories\message\messageRepositoryEloquent;

class BotController extends Controller
{
    protected $http = 'https://';
    protected $APIurl = 'https://eu9.chat-api.com/instance132144/';
    protected $token = 'j3v6nsuatd95fxur';
    protected $message;

    public function __construct()
    {
        $this->message = new messageRepositoryEloquent;
    }

    public function index($id)
    {

        if (!$id) exit();
        $bot = bot::where([['id','=',$id],['deleted','=',0]])->first();
        if (!$bot) exit();
        $chain = chain::where([['bot','=',$bot->id],['deleted','=',0]])->get();
        if (sizeof($chain) === 0) exit();
        $json = file_get_contents('php://input');

        //$json = '{"instanceId":"142194","messages":[{"id":"false_17472822486@c.us_DF38E6A25B42CC8CCE57EC40F","body":"asd","type":"chat","senderName":"Ilya","fromMe":false,"author":"17472822486@c.us","time":1504208593,"chatId":"17472822486@c.us","messageNumber":100}]}';

        $decoded = json_decode($json,true);

        if (isset($decoded['messages'])) {

            foreach($decoded['messages'] as $message) {

                $text = explode(' ',trim($message['body']));

                if(!$message['fromMe']) {

                    $keyId = 0;
                    $selectedChain = $chain[0];
                    $receivedMessage = mb_strtolower($text[0],'UTF-8');
                    $mess = $this->message->getByBotIdAndChatId($bot->id, $message['chatId']);

                    if ($mess) {
                        foreach ($chain as $key => $value) {
                            if ($mess->index === $key) {
                                $keyId = $key;
                                $selectedChain = $chain[ $key ];
                            }
                        }
                    }

                    $ans = 0;
                    $answers = json_decode($selectedChain['answers'], true);

                    foreach ($answers as $key => $value) {
                        if (mb_strtolower($value['title'],'UTF-8') === $receivedMessage) {
                            $ans = $key;
                            break;
                        }
                    }

                    if ($answers[ $ans ]['connect']['block'] !== -1) {
                        $this->message->store(
                            $bot->id,
                            $answers[ $ans ]['connect']['block'],
                            $message['chatId']
                        );
                        $selectedChain = $chain[ $answers[ $ans ]['connect']['block'] ];
                    }

                    $detail = json_decode($selectedChain['details'], true);

                    if ($detail['type'] === 'start' || $detail['type'] === 'message') {

                        $txt = $detail['message'];
                        $this->sendMessage($message['chatId'],$txt);

                    } elseif ($detail['type'] === 'chain') {

                        foreach ($detail['messages'] as &$value) {
                            $this->sendMessage($message['chatId'],$value['title']);
                        }

                        foreach ($detail['photos'] as &$value) {
                            $this->sendPhoto($message['chatId'],$value);
                        }

                        foreach ($detail['videos'] as &$value) {
                            $this->sendVideo($message['chatId'],$value);
                        }

                        foreach ($detail['sounds'] as &$value) {
                            $this->sendSound($message['chatId'],$value);
                        }

                        foreach ($detail['documents'] as &$value) {
                            $this->sendDocument($message['chatId'],$value);
                        }

                        foreach ($detail['audios'] as &$value) {
                            $this->sendAudio($message['chatId'],$value);
                        }

                    }



                    /*switch(mb_strtolower($text[0],'UTF-8')) {
                        case 'hi':  {$this->welcome($message['chatId'],false); break;}
                        case 'chatid': {$this->showChatId($message['chatId']); break;}
                        case 'time':   {$this->time($message['chatId']); break;}
                        case 'me':     {$this->me($message['chatId'],$message['senderName']); break;}
                        case 'file':   {$this->file($message['chatId'],$text[1]); break;}
                        case 'ptt':     {$this->ptt($message['chatId']); break;}
                        case 'geo':    {$this->geo($message['chatId']); break;}
                        case 'group':  {$this->group($message['author']); break;}
                        default:        {$this->welcome($message['chatId'],true); break;
                        }
                    }*/
                }
            }
        }
    }

    public function sendAudio($chatId, $document) {

        $url = $this->http.$_SERVER['HTTP_HOST'].$document['format']['url'];
        $data = [
            'audio' => $url,
            'chatId' => $chatId
        ];
        $this->sendRequest('sendAudio',$data);

    }

    public function sendDocument($chatId, $document) {

        $url = $this->http.$_SERVER['HTTP_HOST'].$document['format']['url'];
        $data = [
            'chatId'   => $chatId,
            'body'     => $url,
            'filename' => $document['format']['name'],
            'caption'  => $document['text']
        ];

        $this->sendRequest('sendFile',$data);

    }

    public function sendSound($chatId, $audio) {

        $url = $this->http.$_SERVER['HTTP_HOST'].$audio['format']['url'];
        $data = [
            'chatId'   => $chatId,
            'body'     => $url,
            'filename' => $audio['format']['name'],
            'caption'  => $audio['text']
        ];

        $this->sendRequest('sendFile',$data);

    }

    public function sendVideo($chatId, $video) {

        $url = $this->http.$_SERVER['HTTP_HOST'].$video['format']['url'];
        $data = [
            'chatId'   => $chatId,
            'body'     => $url,
            'filename' => $video['format']['name'],
            'caption'  => $video['text']
        ];

        $this->sendRequest('sendFile',$data);
    }

    public function sendPhoto($chatId, $photo) {

        $url = $this->http.$_SERVER['HTTP_HOST'].$photo['format']['url'];
        $data = [
            'chatId'   => $chatId,
            'body'     => $url,
            'filename' => $photo['format']['name'],
            'caption'  => $photo['text']
        ];

        $this->sendRequest('sendFile',$data);

    }
    //sends a file. it is called when the bot gets the command "file"
    //@param $chatId [string] [required] - the ID of chat where we send a message
    //@param $format [string] [required] - file format, from the params in the message body (text[1], etc)
    public function file($chatId,$format) {

        $availableFiles = array(
            'doc' => 'document.doc',
            'gif' => 'gifka.gif',
            'jpg' => 'jpgfile.jpg',
            'png' => 'pngfile.png',
            'pdf' => 'presentation.pdf',
            'mp4' => 'video.mp4',
            'mp3' => 'mp3file.mp3'
        );

        if(isset($availableFiles[$format])){
            $data = array(
                'chatId'=>$chatId,
                'body'=>'https://domain.com/PHP/'.$availableFiles[$format],
                'filename'=>$availableFiles[$format],
                'caption'=>'Get your file '.$availableFiles[$format]
            );
            $this->sendRequest('sendFile',$data);
        }
    }
    //sends Id of the current chat. it is called when the bot gets the command "chatId"
    //@param $chatId [string] [required] - the ID of chat where we send a message
    public function showChatId($chatId) {
        $this->sendMessage($chatId,'ChatID: '.$chatId);
    }
    //sends current server time. it is called when the bot gets the command "time"
    //@param $chatId [string] [required] - the ID of chat where we send a message
    public function time($chatId){
        $this->sendMessage($chatId,date('d.m.Y H:i:s'));
    }
    //sends your nickname. it is called when the bot gets the command "me"
    //@param $chatId [string] [required] - the ID of chat where we send a message
    //@param $name [string] [required] - the "senderName" property of the message
    public function me($chatId,$name) {
        $this->sendMessage($chatId,$name);
    }


    //sends a voice message. it is called when the bot gets the command "ptt"
    //@param $chatId [string] [required] - the ID of chat where we send a message
    public function ptt($chatId){
        $data = array(
            'audio'=>'https://domain.com/PHP/ptt.ogg',
            'chatId'=>$chatId
        );
        $this->sendRequest('sendAudio',$data);
    }

    //sends a location. it is called when the bot gets the command "geo"
    //@param $chatId [string] [required] - the ID of chat where we send a message
    public function geo($chatId){
        $data = array(
            'lat'=>51.51916,
            'lng'=>-0.139214,
            'address'=>'Ваш адрес',
            'chatId'=>$chatId
        );
        $this->sendRequest('sendLocation',$data);
    }

    //creates a group. it is called when the bot gets the command "group"
    //@param chatId [string] [required] - the ID of chat where we send a message
    //@param author [string] [required] - "author" property of the message
    public function group($author) {
        $phone = str_replace('@c.us','',$author);
        $data = array(
            'groupName'=>'Group with the bot PHP',
            'phones'=>array($phone),
            'messageText'=>'It is your group. Enjoy'
        );
        $this->sendRequest('group',$data);
    }

    public function sendMessage($chatId, $text) {
        $data = array('chatId'=>$chatId,'body'=>$text);
        $this->sendRequest('message',$data);
    }

    public function sendRequest($method,$data) {

        $url = $this->APIurl.$method.'?token='.$this->token;
        if(is_array($data)) $data = json_encode($data);

        $options = stream_context_create(['http' => [
            'method'  => 'POST',
            'header'  => 'Content-type: application/json',
            'content' => $data
            ]
        ]);

        $response = file_get_contents($url,false,$options);
        file_put_contents('requests.log',$response.PHP_EOL,FILE_APPEND);

    }

}
