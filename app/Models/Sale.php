<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Sale extends Model{
    use HasFactory;
    protected $fillable = [
        'appointment_id',
        'owner_id',
        'total',
        'payment_method',
        'date',
        'time',
    ];

    public $timestamps = false;

    public function details(){
        return $this->hasMany(SaleDetail::class);
    }

    public function owner(){
        return $this->belongsTo(Owner::class);
    }
}