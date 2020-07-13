<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    protected $fillable = [];
}
