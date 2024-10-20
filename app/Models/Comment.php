<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AsSource;

    protected $table = 'comments';
    protected $guarded = false;
}
