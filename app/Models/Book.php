<?php

namespace App\Models;

use App\Traits\UseUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes, UseUUID;

    protected $fillable = [
        'id',
        'name',
        'author',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
