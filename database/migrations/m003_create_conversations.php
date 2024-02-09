<?php

use VulcanPhp\Core\Database\Interfaces\IMigration;
use VulcanPhp\Core\Database\Schema\Schema;

return new class implements IMigration
{
    public function up(): string
    {
        return Schema::create('conversations')
            ->id()
            ->foreignId('sender')->constrained('users', 'id')->onUpdate('cascade')->onDelete('cascade')
            ->foreignId('receiver')->constrained('users', 'id')->onUpdate('cascade')->onDelete('cascade')
            ->text('content')
            ->enum('type', ['text', 'textfile', 'voicecall', 'videocall'])->default('text')
            ->tinyInteger('read', 1)->default(0)
            ->timestamp('created_at')
            ->build();
    }

    public function down(): string
    {
        return Schema::drop('conversations');
    }
};
