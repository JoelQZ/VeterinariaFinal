<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Pet extends Model{
    protected $fillable = [
        'name',
        'species',
        'breed',
        'age',
        'image',
        'owner_id'
    ];
    public $timestamps = false;

    public function owner(){
        return $this->belongsTo(Owner::class, 'owner_id');
    }
}