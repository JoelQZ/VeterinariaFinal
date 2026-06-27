<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Owner extends Model{
    protected $fillable = [
        'name',
        'phone',
        'address'
    ];
    public $timestamps = false;

    public function pets(){
        return $this->hasMany(Pet::class, 'owner_id');
    }
}