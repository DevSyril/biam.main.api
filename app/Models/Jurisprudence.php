<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Traits\HasUuidPrimaryKey;

/**
 * Class Jurisprudence
 * 
 * @property uuid $id
 * @property string $case_reference
 * @property string $defendant_names
 * @property string $claimant_names
 * @property string $court
 * @property string $summary
 * @property string|null $full_decision
 * @property Carbon $decision_date
 * @property string|null $official_link
 * @property uuid|null $linked_subject_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property LegalSubject|null $legal_subject
 *
 * @package App\Models
 */
class Jurisprudence extends Model
{
	protected $table = 'jurisprudence';
	public $incrementing = false;
	public $connection = 'pgsql_secondary';

	use HasUuidPrimaryKey;

	protected $casts = [
		'id' => 'string',
		'decision_date' => 'datetime',
		'linked_subject_id' => 'string'
	];

	protected $fillable = [
		'case_reference',
		'defendant_names',
		'claimant_names',
		'court',
		'summary',
		'full_decision',
		'decision_date',
		'official_link',
		'linked_subject_id'
	];

	public function legal_subject()
	{
		return $this->belongsTo(LegalSubject::class, 'linked_subject_id');
	}
}
