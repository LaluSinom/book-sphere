<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    /* 
    Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoryB_id')->constrained('categoryB')->onDelete('cascade');
            $table->string('title');
            $table->string('author');
            $table->integer('phone_author');
            $table->string('publisher');
            $table->integer('price');
            $table->string('tumbnail')->nullable();
            $table->timestamps();
        });
    */

    protected $fillable = ['categoryB_id', 'title', 'author', 'phone_author', 'publisher', 'price', 'tumbnail'];

    public function categoryB()
    {
        return $this->belongsTo(CategoryB::class);
    }
}
