<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;

    protected $table = 'rekening';

    protected $fillable = ['nomor_rekening', 'nama_bank', 'logo_bank'];

    public function ebook()
    {
        return $this->hasMany(EbooksModel::class);
    }
}
