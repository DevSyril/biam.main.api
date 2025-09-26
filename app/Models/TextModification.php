<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TextModification
 * 
 * @property uuid $id
 * @property uuid $source_article_id
 * @property uuid $target_article_id
 * @property string $modification_type
 * @property Carbon $effective_date
 * @property string|null $commentary
 * @property Carbon|null $created_at
 * 
 * @property Article $article
 *
 * @package App\Models
 */
class TextModification extends Model
{
	protected $table = 'text_modification';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'uuid',
		'source_article_id' => 'uuid',
		'target_article_id' => 'uuid',
		'effective_date' => 'datetime'
	];

	protected $fillable = [
		'source_article_id',
		'target_article_id',
		'modification_type',
		'effective_date',
		'commentary'
	];

	public function article()
	{
		return $this->belongsTo(Article::class, 'target_article_id');
	}
}
