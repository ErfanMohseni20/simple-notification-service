<?php 

namespace App\Services\Notification\Providers;
use App\Models\User;
use App\Services\Notification\Exception\UserDoseNotNumber;
use App\Services\Notification\Providers\Contracts\Provider;
use GuzzleHttp\Client;
class SmsProvider implements Provider
{


    private $user ; 
    private $content ;

    public function __construct(User $user , string $content){
        $this->user  = $user ; 
        $this->content = $content;
    }
    public function send() 
    {
        $this->havaphonenumber();
        $client  = new Client();
        $response = $client->post(config('services.sms.uri'),$this->prepareDataForSms());

        echo $response->getBody();

    }
    
    private function prepareDataForSms(){
        $data = array_merge(config('services.sms.auth'),[
                'op' => 'send',
                'message' => $this->content ,
                'to' => [$this->user->phone_number],
                config('services.sms.auth')]);
        return [ 
            'json' => $data
        ];
    }
    private function havaphonenumber(){
        if(is_null($this->user->phone_number)){
            throw new UserDoseNotNumber();
            
        }
    }
}