<?php
namespace App\Models\ReportsFolders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use SoftDeletes;
    protected $table = 'repfol_folders';
    protected $fillable = array(
      0 => 'name',
      1 => 'type',
      2 => 'folder_id',
    );
    protected $attributes = array(
      'name' => null,
      'type' => 'FOLDER',
    );
    protected $casts = array(
      'name' => 'string',
      'type' => 'string',
    );
    public function folder()
    {
        return $this->belongsTo('App\Models\ReportsFolders\Folder');
    }


    public function children()
    {
        return $this->hasMany('App\Models\ReportsFolders\Folder');
    }


    public function reports()
    {
        return $this->hasMany('App\Models\ReportsFolders\Report');
    }
}
