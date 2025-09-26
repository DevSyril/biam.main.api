<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TemplateVersion
 * 
 * @property uuid $id
 * @property uuid $template_id
 * @property int $version_number
 * @property string $content
 * @property string|null $change_description
 * @property uuid|null $created_by
 * @property Carbon|null $created_at
 * 
 * @property Template $template
 * @property User|null $user
 *
 * @package App\Models
 */
class TemplateVersion extends Model
{
	protected $table = 'template_versions';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'uuid',
		'template_id' => 'uuid',
		'version_number' => 'int',
		'content' => 'binary',
		'created_by' => 'uuid'
	];

	protected $fillable = [
		'template_id',
		'version_number',
		'content',
		'change_description',
		'created_by'
	];

	public function template()
	{
		return $this->belongsTo(Template::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'created_by');
	}
}
