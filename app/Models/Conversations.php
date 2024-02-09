<?php

namespace App\Models;

use VulcanPhp\SimpleDb\Model;

class Conversations extends Model
{
    public static function tableName(): string
    {
        return 'conversations';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function fillable(): array
    {
        return ['sender', 'receiver', 'content', 'type', 'created_at'];
    }

    public function rules(): array
    {
        return [
            'sender'    => [self::RULE_REQUIRED],
            'receiver' => [self::RULE_REQUIRED],
            'content' => [self::RULE_REQUIRED],
            'type' => [self::RULE_REQUIRED],
        ];
    }
}
