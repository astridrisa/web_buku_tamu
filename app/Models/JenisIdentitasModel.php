<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperJenisIdentitasModel
 */
class JenisIdentitasModel extends Model
{
    use HasFactory;

    protected $table = 'jenis_identitas';
    protected $fillable = ['nama'];
}
