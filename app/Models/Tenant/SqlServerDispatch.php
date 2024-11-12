<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class SqlServerDispatch extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'dispatches'; // Cambia esto al nombre de tu tabla

    // Si los campos no son fillable por defecto
    protected $fillable = [
        'campo1',
        'campo2',
        'campo3',
        // Otros campos que necesites
    ];
}
