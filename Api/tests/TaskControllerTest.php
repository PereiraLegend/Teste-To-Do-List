<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Task;

class TaskControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        $task = Task::create(['title' => 'Testando Task', 'description' => 'Testando a Task' , 'status' => 'todo']);

        $response = $this->get('/tasks');

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->seeJsonContains(['title' => 'Testando Task', 'status' => 'todo']);
    }

    public function testCreate()
    {
        $data = ['title' => 'Nova Task', 'description' => 'Nova Task Criada', 'status' => 'todo'];

        $response = $this->post('/tasks', $data);

        $this->assertEquals(201, $this->response->getStatusCode());
        $this->seeJsonContains($data);
    }

    public function testUpdate()
    {
        $task = Task::create(['title' => 'Atualizando Task', 'description' => 'Atualizando a Task', 'status' => 'todo']);

        $data = ['title' => 'Atualizando Task', 'status' => 'done'];

        $response = $this->put("/tasks/{$task->id}", $data);

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->seeJsonContains($data);
    }

    public function testDestroy()
    {
        $task = Task::create(['title' => 'Deletando Task', 'description' => 'Deletando a Task', 'status' => 'todo']);

        $response = $this->delete("/tasks/{$task->id}");

        $this->assertEquals(204, $this->response->getStatusCode());

        $this->notSeeInDatabase('tasks', ['id' => $task->id]);
    }
}
