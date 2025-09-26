<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AvailableDocumentTag
 * 
 * @property uuid $available_document_id
 * @property uuid $tag_id
 * 
 * @property AvailableDocument $available_document
 * @property Tag $tag
 *
 * @package App\Models
 */
class AvailableDocumentTag extends Model
{
	protected $table = 'available_document_tags';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'available_document_id' => 'uuid',
		'tag_id' => 'uuid'
	];

	public function available_document()
	{
		return $this->belongsTo(AvailableDocument::class);
	}

	public function tag()
	{
		return $this->belongsTo(Tag::class);
	}
}
