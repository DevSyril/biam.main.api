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
 * @property string $category
 * @property string $type
 * @property \Psy\Util\Json $content
 * @property int|null $version
 * @property bool|null $is_premium
 * @property bool|null $is_active
 * @property bool|null $is_public
 * @property uuid|null $author_id
 * @property string|null $language
 * @property string|null $preview_url
 * @property int|null $estimated_time_minutes
 * @property int|null $usage_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property uuid $document_id
 * 
 * @property User|null $user
 * @property AvailableDocument $available_document
 * @property Collection|TemplateSection[] $template_sections
 * @property Collection|TemplateField[] $template_fields
 * @property Collection|GeneratedDocument[] $generated_documents
 * @property Collection|Tag[] $tags
 * @property Collection|TemplateRating[] $template_ratings
 * @property Collection|TemplateVersion[] $template_versions
 *
 * @package App\Models
 */
class Template extends Model
{
	use HasUuidPrimaryKey;
	protected $table = 'templates';
	public $incrementing = false;

	protected $casts = [
		'category' => 'string',
		'type' => 'string',
		'version' => 'int',
		'is_premium' => 'bool',
		'is_active' => 'bool',
		'is_public' => 'bool',
		'estimated_time_minutes' => 'int',
		'usage_count' => 'int',
	];

	protected $fillable = [
		'title',
		'description',
		'category',
		'type',
		'content',
		'version',
		'is_premium',
		'is_active',
		'is_public',
		'author_id',
		'language',
		'preview_url',
		'estimated_time_minutes',
		'usage_count',
		'document_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'author_id')->get();
	}

	public function available_document()
	{
		return $this->belongsTo(AvailableDocument::class, 'document_id')->get();
	}

	public function template_sections()
	{
		return $this->hasMany(TemplateSection::class, 'template_id');
	}

	public function template_fields()
	{
		return $this->hasMany(TemplateField::class)->get();
	}

	public function generated_documents()
	{
		return $this->hasMany(GeneratedDocument::class)->get();
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class, 'template_tags')->get();
	}

	public function template_ratings()
	{
		return $this->hasMany(TemplateRating::class, 'template_id')->get();
	}

	public function template_versions()
	{
		return $this->hasMany(TemplateVersion::class)->get();
	}
}
