<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    public function created_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleted_user()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
