<?php
// Tenant.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['name','admin_user_id'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function XPoints()
    {
        return $this->hasManyThrough(XPoints::class, User::class);
    }
}
