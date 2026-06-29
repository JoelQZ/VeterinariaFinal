<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Appointment extends Model{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'pet',
        'owner',
        'date',
        'time',
        'reason',
        'status',
    ];

    public function petRelation(){
        return $this->belongsTo(Pet::class, 'pet');
    }

    public function ownerRelation(){
        return $this->belongsTo(Owner::class, 'owner');
    }
}