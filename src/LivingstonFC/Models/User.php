<?php
namespace LivingstonFC\Models;

class User extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'User';

     public function authenticate($apiKey)
     {
         $user = User::where('userApiKey', '=', $apiKey)->take(1)->get();
         $this->details = $user[0];
         return ($user[0]->exists) ? true : false;
     }

     public static function exists($email){
         $obj = static::where('email', '=', $email)->first();
         return $obj ?: false;
     }

      public static function generateApiKey() {
          return base64_encode(rand());
      }

     public function output() {
         $output = [];
         $output['username'] = $this->username;
         $output['email'] = $this->email;
         $output['password'] = $this->password;
         $output['fullMembership'] = $this->fullMembership;
         $output['BBCApiKey'] = $this->BBCApiKey;
         $output['userApiKey'] = $this->userApiKey;
         $output['created_at'] = $this->created_at;
         $output['updated_at'] = $this->updated_at;
         $output['userUri'] = '/user/' . $this->username;
       return $output;
     }
} ?>
