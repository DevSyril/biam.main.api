<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LegalText
 * 
 * @property uuid $id
 * @property string $title
 * @property string $text_type
 * @property string|null $official_number
 * @property Carbon $promulgation_date
 * @property Carbon|null $abrogation_date
 * @property bool|null $is_in_force
 * @property string|null $official_source
 * @property string|null $version
 * @property string|null $applicable_country
 * @property string|null $jurisdiction
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Article[] $articles
 *
 * @package App\Models
 */
class LegalText extends Model
{
	protected $table = 'legal_text';
	public $incrementing = false;

	protected $casts = [
		'id' => 'uuid',
		'promulgation_date' => 'datetime',
		'abrogation_date' => 'datetime',
		'is_in_force' => 'bool'
	];

	protected $fillable = [
		'title',
		'text_type',
		'official_number',
		'promulgation_date',
		'abrogation_date',
		'is_in_force',
		'official_source',
		'version',
		'applicable_country',
		'jurisdiction'
	];

	public function articles()
	{
		return $this->hasMany(Article::class);
	}
}
