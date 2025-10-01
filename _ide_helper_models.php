<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisIdentitasModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisIdentitasModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisIdentitasModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisIdentitasModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisIdentitasModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisIdentitasModel whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisIdentitasModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperJenisIdentitasModel {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserModel> $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleModel whereNamaRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRoleModel {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $no_telepon
 * @property string $tujuan
 * @property string $email
 * @property int $jumlah_rombongan
 * @property int $jenis_identitas_id
 * @property int|null $role_id
 * @property string|null $status
 * @property string|null $qr_code
 * @property \Illuminate\Support\Carbon|null $checkin_at
 * @property string|null $approved_at
 * @property \Illuminate\Support\Carbon|null $checkout_at
 * @property int|null $approved_by
 * @property int|null $checkin_by
 * @property int|null $checkout_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\UserModel|null $approvedBy
 * @property-read \App\Models\UserModel|null $checkinBy
 * @property-read \App\Models\UserModel|null $checkoutBy
 * @property-read mixed $status_color
 * @property-read mixed $status_text
 * @property-read \App\Models\JenisIdentitasModel $jenisIdentitas
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereCheckinAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereCheckinBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereCheckoutAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereCheckoutBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereJenisIdentitasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereJumlahRombongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereNoTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereTujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TamuModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTamuModel {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $role_id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\RoleModel $role
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserModel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserModel whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserModel wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserModel whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserModel whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUserModel {}
}

