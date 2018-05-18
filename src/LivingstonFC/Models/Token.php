<?php
namespace LivingstonFC\Models;
// use the firebase JWT Library previous installed using composer
use \Firebase\JWT\JWT;

class Token {

// key for JWT signing and validation, shouldn't be changed
private $key = "LiviLions";

// Generates and signs a JWT for User
public function generateUserJWT($username, $email, $membership) {

    // Make an array for the JWT Payload
    $payload = array(
        "username" => $username,
        "email" => $email,
        "exp" => time() + (60 * 60),
        "admin" => false,
        "full_membership" => $membership
    );

    // encode the payload using our secretkey and return the token
    return JWT::encode($payload, $this->key);
}

// Generates and signs a JWT for User
public function generateAdminJWT($id, $email) {

    // Make an array for the JWT Payload
    $payload = array(
        "id" => $id,
        "email" => $email,
        "exp" => time() + (60 * 60),
        "admin" => true
    );

    // encode the payload using our secretkey and return the token
    return JWT::encode($payload, $this->key);
}

private function validJWT($token){
   $res = array(false, '');
   // using a try and catch to verify
   try {
     $decoded = JWT::decode($token, $this->key, array('HS256'));

   } catch (Exception $e) {
     return $res;
   } catch (\Firebase\JWT\ExpiredException $e) {
     print "Error!: " . $e->getMessage() . "";
     return $res;
   } catch (\Firebase\JWT\SignatureInvalidException $e) {
     print "Error!: " . $e->getMessage();
     return $res;
   }
   $res['0'] = true;
   $res['1'] = (array) $decoded;

   return $res;
}

public function isValidUserToken($token){
  $res = $this->validJWT($token);
  if ($res['0'] != false){
    if ($res['1']['admin'] === false){
      return true;
    }
  }
  return false;
}
public function isValidAdminToken($token){
  $res = $this->validJWT($token);

  if ($res['0'] != false){
    if ($res['1']['admin'] === true){
      return true;
    }
  }
  return false;
}
}
 ?>
