<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Listar todas as tasks do usuário logado (para client e admin)
    public function index()
    {
        $user = auth()->user();
        $tasks = $user->tasks;
        return response()->json($tasks);
    }

    // Criar uma task para o usuário logado
    public function create(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|in:todo,done',
        ]);

        $task = $user->tasks()->create($request->all());
        return response()->json($task, 201);
    }

    // Mostrar uma task específica
    public function show($id)
    {
        $user = auth()->user();
        $task = $user->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        return response()->json($task);
    }

    // Atualizar uma task
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $task = $user->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        $task->title = $request->input('title', $task->title);
        $task->title = $request->input('description', $task->title);
        $task->status = $request->input('status', $task->status);

        $task->save();
        return response()->json($task);
    }

    // Deletar uma task
    public function delete($id)
    {
        $user = auth()->user();
        $task = $user->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Tarefa deletada com sucesso']);
    }

    // Listar todas as tasks de todos os usuários
    public function adminIndex()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    // Listar todas as tasks de um usuário específico
    public function userTasks($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $tasks = $user->tasks;
        return response()->json($tasks);
    }
}
