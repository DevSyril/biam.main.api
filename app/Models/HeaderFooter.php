<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\Traits\HasUuidPrimaryKey;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HeaderFooter
 * 
 * @property int $id
 * @property uuid $template_id
 * @property string $type
 * @property bool $is_active
 * @property string $content
 * @property bool $show_on_first_page
 * @property bool $show_on_last_page
 * @property bool $show_on_all_pages
 * @property string $background_color
 * @property string $text_color
 * @property int $font_size
 * @property string $font_family
 * @property string $font_style
 * @property string $text_position
 * @property bool $has_logo
 * @property string|null $logo_url
 * @property string $border
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Template $template
 *
 * @package App\Models
 */
class HeaderFooter extends Model
{
	use HasUuidPrimaryKey;

	public $incrementing = false;

	protected $table = 'header_footers';

	protected $casts = [
		'template_id' => 'string',
		'is_active' => 'bool',
		'show_on_first_page' => 'bool',
		'show_on_last_page' => 'bool',
		'show_on_all_pages' => 'bool',
		'font_size' => 'int',
		'has_logo' => 'bool'
	];

	protected $fillable = [
		'template_id',
		'type',
		'is_active',
		'content',
		'show_on_first_page',
		'show_on_last_page',
		'show_on_all_pages',
		'background_color',
		'text_color',
		'font_size',
		'font_family',
		'font_style',
		'text_position',
		'has_logo',
		'logo_url',
		'border'
	];

	public function template()
	{
		return $this->belongsTo(Template::class);
	}
}
