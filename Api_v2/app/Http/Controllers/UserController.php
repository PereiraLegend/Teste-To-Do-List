<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Listar todos os usuários
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Mostrar um usuário específico
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }
        return response()->json($user);
    }

    // Atualizar dados de um usuário
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $user->name = $request->input('name', $user->name);
        $user->email = $request->input('email', $user->email);

        // Atualizar a senha, se fornecida
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return response()->json($user);
    }

    // Deletar um usuário
    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'Usuário deletado com sucesso']);
    }

    // Promover um usuário para admin
    public function promote($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        if ($user->role === 'admin') {
            return response()->json(['message' => 'O usuário já é um admin'], 400);
        }

        $user->role = 'admin';
        $user->save();

        return response()->json(['message' => 'Usuário promovido para admin com sucesso']);
    }
}
