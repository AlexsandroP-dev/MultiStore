<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfigLojaSession
{
    public function handle(Request $request, Closure $next): Response
    {
        $loja = $request->route('loja');

        if ($loja && is_object($loja)) {
            // Só atualiza a sessão se for uma loja diferente da que já está lá
            if (session('loja_id') !== $loja->id) {
                session([
                    'loja_id'   => $loja->id,
                    'loja_nome' => $loja->nome,
                    'loja_slug' => $loja->slug,
                    'loja_logo' => $loja->diretorio_logo,
                ]);
            }
        }

        return $next($request);
    }
}
