<?php
namespace App\Models\UserAdministration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Login extends Model
{
    use SoftDeletes;
    protected $table = 'usradm_logins';
    protected $fillable = array(
      0 => 'username',
      1 => 'password',
      2 => 'token',
    );
    protected $attributes = array(
      'username' => '',
      'password' => '',
      'token' => '',
    );
    protected $casts = array(
      'username' => 'string',
      'password' => 'string',
      'token' => 'string',
    );
    public function validate($username, $password)
    {
        $user = User::where('username', '=', $username)
                        ->where('password', '=', $password)
                        ->first();
        $token = uniqid();
        if (!empty($user)) {
            $login = new Login();
            $login->username = $username;
            $login->password = $password;
            $login->token = $token;
            $login->save();
        }
        return !empty($user)?['token'=>$token,'user_id'=>$user->id]:false;
    }
}