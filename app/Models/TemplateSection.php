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
 * Class TemplateSection
 * 
 * @property uuid $id
 * @property uuid $template_id
 * @property string $title
 * @property string|null $description
 * @property int $section_order
 * @property string|null $legal_slug
 * @property bool|null $is_required
 * @property bool|null $is_repeatable
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Template $template
 * @property Collection|TemplateField[] $template_fields
 *
 * @package App\Models
 */
class TemplateSection extends Model
{
	use HasUuidPrimaryKey;
	protected $table = 'template_sections';
	public $incrementing = false;

	protected $casts = [
		'template_id' => 'string',
		'section_order' => 'int',
		'is_required' => 'bool',
		'is_repeatable' => 'bool'
	];

	protected $fillable = [
		'template_id',
		'title',
		'description',
		'section_order',
		'legal_slug',
		'is_required',
		'is_repeatable'
	];

	public function template()
	{
		return $this->belongsTo(Template::class, 'template_id');
	}

	public function template_fields()
	{
		return $this->hasMany(TemplateField::class, 'section_id');
	}
}
