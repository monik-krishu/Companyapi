<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'task_master';

    protected $primaryKey = 'task_id';

    public $fillable = [
        'task_name',
        'start_date',
        'end_date',
        'status'

    ];
    //protected $guarded = ['updated_at','created_at'];
}
