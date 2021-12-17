<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $fillable = ['invoice','user_id','no_resi','status_order_id','metode_pembayaran','ongkir','biaya_cod','subtotal','biaya_cod','pesan','no_hp', 'private', 'encrypt_key', 'signaiv'];

    public function decrypt() {
        $decrypted_data = openssl_decrypt($this->pesan, 'aes-128-cbc', base64_decode($this->encryption_key), 0, base64_decode(explode(',', $this->signaiv)[0]));
            return $decrypted_data;
    }
}
