<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * 
 * @property uuid $id
 * @property string $name
 * @property string|null $description
 * @property string|null $color
 * @property bool|null $is_active
 * @property Carbon|null $created_at
 * 
 * @property Collection|Template[] $templates
 * @property Collection|AvailableDocument[] $available_documents
 *
 * @package App\Models
 */
class Tag extends Model
{
	protected $table = 'tags';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'uuid',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'description',
		'color',
		'is_active'
	];

	public function templates()
	{
		return $this->belongsToMany(Template::class, 'template_tags');
	}

	public function available_documents()
	{
		return $this->belongsToMany(AvailableDocument::class, 'available_document_tags');
	}
}
