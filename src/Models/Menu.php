<?php

namespace Keling\Menu\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model{
	protected $fillable = [
        'name',
        'parent_id',
        'sort',
    ];
}

?>