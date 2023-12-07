<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'question',
        'added_by',
        'category_id',
        'status',
    ];

    //Answer relationship
    public function getAnswer() {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    //User relationship
    public function getUser() {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    //Category relationship
    public function getCategory() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
