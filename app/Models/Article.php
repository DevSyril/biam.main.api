<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * 
 * @property uuid $id
 * @property uuid $legal_text_id
 * @property string $article_number
 * @property string|null $article_title
 * @property string $content
 * @property bool|null $is_modified
 * @property bool|null $is_abrogated
 * @property string|null $commentary
 * @property int|null $display_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property LegalText $legal_text
 * @property Collection|SubjectArticleLink[] $subject_article_links
 * @property Collection|TextModification[] $text_modifications
 * @property Collection|Jurisprudence[] $jurisprudences
 *
 * @package App\Models
 */
class Article extends Model
{
	protected $table = 'article';
	public $incrementing = false;

	protected $casts = [
		'id' => 'uuid',
		'legal_text_id' => 'uuid',
		'is_modified' => 'bool',
		'is_abrogated' => 'bool',
		'display_order' => 'int'
	];

	protected $fillable = [
		'legal_text_id',
		'article_number',
		'article_title',
		'content',
		'is_modified',
		'is_abrogated',
		'commentary',
		'display_order'
	];

	public function legal_text()
	{
		return $this->belongsTo(LegalText::class);
	}

	public function subject_article_links()
	{
		return $this->hasMany(SubjectArticleLink::class);
	}

	public function text_modifications()
	{
		return $this->hasMany(TextModification::class, 'target_article_id');
	}

	public function jurisprudences()
	{
		return $this->hasMany(Jurisprudence::class, 'linked_article_id');
	}
}
