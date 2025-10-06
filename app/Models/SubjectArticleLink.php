<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\Traits\HasUuidPrimaryKey;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SubjectArticleLink
 * 
 * @property uuid $id
 * @property uuid $subject_id
 * @property uuid $article_id
 * @property int|null $relevance
 * @property string|null $context_commentary
 * @property string|null $usage_example
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property LegalSubject $legal_subject
 * @property Article $article
 *
 * @package App\Models
 */
class SubjectArticleLink extends Model
{
	protected $table = 'subject_article_link';
	public $incrementing = false;

	protected $connection = 'pgsql_secondary';

	use HasUuidPrimaryKey;

	protected $casts = [
		'id' => 'string',
		'subject_id' => 'string',
		'article_id' => 'string',
		'relevance' => 'int'
	];

	protected $fillable = [
		'subject_id',
		'article_id',
		'relevance',
		'context_commentary',
		'usage_example'
	];

	public function legal_subject()
	{
		return $this->belongsTo(LegalSubject::class, 'subject_id');
	}

	public function article()
	{
		return $this->belongsTo(Article::class);
	}
}
