<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\Traits\HasUuidPrimaryKey;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FormField
 * 
 * @property uuid $id
 * @property string $label
 * @property string $type
 * @property string|null $default_value
 * @property string|null $options
 * @property string|null $description
 * @property string|null $validation_rules
 * @property string|null $placeholder
 * @property string|null $help_text
 * @property bool|null $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TemplateField[] $template_fields
 *
 * @package App\Models
 */
class FormField extends Model
{
	protected $table = 'form_fields';
	public $incrementing = false;

	use HasUuids;

	protected $casts = [
		'id' => 'string',
		'default_value' => 'string',
		'type' => 'string',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'label',	
		'type',
		'default_value',
		'options',
		'description',
		'validation_rules',
		'placeholder',
		'help_text',
		'is_active'
	];

	public function template_fields()
	{
		return $this->hasMany(TemplateField::class, 'field_id');
	}
}
