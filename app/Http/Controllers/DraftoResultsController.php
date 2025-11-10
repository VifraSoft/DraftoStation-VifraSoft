<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Partida;
use App\Models\Jugador;
use App\Models\Jugada;

class DraftoResultsController extends Controller
{
    /**
     * POST /draftostation/resultados
     * Crea una partida y asocia jugadores (M:N) con sus puntos.
     *
     * Payload esperado:
     * {
     *   "nombrePartida": "Partida del sábado",
     *   "jugadores": [
     *      { "nombre": "Asley",  "puntos": 12 },
     *      { "nombre": "Valeria","puntos": 9  }
     *   ]
     * }
     */
    public function store(Request $request): JsonResponse
    {
        // Si tu front aún envía en inglés, podés mapear aquí antes de validar.
        $data = $request->validate([
            
            'jugadores'              => ['required','array','min:1'],
            'jugadores.*.nombre'     => ['required','string','max:100'],
            'jugadores.*.puntos'     => ['required','integer','min:0'],
        ]);

       $partida = DB::transaction(function () use ($data) {
        // 1) Crear la partida (nombre temporal) y luego renombrar con su ID
        $partida = Partida::create(['nombre_partida' => 'temp']);
        $nombreGenerado = 'Partida-' . $partida->id; // o con padding: str_pad($partida->id, 5, '0', STR_PAD_LEFT)
        $partida->update(['nombre_partida' => $nombreGenerado]);

        // 2) Recorrer jugadores del payload
        foreach ($data['jugadores'] as $j) {
            $nombre = trim($j['nombre']);

            // 2a) Buscar o crear jugador
            $jugador = Jugador::firstOrCreate(['nombre' => $nombre]);

            // 2b) Escribir/asegurar fila en pivote con puntos (sin duplicar si ya existe)
            //     --> genera/actualiza: partida_id, jugador_id, puntos
            $partida->jugadores()->syncWithoutDetaching([
                $jugador->id => ['puntos' => (int) $j['puntos']],
            ]);
       }
       $actualizadas = Jugada::whereNull('partida_id')            
            ->update([
                'partida_id' => $partida->id,
                'updated_at' => now(),
            ]);

            return $partida->load(['jugadores' => fn($q) => $q->orderByDesc('pivot_puntos')]);
        });

        return response()->json([
            'guardado'   => true,
            'partidaId'  => $partida->id,
            'nombre'     => $partida->nombre_partida
        ], 201);
    }

    /**
     * (Opcional) GET /draftostation/resultados
     * Lista últimas 20 partidas con puntajes.
     */
 public function history()
    {
        // 1) Totales históricos por jugador (SUM en toda la pivote)
        $totalesPorJugador = DB::table('jugador_partida')
            ->select('jugador_id', DB::raw('SUM(puntos) AS total'))
            ->groupBy('jugador_id')
            ->pluck('total', 'jugador_id');

        // 2) Partidas con jugadores (orden por id de partida asc)
        $partidas = Partida::with([
                'jugadores' => fn($q) => $q->orderByPivot('puntos','desc')
            ])
            ->orderBy('id','asc')
            ->get();

        // 3) Aplanar a filas
        $rows = [];
        foreach ($partidas as $p) {
            foreach ($p->jugadores as $j) {
                $rows[] = [
                    'partidaId'     => $p->id,
                    'nombrePartida' => $p->nombre_partida,
                    'jugadorId'     => $j->id,
                    'jugador'       => $j->nombre,
                    'puntos'        => (int) $j->pivot->puntos,
                    'total'         => (int) ($totalesPorJugador[$j->id] ?? 0),
                ];
            }
        }

        // Renderizar la vista con $rows
        return view('draftostation.historico', [
            'rows' => $rows,
        ]);
    }
}
