<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AuditLog
 * 
 * @property uuid $id
 * @property string $table_name
 * @property uuid $record_id
 * @property string $operation
 * @property string|null $old_values
 * @property string|null $new_values
 * @property uuid|null $user_id
 * @property Carbon|null $created_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class AuditLog extends Model
{
	protected $table = 'audit_log';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'uuid',
		'record_id' => 'uuid',
		'old_values' => 'binary',
		'new_values' => 'binary',
		'user_id' => 'uuid'
	];

	protected $fillable = [
		'table_name',
		'record_id',
		'operation',
		'old_values',
		'new_values',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
