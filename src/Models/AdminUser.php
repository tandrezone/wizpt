<?php

namespace wizpt\cms\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Set what kind of authorization have a function
     *
     * @param      <Array>   $roles  The roles
     *
     * @return     abort  ( if not authorized abort )
     */
    public function authorize($roles)
    {
        if ($this->hasRole($roles)) {
            return true;
        }
        abort(401, 'This action is unauthorized.');
    }

    /**
     * Checks if user hasRole
     *
     * @param      <Array>   $roles  The roles
     *
     * @return     boolean  True if has level, False otherwise.
     */
    public function hasRole($roles)
    {
        if (in_array($this->role->name, $roles)) {
            return true;
        } else {
            return false;
        }
    }

    public function role()
    {
        return $this->belongsTo('wizpt\cms\Models\AdminRole');
    }
}
