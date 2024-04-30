<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XPoints extends Model
{
    protected $table = 'xp_records';
    protected $fillable = ['user_id', 'xp_amount', 'tenant_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
