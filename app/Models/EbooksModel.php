<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbooksModel extends Model
{
    use HasFactory;

    protected $table = 'ebooks';

    protected $fillable = ['category_id', 'title', 'author', 'publisher', 'year', 'tumbnail', 'description', 'file'];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class);
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class);
    }
}
