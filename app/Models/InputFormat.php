<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputFormat extends Model
{
    use HasFactory;

    protected $guarded = "id";

    public function input_option()
    {
        return $this->hasMany(InputOption::class, 'input_format_id');
    }
}
