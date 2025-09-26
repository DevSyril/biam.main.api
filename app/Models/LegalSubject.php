<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LegalSubject
 * 
 * @property uuid $id
 * @property string $label
 * @property string|null $description
 * @property string $slug
 * @property uuid|null $parent_id
 * @property int|null $level
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property LegalSubject|null $legal_subject
 * @property Collection|LegalSubject[] $legal_subjects
 * @property Collection|SubjectArticleLink[] $subject_article_links
 * @property Collection|Jurisprudence[] $jurisprudences
 *
 * @package App\Models
 */
class LegalSubject extends Model
{
	protected $table = 'legal_subject';
	public $incrementing = false;

	protected $casts = [
		'id' => 'uuid',
		'parent_id' => 'uuid',
		'level' => 'int'
	];

	protected $fillable = [
		'label',
		'description',
		'slug',
		'parent_id',
		'level'
	];

	public function legal_subject()
	{
		return $this->belongsTo(LegalSubject::class, 'parent_id');
	}

	public function legal_subjects()
	{
		return $this->hasMany(LegalSubject::class, 'parent_id');
	}

	public function subject_article_links()
	{
		return $this->hasMany(SubjectArticleLink::class, 'subject_id');
	}

	public function jurisprudences()
	{
		return $this->hasMany(Jurisprudence::class, 'linked_subject_id');
	}
}
