<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersModel
 * @package App\Model
 */
class UsersModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = ['uuid', 'first_name', 'last_name', 'email', 'password'];

    /**
     * @var array
     */
    protected $casts = [
        'uuid' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
    ];

    /**
     * @var array
     */
    protected $hidden = ['password'];

    public function test() {
        return true;
    }
}