<?php
namespace App\Models\UserAdministration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Fideicomiso extends Model
{
    use SoftDeletes, Notifiable;
    protected $table = 'adm_fideicomisos';
    protected $fillable = array(
      0 => 'decreto',
      1 => 'financiador',
      2 => 'empresa_id',
    );
    protected $attributes = array(
      'decreto' => '',
      'financiador' => '',
    );
    protected $casts = array(
      'decreto' => 'string',
      'financiador' => 'string',
    );
    protected $events = array(
    );
    public function empresa()
    {
        return $this->belongsTo('App\Models\UserAdministration\Empresa');
    }
}