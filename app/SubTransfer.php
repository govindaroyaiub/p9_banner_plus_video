<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubTransfer extends Model
{
    protected $table = 'subtransfers';

    protected $fillable = ['transfer_id', 'path'];
}
