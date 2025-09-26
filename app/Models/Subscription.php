<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 * 
 * @property uuid $id
 * @property string $name
 * @property USER-DEFINED $type
 * @property float $price
 * @property string|null $description
 * @property int|null $max_documents_per_month
 * @property int|null $max_storage_gb
 * @property string|null $features
 * @property bool|null $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Subscription extends Model
{
	protected $table = 'subscriptions';
	public $incrementing = false;

	protected $casts = [
		'id' => 'uuid',
		'type' => 'USER-DEFINED',
		'price' => 'float',
		'max_documents_per_month' => 'int',
		'max_storage_gb' => 'int',
		'features' => 'binary',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'type',
		'price',
		'description',
		'max_documents_per_month',
		'max_storage_gb',
		'features',
		'is_active'
	];

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
