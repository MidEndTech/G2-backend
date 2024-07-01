<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table= 'blogs';
    protected $fillable =[
        'user_id',
        'subject',
        'content'
    ];

    public function blogs()
    {
        return $this->belongsTo(User::class);
    }

}
