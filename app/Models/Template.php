<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\Traits\HasUuidPrimaryKey;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Template
 * 
 * @property uuid $id
 * @property string $title
 * @property string|null $description
 * @property int|null $version
 * @property bool|null $is_premium
 * @property bool|null $is_active
 * @property bool|null $is_public
 * @property uuid|null $author_id
 * @property string|null $language
 * @property int|null $estimated_time_minutes
 * @property int|null $usage_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property uuid $document_id
 * 
 * @property User|null $user
 * @property AvailableDocument $available_document
 * @property Collection|TemplateSection[] $template_sections
 *
 * @package App\Models
 */
class Template extends Model
{
	use HasUuidPrimaryKey;
	protected $table = 'templates';
	public $incrementing = false;

	protected $casts = [
		'id' => 'string',
		'version' => 'int',
		'is_premium' => 'bool',
		'is_active' => 'bool',
		'is_public' => 'bool',
		'author_id' => 'string',
		'estimated_time_minutes' => 'int',
		'usage_count' => 'int',
		'document_id' => 'string'
	];

	protected $fillable = [
		'title',
		'description',
		'version',
		'is_premium',
		'is_active',
		'is_public',
		'author_id',
		'language',
		'estimated_time_minutes',
		'usage_count',
		'document_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'author_id');
	}

	public function available_document()
	{
		return $this->belongsTo(AvailableDocument::class, 'document_id');
	}

	public function template_sections()
	{
		return $this->hasMany(TemplateSection::class);
	}
}
