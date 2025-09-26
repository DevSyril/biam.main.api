<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSession
 * 
 * @property uuid $id
 * @property uuid $user_id
 * @property string $session_token
 * @property inet|null $ip_address
 * @property string|null $user_agent
 * @property Carbon $expires_at
 * @property Carbon|null $created_at
 * @property Carbon|null $last_accessed
 * 
 * @property User $user
 *
 * @package App\Models
 */
class UserSession extends Model
{
	protected $table = 'user_sessions';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'uuid',
		'user_id' => 'uuid',
		'ip_address' => 'inet',
		'expires_at' => 'datetime',
		'last_accessed' => 'datetime'
	];

	protected $hidden = [
		'session_token'
	];

	protected $fillable = [
		'user_id',
		'session_token',
		'ip_address',
		'user_agent',
		'expires_at',
		'last_accessed'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
