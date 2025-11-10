<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Jugador;
use App\Models\Recinto;
use App\Models\Ficha;
use App\Models\Jugada;

class DraftoScoringService
{
    /**
     * Calcula los puntos de UNA jugada usando SOLO:
     * - $pieceType  (T-Rex | Raptor | Triceratops | Brachio | Stego | Ankylo)
     * - $regionId   (bosque | rio | llanura | montana | pantano | desierto | costa)
     *
     * $boardId y $playerId se ignoran para este cálculo simple.
     */

   

    //  private recintoReglas=[
    //     "circuito_uniforme"=>"iguales", //2,4,8,12,18,24
    //     "pixeles_variados"=>"diferentes", //1,3,6,10,15,21
    //     "cuartel_multijugador"=>"perejas", //5 pto por cada pareja, al final tambien
    //     "triple_a"=>"solo_tres_cualquiera", //cuando llegues a tener a 3 obtienes 7 ptos
    //     "consola_del_año"=>"el_mas_presente_resto_regiones",//1 al colocar atari, ademas al final si el que colocaste eres el jugardor en otras areas +7 pts
    //     "edicion_limitada"=>"tipo_solo_presente_aca",//7 puntos por poner uno aca que solo esta aca y en mas ningun lugar
    //     "taller"=>"exedente"//1
    // ];

    
    


    public function scoreMove(
        string $playerId,
        string $regionId,
        string $pieceType,
        ?string $partidaNombre = null
    ): int {
        return DB::transaction(function () use ($playerId, $regionId, $pieceType, $partidaNombre) {

            $jugador = Jugador::firstOrCreate(['nombre' => trim($playerId)]);

            $recinto = Recinto::where('nombre_recinto', trim($regionId))->first();
            if (!$recinto) {
                throw ValidationException::withMessages([
                    'regionId' => "El recinto '{$regionId}' no existe.",
                ]);
            }
           

            $ficha = Ficha::where('nombre', trim($pieceType))->first();
            if (!$ficha) {
                throw ValidationException::withMessages([
                    'pieceType' => "La ficha '{$pieceType}' no existe.",
                ]);
            }

            $partidaId = null;
            if ($partidaNombre !== null && $partidaNombre !== '') {
                $partida = Partida::where('nombre_partida', trim($partidaNombre))->first();
                // Si no existe, puedes decidir crearla aquí; por ahora solo asociamos si existe
                $partidaId = $partida?->id;
            }

            // 1) Calcular puntos ANTES de insertar la jugada (para no contarse doble)
             $jugada = Jugada::create([
                'partida_id' => $partidaId,           // puede ir null
                'jugador_id' => $jugador->id,
                'ficha_id'   => $ficha->id,
                'recinto_id' => $recinto->id
                        // si agregaste el campo; si no, quítalo
            ]);
             
            $points = $this->calculatePoints(
                jugadorParam: $jugador->nombre,
                recintoParam: $recinto->nombre_recinto,
                fichaParam:   $ficha->nombre,
                partidaId: $partidaId
            );

            // 2) Persistir la jugada
            

           

              return (int) $points;
        });
    }

     private function calculatePoints(string $jugadorParam, string $recintoParam, string $fichaParam, ?int $partidaId = null): int
    {
        $points  = 0; // base
        $recintoNombre = trim($recintoParam);   // ej: "Valle Norte"
        $fichaNombre   = trim($fichaParam);  
        $jugadorNombre   = trim($jugadorParam);     // ej: "T-Rex"


        $recinto = Recinto::where('nombre_recinto', $recintoNombre)->firstOrFail();
        $ficha   = Ficha::where('nombre', $fichaNombre)->firstOrFail();
        $jugador   = Jugador::where('nombre', $jugadorNombre)->firstOrFail();
        if (!$recinto || !$ficha) return $points;

        

       $qBase = Jugada::query()
            ->where('jugador_id', $jugador->id)
            ->where('recinto_id', $recinto->id)
            ->whereNull('partida_id');
        if ($partidaId) $qBase->where('partida_id', $partidaId);
      
        $countEnRecinto = (clone $qBase)->count();
        $countMismoTipo = (clone $qBase)->where('ficha_id', $ficha->id)->count();

        switch ($recinto->nombre_recinto) {
            case 'circuito_uniforme':
                if($countMismoTipo ==1) {
                   $points += 2;
                }
                else if($countMismoTipo ==2) {
                    $points += 2;
                }
                else if($countMismoTipo ==3) {
                    $points += 4;
                }
                else if($countMismoTipo ==4) {
                    $points += 4;
                }
                else if($countMismoTipo ==5) {
                    $points += 6;
                }
                else if($countMismoTipo >=6) {
                    $points += 6;
                }
                break;

            case 'pixeles_variados': {                            
                $totalFichas = (clone $qBase)->count();                                              
                $points += $totalFichas;                
                break;               
            }

            case 'cuartel_multijugador': {
                
                $desp  = intdiv($countEnRecinto , 2);
                if($desp==0) {
                    $points +=0;
                }
                else if($desp==1){
                    $points +=5;
                }
                else if($desp==2){
                    $points +=5;
                }
                else if($desp==3){
                    $points +=5;
                }
                else if($desp>=4){
                    $points +=5;
                }
                else if($desp>=4){
                    $points +=5;
                }
                break;
            }

            case 'triple_a':
                  $desp  = intdiv($countEnRecinto , 3);
                  if($desp==1) {
                    $points +=7;
                }
                else if($desp==2){
                    $points +=7;
                }
                break;

            case 'consola_del_año':
                $points += 7;
                break;

            case 'edicion_limitada': {
                $points += 7;
                break;
            }

            case 'taller':
                $points += 1;
                break;
        }

        return (int) $points;
    }

   

   
}
