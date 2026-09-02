<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppTemplate extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_templates';

    protected $fillable = [
        'trigger_key',
        'title',
        'message',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Replace dynamic merge tags in template message
     */
    public function render(array $data = []): string
    {
        $rendered = $this->message;
        foreach ($data as $key => $value) {
            $rendered = str_replace('{' . $key . '}', (string)$value, $rendered);
        }
        return $rendered;
    }
}
