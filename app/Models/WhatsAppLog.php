<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppLog extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_logs';

    protected $fillable = [
        'recipient_phone',
        'recipient_name',
        'template_key',
        'message_body',
        'status',
    ];
}
