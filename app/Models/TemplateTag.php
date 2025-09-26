<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TemplateTag
 * 
 * @property uuid $template_id
 * @property uuid $tag_id
 * 
 * @property Template $template
 * @property Tag $tag
 *
 * @package App\Models
 */
class TemplateTag extends Model
{
	protected $table = 'template_tags';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'template_id' => 'uuid',
		'tag_id' => 'uuid'
	];

	public function template()
	{
		return $this->belongsTo(Template::class);
	}

	public function tag()
	{
		return $this->belongsTo(Tag::class);
	}
}
