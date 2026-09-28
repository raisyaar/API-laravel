<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->text('content');
        $table->morphs('commentable');        // membuat commentable_id + commentable_type
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamp('commented_at')->nullable();
        $table->timestamps();
        $table->softDeletes();                // membuat kolom deleted_at untuk SoftDeletes
    });
}

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};