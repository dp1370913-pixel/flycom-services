<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_message
 * @property int $id_conversation
 * @property string $expediteur
 * @property string $contenu
 * @property \Illuminate\Support\Carbon $horodatage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Conversation $conversation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MessageConversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MessageConversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MessageConversation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MessageConversation whereContenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MessageConversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MessageConversation whereExpediteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MessageConversation whereHorodatage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MessageConversation whereIdConversation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MessageConversation whereIdMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MessageConversation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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