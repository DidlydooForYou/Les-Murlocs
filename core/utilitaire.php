<?php 
    function multiplierCoins(int $prixOr, int $prixArgent, int $prixBronze, int $amount): array {
        $prixUnitaireBronze = ($prixOr * 100) + ($prixArgent * 10) + $prixBronze;
        $prixTotal = $prixUnitaireBronze * $amount;

        $prixBronzeFinal = $prixTotal % 10;             // Enlève les unités
        $prixArgentFinal = intdiv($prixTotal,10) % 10;  // Met les dizaines aux unités puis les enlèves
        $prixOrFinal = intdiv($prixTotal,100);          // Transfert le reste aux unités

        return [
            "Or" => $prixOrFinal,
            "Argent" => $prixArgentFinal,
            "Bronze" => $prixBronzeFinal,
            "SommeTotale" => $prixTotal
        ];
    }
?>