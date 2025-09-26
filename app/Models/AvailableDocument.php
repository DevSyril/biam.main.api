<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AvailableDocument
 * 
 * @property uuid $id
 * @property string $name
 * @property string|null $description
 * @property USER-DEFINED $category
 * @property USER-DEFINED $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Template[] $templates
 * @property Collection|Tag[] $tags
 *
 * @package App\Models
 */
class AvailableDocument extends Model
{
	protected $table = 'available_documents';
	public $incrementing = false;

	protected $casts = [
		'id' => 'uuid',
		'category' => 'USER-DEFINED',
		'type' => 'USER-DEFINED'
	];

	protected $fillable = [
		'name',
		'description',
		'category',
		'type'
	];

	public function templates()
	{
		return $this->hasMany(Template::class, 'document_id');
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class, 'available_document_tags');
	}
}
