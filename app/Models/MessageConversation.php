<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageConversation extends Model
{
    protected $table = 'messages_conversation';
    protected $primaryKey = 'id_message';

    protected $fillable = [
        'id_conversation',
        'expediteur',
        'contenu',
        'horodatage'
    ];

    protected $casts = [
        'horodatage' => 'datetime',
    ];

    // Relation : Le message appartient à un fil de discussion (conversation) unique
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'id_conversation');
    }
}