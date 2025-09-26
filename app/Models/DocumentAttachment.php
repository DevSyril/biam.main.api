<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentAttachment
 * 
 * @property uuid $id
 * @property uuid $generated_document_id
 * @property string $file_name
 * @property string $file_path
 * @property int $file_size
 * @property string|null $mime_type
 * @property Carbon|null $uploaded_at
 * 
 * @property GeneratedDocument $generated_document
 *
 * @package App\Models
 */
class DocumentAttachment extends Model
{
	protected $table = 'document_attachments';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'uuid',
		'generated_document_id' => 'uuid',
		'file_size' => 'int',
		'uploaded_at' => 'datetime'
	];

	protected $fillable = [
		'generated_document_id',
		'file_name',
		'file_path',
		'file_size',
		'mime_type',
		'uploaded_at'
	];

	public function generated_document()
	{
		return $this->belongsTo(GeneratedDocument::class);
	}
}
