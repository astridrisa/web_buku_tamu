<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\UserModel;

/**
 * @mixin IdeHelperRoleModel
 */
class RoleModel extends Model
{
    use HasFactory;
    protected $table = 'role';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_role', 'created_at', 'updated_at'];

    public function user(): HasMany
    {
        return $this->hasMany(UserModel::class, 'id', 'role_id');
    }
}