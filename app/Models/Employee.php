<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'dept_id',
        'status'
    ];

    function Address(){
        return $this->hasMany(AddressEmployee::class, 'employee_id');
        //return $this->hasOne(AddressEmployee::class);
    }
    public function phone()
    {
        return $this->hasMany(phonenumberEmployee::class, 'employee_id');
        //return $this->hasOne(phonenumberEmployee::class);
    }
    function Department(){
        return $this->hasMany(department::class, 'id');
        //return $this->hasOne(AddressEmployee::class);
    }
   
}
