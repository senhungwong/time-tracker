<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models
 *
 * @property string username
 * @property string email
 * @property string password
 * @property string api_token
 * @property string deleted_at
 */
class User extends Authenticatable
{
    use Notifiable, softDeletes;

    protected $table = 'users';

    public $primaryKey = 'username';

    public $incrementing = false;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    /** Name of the Admins */
    private const ADMIN = ['admin'];

    /** API Token Length */
    public const API_TOKEN_LENGTH = 60;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function events()
    {
        return $this->hasMany('App\Models\Event', 'username', 'username');
    }

    public function tags()
    {
        $this->hasMany('App\Models\Tag', 'username', 'username');
    }

    public function logs()
    {
        $this->hasMany('App\Models\Log', 'username', 'username');
    }

    public function isAdmin()
    {
        return in_array($this->username, User::ADMIN);
    }
}
