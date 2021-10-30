<?php

namespace Gui\Mvc\Models;

use Gui\Mvc\Core\Model;

class AdminModel extends Model
{
    public string $table = "admins";

    public $fillable = [
        'username', 'password', 'email', 'status'
    ];

    public $protected = [
        
    ];


}