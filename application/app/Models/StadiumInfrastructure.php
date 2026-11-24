<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StadiumInfrastructure extends Model
{
    use HasFactory;

    protected $table = 'stadium_infrastructures';

    protected $fillable = [
        'stadium_id',
        'infrastructure_name',
        'available_games',
        'status',
    ];

    public function stadium()
    {
        return $this->belongsTo(StudiumMasterModel::class, 'stadium_id', 'id');
    }
}
