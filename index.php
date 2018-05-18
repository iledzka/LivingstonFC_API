<?php

require 'vendor/autoload.php';
include 'bootstrap.php';

use LivingstonFC\Models\CoachingStaff;
use LivingstonFC\Models\CommunityEvent;
use LivingstonFC\Models\CompetitionStats;
use LivingstonFC\Models\LivingstonGame;
use LivingstonFC\Models\SeasonTickets;
use LivingstonFC\Models\Conferencing;
use LivingstonFC\Models\Player;
use LivingstonFC\Models\Token;
use LivingstonFC\Models\User;
use LivingstonFC\Models\Admin;
use LivingstonFC\Models\Team;
use LivingstonFC\Middleware\Logging as LivingstonFCLogging;
use LivingstonFC\Middleware\Authentication as LivingstonFCAuth;
use LivingstonFC\Middleware\FileMove;
use LivingstonFC\Middleware\FileFilter;
use LivingstonFC\Middleware\ImageRemoveExif;
use LivingstonFC\Middleware\ParamValidation;

$app  = new \Slim\App();
$app->add(new LivingstonFCLogging());
$app->add(new LivingstonFCAuth());

$app->get('/coachingstaff', function($request, $response, $args) {
  $_coachingStaff = new CoachingStaff();
  $coachingStaff = $_coachingStaff->all();

  $payload = [];
  foreach($coachingStaff as $_coach) {
    $payload[$_coach->id] = $_coach->output();
  }

  return $response->withStatus(200)->withJson($payload);

});


$app->get('/coachingstaff/{id}', function($request, $response, $args) {
  $_coach = CoachingStaff::find($args['id']);

    $payload = [];
    $payload[$_coach->id] =  $_coach->output();

  return $response->withStatus(200)->withJson($payload);

});

$app->get('/communityevent', function($request, $response, $args) {
  $_communityEvent = new CommunityEvent();
  $communityEvent = $_communityEvent->all();

  $payload = [];
  foreach($communityEvent as $_event) {
    $payload[$_event->id] = $_event->output();
  }

  return $response->withStatus(200)->withJson($payload);

});

$app->get('/communityevent/{id}', function($request, $response, $args) {
  $_event = CommunityEvent::find($args['id']);

    $payload = [];
    $payload[$_event->id] =  $_event->output();


  return $response->withStatus(200)->withJson($payload);

});

/*
 * Get all Competition Stats ordered by position in the table.
 */
$app->get('/competitionstats', function($request, $response, $args) {
  $_competitionStats = new CompetitionStats();
  $__competitionStats = $_competitionStats->all();

  $payload = [];
  foreach ($__competitionStats as $competitionStats){
    $payload[$competitionStats->position] = $competitionStats->output();
  }
  return $response->withStatus(200)->withJson($payload);

});

/*
 * Get Competition Stats by id.
 */
$app->get('/competitionstats/{id}', function($request, $response, $args) {
  $competitionStats = CompetitionStats::find($args['id']);

  $payload = [];
  $payload[$competitionStats->id] = $competitionStats->output();

  return $response->withStatus(200)->withJson($payload);

});

$app->get('/livingstongame', function($request, $response, $args) {
  $_livingstonGame = new LivingstonGame();
  $__livingstonGame = $_livingstonGame->all();

  $payload = [];
  foreach ($__livingstonGame as $livingstonGame){
    $payload[$livingstonGame->id] = $livingstonGame->output();
  }
  return $response->withStatus(200)->withJson($payload);

});

$app->get('/livingstongame/{id}', function($request, $response, $args) {
  $livingstonGame = LivingstonGame::find($args['id']);

  $payload = [];
  $payload[$livingstonGame->id] = $livingstonGame->output();

  return $response->withStatus(200)->withJson($payload);

});

$app->get('/player', function($request, $response, $args) {
  $_player = new Player();
  $__player = $_player->all();

  $payload = [];
  foreach ($__player as $player){
    $payload[$player->id] = $player->output();
  }
  return $response->withStatus(200)->withJson($payload);

});

$app->get('/player/{id}', function($request, $response, $args) {
  $player = Player::find($args['id']);

  $payload = [];
  $payload[$player->id] = $player->output();

  return $response->withStatus(200)->withJson($payload);

});

$app->get('/conferencing', function($request, $response, $args) {
  $_conferencing = new Conferencing();
  $conferencing = $_conferencing->all();

  $payload = [];
  foreach($conferencing as $suiteDetails){
    $payload[$suiteDetails->id] = $suiteDetails->output();
  }

  return $response->withStatus(200)->withJson($payload);

});

$app->get('/team', function($request, $response, $args) {
  $_team = new Team();
  $team = $_team->get();

  $payload = [];
  foreach($team as $singleTeam){
    $payload[$singleTeam->name] = $singleTeam->output();
  }

  return $response->withStatus(200)->withJson($payload);

});

$app->get('/seasontickets', function($request, $response, $args) {
  $_tickets = new SeasonTickets();
  $__tickets = $_tickets->all();

  $payload = [];
  foreach ($__tickets as $tickets){
    $payload[$tickets->validInYearStart] = $tickets->output();
  }
  return $response->withStatus(200)->withJson($payload);

});

$app->get('/seasontickets/{validInYearStart}', function($request, $response, $args) {
  $tickets = SeasonTickets::where('validInYearStart', '=', $args['validInYearStart'])->first();

  $payload = [];
  $payload[$tickets->validInYearStart] = $tickets->output();

  return $response->withStatus(200)->withJson($payload);

});

$app->get('/user', function($request, $response, $args) {
  $_users = new User();
  $users = $_users->get();

  $payload = [];
  foreach($users as $user){
    $payload[$user->username] = $user->output();
  }

  return $response->withStatus(200)->withJson($payload);

});

$app->get('/fullmembership', function($request, $response, $args) {
  $users = User::where('fullMembership', '=', '0')->get();

  $payload = [];
  foreach ($users as $user){
    $payload[$user->username] = $user->output();
  }
  return $response->withStatus(200)->withJson($payload);
});

$app->get('/partialmembership', function($request, $response, $args) {
  $_user = new User();
  $users = $user = User::where('fullMembership', '=', '1')->get();

  $payload = [];
  foreach ($users as $user){
    $payload[$user->username] = $user->output();
  }
  return $response->withStatus(200)->withJson($payload);
});

//User login authorisation. When successful, User (or Admin) receives a JWT token valid for an hour.
$app->post('/login', function($request, $response, $args) {
    $username = $request->getParsedBodyParam('username', '');
    $email = $request->getParsedBodyParam('email', '');
    $password = $request->getParsedBodyParam('password', '');
    if (!empty($username)) {
      $matches = ['username' => $username, 'password' => $password];
    } else if (!empty($email)) {
      $matches = ['email' => $email, 'password' => $password];
    }


    $user = User::where($matches)->get();

    $admin = Admin::where($matches)->get();

    $token = new Token();

    if (!$user->isEmpty()){
        $userToken = ['access_token' => $token->generateUserJWT($user[0]['username'], $user[0]['email'], $user[0]['fullMembership'])];
        return $response->withStatus(200)->withJson($userToken);
    } else if (!$admin->isEmpty()){
        $adminToken = ['access_token' => $token->generateAdminJWT($admin[0]['adminID'], $admin[0]['email'])];
        return $response->withStatus(200)->withJson($adminToken);
    } else {
        return $response->withStatus(401)->withJson("Log in unsuccessful.");
    }

});

$paramValidator = new ParamValidation();

//Register new User. Returns custom API key.
$app->post('/register', function($request, $response, $args) {
    $username = $request->getParsedBodyParam('username', '');
    $email = $request->getParsedBodyParam('email', '');
    $password = $request->getParsedBodyParam('password', '');
    $partial_membership = $request->getParsedBodyParam('partial_membership', '');

    //$user =  User::findOrCreate($email);
    $user = User::exists($email);
    if (!$user){
      $user = new User();
      $user->username = $username;
      $user->password = $password;
      $user->email = $email;
      $user->fullMembership = ($partial_membership === 'true') ? 0 : 1;
      $user->BBCApiKey = 'e21de5ee495740e7b74f01e526826260';
      $user->userApiKey = User::generateApiKey();
      $user->save();
    } else {
      return $response->withStatus(422);
    }


    if ($user->username && $user->email){
      $payload = ['username' => $user->username,
                  'userUri' => 'user/' . $user->username,
                  'userApiKey' => $user->userApiKey
                  ];
      return $response->withStatus(201)->withJson($payload);
    } else {
      return $response->withStatus(400);
    }
})->add($paramValidator);

$filter = new FileFilter();
$removeExif = new ImageRemoveExif();
$move = new FileMove();

$app->post('/communityevent', function($request, $response, $args) {

    $event_name = $request->getParsedBodyParam('name', '');
    $event_desc = $request->getParsedBodyParam('description', '');
    $event_link = $request->getParsedBodyParam('link', '');
    $event_image = $request->getAttribute('png_filename');

    $communityEvent = new CommunityEvent();
    $communityEvent->name = $event_name;
    $communityEvent->image = $event_image;
    $communityEvent->description = $event_desc;
    $communityEvent->link =$event_link;
    $communityEvent->save();

    if ($communityEvent->id){
      $payload = ['communityEventId' => $communityEvent->id,
                  'communityEventUri' => 'communityevent/' . $communityEvent->id];
      return $response->withStatus(201)->withJson($payload);
    } else {
      return $response->withStatus(400);
    }
})->add($filter)->add($removeExif)->add($move);

$app->post('/competitionstats', function($request, $response, $args) {

    $competition = $request->getParsedBodyParam('competition', '');
    $year = $request->getParsedBodyParam('competitionYearStarted', '');
    $teamName = $request->getParsedBodyParam('teamName', '');
    $position = $request->getParsedBodyParam('position', '');
    $played = $request->getParsedBodyParam('played', '');
    $won = $request->getParsedBodyParam('won', '');
    $drawn = $request->getParsedBodyParam('drawn', '');
    $lost = $request->getParsedBodyParam('lost', '');
    $for = $request->getParsedBodyParam('for', '');
    $against = $request->getParsedBodyParam('against', '');
    $points = $request->getParsedBodyParam('points', '');

    $competitionStats = new CompetitionStats();
    $competitionStats->competition = $competition;
    $competitionStats->competitionYearStarted = $year;
    $competitionStats->teamName = $teamName;
    $competitionStats->position = $position;
    $competitionStats->played = $played;
    $competitionStats->won = $won;
    $competitionStats->drawn = $drawn;
    $competitionStats->lost = $lost;
    $competitionStats->for = $for;
    $competitionStats->against = $against;
    $competitionStats->points = $points;
    $competitionStats->save();

    if ($competitionStats->competition && $competitionStats->competitionYearStarted && $competitionStats->teamName){
      $payload = [];
      $payload[$competitionStats->id] = ['competition'            => $competitionStats->competition,
                                         'competitionYearStarted' => $competitionStats->competitionYearStarted,
                                         'teamName'               => $competitionStats->teamName,
                                         'competitionStatsUri'      => 'competitionstats/' . $competitionStats->id];
      return $response->withStatus(201)->withJson($payload);
    } else {
      return $response->withStatus(400);
    }
});

$app->delete('/communityevent/{communityEventId}', function($request, $response, $args) {

    $communityEvent = CommunityEvent::find($args['communityEventId']);
    $communityEvent->delete();

    if ($communityEvent->exists){
        return $response->withStatus(400);
    } else {
      return $response->withStatus(204);
    }
});

$app->run();
?>
