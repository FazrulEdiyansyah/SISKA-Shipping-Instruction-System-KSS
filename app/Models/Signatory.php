<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signatory extends Model
{
    protected $fillable = ['name', 'position', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
