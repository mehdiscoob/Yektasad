<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *      schema="User",
 *      title="User",
 *      description="User model",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="The unique identifier for the user",
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="The name of the user",
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          format="email",
 *          description="The email address of the user",
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          type="string",
 *          description="The date and time when the user was created",
 *          example="2022-06-29 12:00:00",
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          type="string",
 *          description="The date and time when the user was last updated",
 *          example="2022-06-29 12:00:00",
 *      ),
 * )
 */
class User extends Authenticatable
{
    use  HasFactory, Notifiable, SoftDeletes,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

}
