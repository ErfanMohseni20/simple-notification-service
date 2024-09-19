<?php 

namespace App\Services\Notification;
use App\Services\Notification\Providers\Contracts\Provider;

/** 
*@method sendEmail(\App\User $user ,\Illuminate\Mail\Mailable $mailable)
*@method sendSms(\App\User $user , string $content)
 */

class Notification {
    public function __call($method, $args){
        $providerPath =__NAMESPACE__ . '\Providers\\' . substr($method,4) . 'Provider';
        if(!class_exists($providerPath)){throw new \Exception('class dose not exits');}
        $providerInstance = new $providerPath(... $args);
        if(!is_subclass_of($providerInstance, Provider::class)){throw new \Exception("class must be implements \App\Services\Notification\Providers\Contracts\Provider");}
        return $providerInstance->send();
    }
}