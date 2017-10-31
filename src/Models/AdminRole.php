<?php

namespace wizpt\cms\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    public function adminuser()
    {
        return $this->hasOne('wizpt\cms\Models\AdminUser');
    }
}
