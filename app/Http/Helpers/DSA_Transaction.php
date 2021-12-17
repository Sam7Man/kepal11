<?php

namespace App\Http\Helpers;

use App\Order as AppOrder;
use Illuminate\Support\Facades\Mail;
use phpseclib3\Crypt\DSA;
use phpseclib3\Crypt\PublicKeyLoader;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class DSA_Transaction
{
    public $algorithm = 'aes-128-cbc';
    public $message;
    public $signaiv;
    public $encryption_key;

    public function __construct($message = null, $signaiv = null, $encryption_key = null)
    {
        $this->message = $message;
        $this->signaiv = $signaiv;
        $this->encryption_key = $encryption_key;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setSignaiv($signaiv)
    {
        $this->signaiv = $signaiv;
    }

    public function setEncryption($encryption_key)
    {
        $this->encryption_key = $encryption_key;
    }

    private function encryptMessage($message)
    {
        $cipher = "aes-128-cbc";
        //Generate a 128-bit encryption key 
        $encryption_key = openssl_random_pseudo_bytes(32);
        // Generate an initialization vector 
        $iv_size = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($iv_size);
        $data = $message;
        $encrypted_data = openssl_encrypt($data, $cipher, $encryption_key, 0, $iv);
        return [
            "encrypted_data" => $encrypted_data,
            "encryption_key" => $encryption_key,
            "iv" => base64_encode($iv),
        ];
    }

    public function makeDSA()
    {
        $key = DSA::createKey();
        $public = $key->getPublicKey()->toString("PKCS1");
        $private = $key->toString("PKCS1");
        $encryptedMessageData = $this->encryptMessage($this->message);
        $signature = $key->sign($this->message);
        $sgivnat = $encryptedMessageData['iv'] . "," . base64_encode($signature);
        return [
            'pblc_ky' => $public,
            'prvt_ky' => $private,
            'encrypt_ky' => base64_encode($encryptedMessageData['encryption_key']),
            'msg_crpt' => $encryptedMessageData['encrypted_data'],
            'sgivnat' => $sgivnat,
        ];
    }

    public function decrypt($encrypted_data)
    {
        $decrypted_data = openssl_decrypt($encrypted_data, $this->algorithm, base64_decode($this->encryption_key), 0, base64_decode(explode(',', $this->signaiv)[0]));
        return $decrypted_data;
    }

    public function verify($data)
    {
        $load_private = PublicKeyLoader::loadPrivateKey($data['private']);
        $signature = base64_decode(explode(',', $this->signaiv)[1]);
        $iv = base64_decode(explode(',', $this->signaiv)[0]);
        $decrypted_data = openssl_decrypt($data['cipher'], 'aes-128-cbc', base64_decode($this->encryption_key), 0, $iv);
        $order_id = $data['order_id'];
        $result = $load_private->getPublicKey()->verify($decrypted_data, $signature) ?
            'valid signature' :
            'invalid signature';

        if ($result == "valid signature") {
            // $order = Order::find($order_id);
            // $order->status = 'delivered';
            return true;
            // $query = "UPDATE `order` SET status='Accept' WHERE order_id = $order_id";
            // $result = mysqli_query($this->dbconn, $query);
            // $this->sendReceipt($order_id);
            // header('Location: orders.php');
        }
        return false;
    }

    public function sendReceipt($order_id)
    {
        $order = AppOrder::find($order_id);
        Mail::send('emails.sites.receipt', ['data' => $order], function ($message) use ($order) {
            $message->to($order->email)->subject('Receipt Transaction');
        });
    }
}