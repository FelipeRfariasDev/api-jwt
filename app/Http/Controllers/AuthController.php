<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function novo_usuario(Request $request)
    {
        $nome = $request->nome;
        $email = $request->email;
        $password = $request->password;

        if (empty($nome) or empty($email) or empty($password)) {
            return response()->json(['status' => 'error', 'message' => 'Você deve preencher todos os campos']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 'error', 'message' => 'Você deve inserir um e-mail válido']);
        }

        if (strlen($password) < 6) {
            return response()->json(['status' => 'error', 'message' => 'A senha deve ter no mínimo 6 caracteres']);
        }

        // Check if user already exist
        if (User::where('email', '=', $email)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'O usuário já existe com este e-mail']);
        }

        try {
            $user = new User();
            $user->nome = $request->nome;
            $user->email = $request->email;
            $user->password = app('hash')->make($request->password);

            if ($user->save()) {
                return $this->login($request);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Desconectado com sucesso']);
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        // Check if field is empty
        if (empty($email) or empty($password)) {
            return response()->json(['status' => 'error', 'message' => 'Você deve preencher todos os campos']);
        }

        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Não autorizado'], 401);
        }

        return $this->getTokenJwt($token);
    }

    protected function getTokenJwt($token)
    {
        return response()->json([
            'token_acesso' => $token,
            'tipo_token' => 'Bearer',
            'expira_em' => auth()->factory()->getTTL() * 60
        ]);
    }
}
