<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\Traits\HasUuidPrimaryKey;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Jurisprudence
 * 
 * @property uuid $id
 * @property string $reference
 * @property string $summary
 * @property string|null $official_link
 * @property uuid|null $linked_article_id
 * @property uuid|null $linked_subject_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Article|null $article
 * @property LegalSubject|null $legal_subject
 *
 * @package App\Models
 */
class Jurisprudence extends Model
{

	use HasUuidPrimaryKey;

	protected $table = 'jurisprudence';
	public $incrementing = false;
	protected $connection = 'pgsql_secondary';

	protected $casts = [
		'id' => 'string',
		'linked_article_id' => 'string',
		'linked_subject_id' => 'string'
	];

	protected $fillable = [
		'reference',
		'summary',
		'official_link',
		'linked_article_id',
		'linked_subject_id'
	];

	public function article()
	{
		return $this->belongsTo(Article::class, 'linked_article_id');
	}

	public function legal_subject()
	{
		return $this->belongsTo(LegalSubject::class, 'linked_subject_id');
	}
}
