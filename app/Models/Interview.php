<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;
    protected $table = 'interviews';
    protected $fillable = ['interview_date_time', 'cand_id', 'user_id'];
    protected $guarded = ['created_at', 'deleted_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function candidatures()
    {
        return $this->belongsTo(Candidature::class, 'cand_id');
    }
}
