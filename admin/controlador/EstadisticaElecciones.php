<?php 
class Elecciones{
    
    function TieneRZ($dato){
        if($dato){
            return 'Tiene CZ <br> <i class="far fa-check-square fa-2x ml-2"></i>';
        }else{
            return 'Falta CZ <br> <i class="far fa-square fa-2x ml-2"></i>';
        }
    }

    function TituloBarra($totales, $existentes, $tipo){
        return
        '<b>' . $existentes . '</b> de <b>' . $totales . '</b> ' . $tipo;
    }

    function BarraProgreso($totales, $existentes, $color){
        $porcentaje = ($existentes/$totales) * 100 . '%';
        return 
            '<div class="progress">' . 
            '<div class="progress-bar ' . $color . '" role="progressbar" style="width:' . $porcentaje . ';" aria-valuemin="0" aria-valuemax="100">' . round($porcentaje) . '%</div>' .
            '</div>';
    }
    
    function Cifras($totales, $zona){
        $total = 0;
        $ocupados = 0;
        foreach($totales as $n){
            if($n['zona'] == $zona){
                $total++;
                if($n['id_ciudadano'] != null){
                    $ocupados++;
                }
            }
        }
        return $result =array(
            'total' => $total,
            'ocupados' => $ocupados
        );
    }
}

?>