<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GeneratedDocument
 * 
 * @property uuid $id
 * @property string $title
 * @property uuid $template_id
 * @property uuid $user_id
 * @property string $form_data
 * @property USER-DEFINED|null $status
 * @property string|null $file_path
 * @property int|null $file_size
 * @property int|null $download_count
 * @property Carbon|null $expiry_date
 * @property string|null $download_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $completed_at
 * 
 * @property Template $template
 * @property User $user
 * @property Collection|DocumentAttachment[] $document_attachments
 *
 * @package App\Models
 */
class GeneratedDocument extends Model
{
	protected $table = 'generated_documents';
	public $incrementing = false;

	protected $casts = [
		'id' => 'uuid',
		'template_id' => 'uuid',
		'user_id' => 'uuid',
		'form_data' => 'binary',
		'status' => 'USER-DEFINED',
		'file_size' => 'int',
		'download_count' => 'int',
		'expiry_date' => 'datetime',
		'completed_at' => 'datetime'
	];

	protected $hidden = [
		'download_token'
	];

	protected $fillable = [
		'title',
		'template_id',
		'user_id',
		'form_data',
		'status',
		'file_path',
		'file_size',
		'download_count',
		'expiry_date',
		'download_token',
		'completed_at'
	];

	public function template()
	{
		return $this->belongsTo(Template::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function document_attachments()
	{
		return $this->hasMany(DocumentAttachment::class);
	}
}
