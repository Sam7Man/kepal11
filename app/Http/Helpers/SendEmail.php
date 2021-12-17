<?php
namespace App\Http\Helpers;
use Illuminate\Support\Facades\Mail;

class SendEmail
{
  protected static $data = [
    'message' => '',
    'subject' => '',
    'type' => '',
    'data' => ''
  ];

  public static function sendToUser($data = null)
  {
    Mail::send('user.send_otp',['data' => $data], function ($message) use ($data) {
      $message->to($data['email'])->subject('Kode OTP');
    });
  }
}