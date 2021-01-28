<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ide_cli',
        //'nit_cli',
        'ide_type_cli',
        'first_name_cli',
        'sur_name_cli',
        'business_name_cli',
        'address_cli',
        'phone_cli',
        'specialty_cli',
        'user_id',
        'client_types_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function client_types()
    {
        return $this->belongsTo(ClientType::class);
    }
}
