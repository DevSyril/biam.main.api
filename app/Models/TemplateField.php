<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TemplateField
 * 
 * @property uuid $id
 * @property uuid $template_id
 * @property uuid|null $section_id
 * @property uuid $field_id
 * @property int $field_order
 * @property bool|null $is_required
 * @property bool|null $is_editable
 * @property string|null $legal_slug
 * @property string|null $visibility_rules
 * @property string|null $validation_schema
 * @property string|null $conditional_logic
 * @property Carbon|null $created_at
 * 
 * @property Template $template
 * @property TemplateSection|null $template_section
 * @property FormField $form_field
 *
 * @package App\Models
 */
class TemplateField extends Model
{
	protected $table = 'template_fields';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'template_id' => 'string',
		'section_id' => 'string',
		'field_id' => 'string',
		'field_order' => 'int',
		'is_required' => 'bool',
		'is_editable' => 'bool',
	];

	protected $fillable = [
		'template_id',
		'section_id',
		'field_id',
		'field_order',
		'is_required',
		'is_editable',
		'legal_slug',
		'visibility_rules',
		'validation_schema',
		'conditional_logic'
	];

	public function template()
	{
		return $this->belongsTo(Template::class);
	}

	public function template_section()
	{
		return $this->belongsTo(TemplateSection::class, 'section_id');
	}

	public function form_field()
	{
		return $this->belongsTo(FormField::class, 'field_id');
	}
}
