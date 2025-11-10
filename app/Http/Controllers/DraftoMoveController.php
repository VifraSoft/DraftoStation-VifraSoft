<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\DraftoScoringService;
use Illuminate\Validation\ValidationException;

class DraftoMoveController extends Controller
{
    public function __construct(
        private DraftoScoringService $scoring
    ) {}

    public function store(Request $request): JsonResponse
    {
        // Valida sólo lo necesario para calcular puntos de la jugada actual
        $data = $request->validate([          
            'regionId'  => 'required|string|max:64',
            'pieceType' => 'required|string|max:64', // ajusta a tus tipos
            'playerId'  => 'required|string|max:64',
        ]);

        // Aquí podrías hacer checks como:
        // - ¿La región existe y está libre?
        // - ¿El jugador tiene esa ficha disponible?
        // - ¿La jugada es válida según reglas del turno?
        // En este ejemplo nos concentramos en el cálculo de puntos.

        $points = $this->scoring->scoreMove(          
            playerId: $data['playerId'],
            regionId: $data['regionId'],
            pieceType:$data['pieceType'],
        );

        return response()->json([
            'points'  => $points,
            // 'details' => [...], // si quieres devolver desglose del cálculo
        ]);
    }

    
}
