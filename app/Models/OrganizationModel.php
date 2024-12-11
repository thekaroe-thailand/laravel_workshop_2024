<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationModel extends Model
{
    protected $table = 'organizations';
    protected $fillable = [
        'name', 'address', 'phone', 'tax_code', 'logo',
        'amount_water', 'amount_water_per_unit', 'amount_electric_per_unit',
        'amount_internet', 'amount_etc'
    ];
    
    public $timestamps = false;
}
