<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;
    protected $table = 'candidatures';
    protected $fillable = ['name', 'firstname', 'sexe', 'adresse', 'phone', 'email', 'file', 'motivation','statut', 'category_id'];
    protected $guarded = ['created_at', 'deleted_at', 'updated_at'];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function interviews(){
        return $this->hasMany(Interview::class);
    }
}
