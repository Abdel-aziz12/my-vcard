<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = ['name', 'code', 'user_id', 'is_active'];
    protected $guarded = ['created_at', 'deleted_at', 'updated_at'];

    public function candidatures (){
        return $this->hasMany(Candidature::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
