<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationEmailRequest;
use App\Http\Requests\NotificationSmsRequest;
use App\Jobs\SendEmail;
use App\Jobs\SendSms;
use App\Models\User;
use App\Services\Notification\Constants\EmailTypes;
use App\Services\Notification\Exception\UserDoseNotNumber;
use App\Services\Notification\Notification;

class NotificationController extends Controller
{
    public function email(){
        $users = User::all();
        $emailTypes = EmailTypes::tostring();
        return view('notifications.send-email',compact('users','emailTypes'));
    }
    public function sendemail(NotificationEmailRequest $notificationEmailRequest){
        try {
            $notificationEmailRequest->validated();
            $mailable = EmailTypes::toMail($notificationEmailRequest->email_type);
            SendEmail::dispatch(User::find($notificationEmailRequest->user),new $mailable);
            return $this->RedirectBack('success' , __('notification.email_sent_successfully'));
        } catch (\Throwable $th) {
            return $this->RedirectBack('failed',__('notification.email_has_problem'));
        }
    }
    public function sms(){
        $users = User::all();
        return view('notifications.send-sms',compact('users'));
    }
    public function sendsms(NotificationSmsRequest $notificationSmsRequest){
        try {
            $notificationSmsRequest->validated();
            SendSms::dispatch(User::find($notificationSmsRequest->user),$notificationSmsRequest->text);
            return $this->RedirectBack('success',__('notification.sms_sent_successfully'));
            
        } catch (UserDoseNotNumber $th) {
            return $this->RedirectBack('failed',__('notification.user_does_not_have_phone_number'));
        }
        catch (\Exception $e) {
            return $this->RedirectBack('failed',__('notification.sms_has_problem'));

        }
    }
    public function RedirectBack($type , $text){
        return redirect()->back()->with($type , $text);
    }
}
