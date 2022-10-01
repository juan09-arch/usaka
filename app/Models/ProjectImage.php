<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    use HasFactory;

    protected $table = 'projectImage';

    // protected $guarded = ['id'];
    protected $fillable = [
        'id_project',
        'image',
    ];

    public function project() {
        return $this->belongsTo('App\Models\Project', 'id_project', 'id');
    }
}
