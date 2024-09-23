<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    // teste: deve fazer login e a api retornar um token
    public function testItShouldLoginAndReturnAToken()
    {
        $user = new User();
        $user->name = 'teste';
        $user->email = 'teste@teste.com';
        $user->password = app('hash')->make('123456');
        $user->role = 'client';
        $user->save();

        $response = $this->post('/api/login', [
            'email' => 'teste@teste.com',
            'password' => '123456',
        ]);

        $response->seeStatusCode(200);
        $response->seeJsonStructure(['token']);
    }

    // teste: deve acessar a rota com o token válido
    public function testItShouldAccessProtectedRouteWithValidToken()
    {
        $user = new User();
        $user->name = 'teste';
        $user->email = 'teste@teste.com';
        $user->password = app('hash')->make('123456');
        $user->role = 'client';
        $user->save();

        $token = JWTAuth::fromUser($user);

        $response = $this->get('/api/tasks', [
            'Authorization' => "Bearer $token"
        ]);

        $response->seeStatusCode(200);
    }

    //teste: deve retornar "unauthoized" caso a requisição não tenha token
    public function testItShouldReturnUnauthorizedIfTokenIsNotProvided()
    {
        $response = $this->get('/api/tasks');

        $response->seeStatusCode(401);
    }

    //teste: o cliente não pode acessar rotas administrativas
    public function testItShouldNotAllowClientToAccessAdminRoutes()
    {
        $client = new User();
        $client->name = 'teste';
        $client->email = 'teste@teste.com';
        $client->password = app('hash')->make('123456');
        $client->role = 'client';
        $client->save();

        $token = JWTAuth::fromUser($client);

        $response = $this->get('/api/admin/tasks', [
            'Authorization' => "Bearer $token"
        ]);

        $response->seeStatusCode(403);
    }

    //teste: o admin pode acessar rotas administrativas
    public function testItShouldAllowAdminToAccessAdminRoutes()
    {
        $admin = new User();
        $admin->name = 'admin';
        $admin->email = 'admin@teste.com';
        $admin->password = app('hash')->make('123456');
        $admin->role = 'admin';
        $admin->save();

        $token = JWTAuth::fromUser($admin);

        $response = $this->get('/api/admin/tasks', [
            'Authorization' => "Bearer $token"
        ]);

        $response->seeStatusCode(200);
    }

    //teste: deve retornar "token invalid" caso o token esteja errado
    public function testItShouldReturnTokenInvalidIfTokenIsMalformed()
    {
        $response = $this->get('/api/tasks', [
            'Authorization' => "Bearer invalid_token"
        ]);

        $response->seeStatusCode(401);
        $response->seeJson(['error' => 'Token is invalid']);
    }
}
