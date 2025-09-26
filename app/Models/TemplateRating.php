<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TemplateRating
 * 
 * @property uuid $id
 * @property uuid $template_id
 * @property uuid $user_id
 * @property int $rating
 * @property string|null $review
 * @property Carbon|null $created_at
 * 
 * @property Template $template
 * @property User $user
 *
 * @package App\Models
 */
class TemplateRating extends Model
{
	protected $table = 'template_ratings';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'uuid',
		'template_id' => 'uuid',
		'user_id' => 'uuid',
		'rating' => 'int'
	];

	protected $fillable = [
		'template_id',
		'user_id',
		'rating',
		'review'
	];

	public function template()
	{
		return $this->belongsTo(Template::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
