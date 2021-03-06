<?php


namespace App\Repositories\Whatsapp;


class WhatsappRepositoryEloquent implements WhatsappRepositoryInterface
{
    var $APIurl = 'https://eu9.chat-api.com/instance132144/ ';
    var $token = 'j3v6nsuatd95fxur';

    public function __construct() {
        //get the JSON body from the instance
        $json = file_get_contents('php://input');
        $decoded = json_decode($json,true);

        //write parsed JSON-body to the file for debugging
        ob_start();
        var_dump($decoded);
        $input = ob_get_contents();
        ob_end_clean();
        file_put_contents('input_requests.log',$input.PHP_EOL,FILE_APPEND);

        if(isset($decoded['messages'])){
            //check every new message
            foreach($decoded['messages'] as $message){
                //delete excess spaces and split the message on spaces. The first word in the message is a command, other words are parameters
                $text = explode(' ',trim($message['body']));
                //current message shouldn't be send from your bot, because it calls recursion
                if(!$message['fromMe']){
                    //check what command contains the first word and call the function
                    switch(mb_strtolower($text[0],'UTF-8')) {
                        case 'hi':  {
                            $this->welcome($message['chatId'],false);
                            break;
                        }
                        case 'chatid': {
                            $this->showChatId($message['chatId']);
                            break;
                        }
                        case 'time': {
                            $this->time($message['chatId']);
                            break;
                        }
                        case 'me': {
                            $this->me($message['chatId'],$message['senderName']);
                            break;
                        }
                        case 'file': {
                            $this->file($message['chatId'],$text[1]);
                            break;
                        }
                        case 'ptt': {
                            $this->ptt($message['chatId']);
                            break;
                        }
                        case 'geo': {
                            $this->geo($message['chatId']);
                            break;
                        }
                        case 'group': {
                            $this->group($message['author']);
                            break;
                        }
                        default: {
                            $this->welcome($message['chatId'],true);
                            break;
                        }
                    }
                }
            }
        }
    }

    public function sendRequest($method,$data)
    {
        $url = $this->APIurl . $method . '?token=' . $this->token;
        if (is_array($data)) {
            $data = json_encode($data);
        }
        $options = stream_context_create(['http' => [
            'method' => 'POST',
            'header' => 'Content-type: application/json',
            'content' => $data
        ]]);
        $response = file_get_contents($url, false, $options);
        file_put_contents('requests.log', $response . PHP_EOL, FILE_APPEND);
    }

    public function sendMessage($chatId, $text) {
        $data = array('chatId'=>$chatId,'body'=>$text);
        $this->sendRequest('message',$data);
    }

    public function welcome($chatId, $noWelcome = false) {
        $welcomeString = ($noWelcome) ? "Incorrect command\n" : "WhatsApp Demo Bot PHP\n";
        $this->sendMessage($chatId,
            $welcomeString.
            "Commands:\n".
            "1. chatid - show ID of the current chat\n".
            "2. time - show server time\n".
            "3. me - show your nickname\n".
            "4. file [format] - get a file. Available formats: doc/gif/jpg/png/pdf/mp3/mp4\n".
            "5. ptt - get a voice message\n".
            "6. geo - get a location\n".
            "7. group - create a group with the bot");
    }

    public function showChatId($chatId) {
        $this->sendMessage($chatId,'ChatID: '.$chatId);
    }

    public function time($chatId) {
        $this->sendMessage($chatId,date('d.m.Y H:i:s'));
    }

    public function me($chatId,$name){
        $this->sendMessage($chatId,$name);
    }

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
        if (isset($availableFiles[$format])) {
            $data = array(
                'chatId'   => $chatId,
                'body'     => 'https://domain.com/PHP/'.$availableFiles[$format],
                'filename' => $availableFiles[$format],
                'caption'  => 'Get your file '.$availableFiles[$format]
            );
            $this->sendRequest('sendFile',$data);
        }
    }

    public function ptt($chatId) {
        $data = array(
            'audio'=>'https://domain.com/PHP/ptt.ogg',
            'chatId'=>$chatId
        );
        $this->sendRequest('sendAudio',$data);
    }

    public function geo($chatId){
        $data = array(
            'lat'     => 51.51916,
            'lng'     => -0.139214,
            'address' =>'Ваш адрес',
            'chatId'  =>$chatId
        );
        $this->sendRequest('sendLocation',$data);
    }

    public function group($author) {
        $phone = str_replace('@c.us','',$author);
        $data = array(
            'groupName'   => 'Group with the bot PHP',
            'phones'      => array($phone),
            'messageText' => 'It is your group. Enjoy'
        );
        $this->sendRequest('group',$data);
    }

}
