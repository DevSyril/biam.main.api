<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\Traits\HasUuidPrimaryKey;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * 
 * @property uuid $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string|null $phone
 * @property Carbon|null $birthday
 * @property string|null $occupation
 * @property USER-DEFINED|null $role
 * @property bool|null $professional_account
 * @property bool|null $is_verified
 * @property uuid $subscription_id
 * @property string $password_hash
 * @property Carbon|null $last_login
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Subscription $subscription
 * @property Collection|Template[] $templates
 * @property Collection|GeneratedDocument[] $generated_documents
 * @property Collection|TemplateRating[] $template_ratings
 * @property Collection|TemplateVersion[] $template_versions
 * @property Collection|AuditLog[] $audit_logs
 * @property Collection|UserSession[] $user_sessions
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use HasUuidPrimaryKey, HasFactory, Notifiable, HasApiTokens;

	protected $table = 'users';
	public $incrementing = false;

	protected $casts = [
		'id' => 'uuid',
		'birthday' => 'datetime',
		'role' => 'USER-DEFINED',
		'professional_account' => 'bool',
		'is_verified' => 'bool',
		'subscription_id' => 'uuid',
		'last_login' => 'datetime'
	];

	protected $fillable = [
		'firstname',
		'lastname',
		'email',
		'phone',
		'birthday',
		'occupation',
		'role',
		'professional_account',
		'is_verified',
		'subscription_id',
		'password_hash',
		'last_login'
	];

	public function subscription()
	{
		return $this->belongsTo(Subscription::class);
	}

	public function templates()
	{
		return $this->hasMany(Template::class, 'author_id');
	}

	public function generated_documents()
	{
		return $this->hasMany(GeneratedDocument::class);
	}

	public function template_ratings()
	{
		return $this->hasMany(TemplateRating::class);
	}

	public function template_versions()
	{
		return $this->hasMany(TemplateVersion::class, 'created_by');
	}

	public function audit_logs()
	{
		return $this->hasMany(AuditLog::class);
	}

	public function user_sessions()
	{
		return $this->hasMany(UserSession::class);
	}
}
