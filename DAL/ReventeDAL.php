<?php
class ReventeDAL
{

    public static function selectAll(PDO $connexion): array
    {
        $sql = "SELECT 
                r.idItem, r.idJoueur, r.nomItem, r.prixOr, r.prixArgent, r.prixBronze,
                r.photoItem, r.qttItem, r.type,
                j.alias AS vendeur_alias,
                j.photoProfil AS vendeur_photo
            FROM revente r
            LEFT JOIN evaluations e ON r.idItem = e.Item_idItem
            LEFT JOIN joueursjeu j ON r.idJoueur = j.idJoueur
            GROUP BY r.idItem, r.nomItem, r.photoItem, j.alias, j.photoProfil";

        $stmt = $connexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public static function ajouterRevente(PDO $connexion, $idJoueur, $idItem, $nomItem, $prixOr, $prixArgent, $prixBronze, $photoItem, $qttItem, $type, $photoProfil, $alias): bool
    {
        $sql = "INSERT INTO revente 
            (idItem, idJoueur, nomItem, prixOr, prixArgent, prixBronze, photoItem, qttItem, type, photoProfil, alias) 
            VALUES 
            (:idItem, :idJoueur, :nomItem, :prixOr, :prixArgent, :prixBronze, :photoItem, :qttItem, :type, :photoProfil, :alias)";

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue(':idItem', $idItem, PDO::PARAM_INT);
        $stmt->bindValue(':idJoueur', $idJoueur, PDO::PARAM_INT);
        $stmt->bindValue(':nomItem', $nomItem, PDO::PARAM_STR);
        $stmt->bindValue(':prixOr', $prixOr, PDO::PARAM_INT);
        $stmt->bindValue(':prixArgent', $prixArgent, PDO::PARAM_INT);
        $stmt->bindValue(':prixBronze', $prixBronze, PDO::PARAM_INT);
        $stmt->bindValue(':photoItem', $photoItem, PDO::PARAM_STR);
        $stmt->bindValue(':qttItem', $qttItem, PDO::PARAM_INT);
        $stmt->bindValue(':type', $type, PDO::PARAM_STR);
        $stmt->bindValue(':photoProfil', $photoProfil, PDO::PARAM_STR);
        $stmt->bindValue(':alias', $alias, PDO::PARAM_STR);

        return $stmt->execute();
    }


    public static function selectByPrice(PDO $connexion, string $sortWay)
    {
        $order = ($sortWay === "price_asc") ? "ASC" : "DESC";

        $sql = "SELECT 
                r.idItem, r.idJoueur, r.nomItem, r.prixOr, r.prixArgent, r.prixBronze,
                r.photoItem, r.qttItem, r.type,
                j.alias AS vendeur_alias,
                j.photoProfil AS vendeur_photo
            FROM revente r
            LEFT JOIN evaluations e ON r.idItem = e.Item_idItem
            LEFT JOIN joueursjeu j ON r.idJoueur = j.idJoueur
            GROUP BY r.idItem, r.nomItem, r.photoItem, j.alias, j.photoProfil
            ORDER BY r.prixOr $order, r.prixArgent $order, r.prixBronze $order";

        $stmt = $connexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public static function selectByAlphabete(PDO $connexion, string $alphab)
    {
        $order = ($alphab === "alpha_asc") ? "ASC" : "DESC";

        $sql = "SELECT 
                r.idItem, r.idJoueur, r.nomItem, r.prixOr, r.prixArgent, r.prixBronze,
                r.photoItem, r.qttItem, r.type,
                j.alias AS vendeur_alias,
                j.photoProfil AS vendeur_photo
            FROM revente r
            LEFT JOIN evaluations e ON r.idItem = e.Item_idItem
            LEFT JOIN joueursjeu j ON r.idJoueur = j.idJoueur
            GROUP BY r.idItem, r.nomItem, r.photoItem, j.alias, j.photoProfil
            ORDER BY r.nomItem $order";

        $stmt = $connexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public static function selectByCategory(PDO $connexion, string $type)
    {
        $map = [
            "armors" => "armure",
            "weapons" => "arme",
            "potions" => "potion",
            "sorts" => "sort"
        ];

        if (!isset($map[$type]))
            return [];

        $sql = "SELECT 
                r.idItem, r.idJoueur, r.nomItem, r.prixOr, r.prixArgent, r.prixBronze,
                r.photoItem, r.qttItem, r.type,
                j.alias AS vendeur_alias,
                j.photoProfil AS vendeur_photo
            FROM revente r
            LEFT JOIN evaluations e ON r.idItem = e.Item_idItem
            LEFT JOIN joueursjeu j ON r.idJoueur = j.idJoueur
            WHERE r.type = :type
            GROUP BY r.idItem, r.nomItem, r.photoItem, j.alias, j.photoProfil";

        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(':type', $map[$type], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll();
    }


    public static function selectByTitle(PDO $connexion, string $search): array
    {
        $sql = "SELECT 
                r.idItem, r.idJoueur, r.nomItem, r.prixOr, r.prixArgent, r.prixBronze,
                r.photoItem, r.qttItem, r.type,
                j.alias AS vendeur_alias,
                j.photoProfil AS vendeur_photo
            FROM revente r
            LEFT JOIN evaluations e ON r.idItem = e.Item_idItem
            LEFT JOIN joueursjeu j ON r.idJoueur = j.idJoueur
            WHERE r.nomItem LIKE :search
            GROUP BY r.idItem, r.nomItem, r.photoItem, j.alias, j.photoProfil";

        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function decrementQuantity(PDO $connexion, int $idItem): bool
    {
        $sql = "UPDATE revente 
            SET qttItem = qttItem - 1 
            WHERE idItem = :idItem AND qttItem > 0";

        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(':idItem', $idItem, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function deleteIfEmpty(PDO $connexion, int $idItem): bool
    {
        $sql = "DELETE FROM revente WHERE idItem = :idItem AND qttItem <= 0";

        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(':idItem', $idItem, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function selectByUser(PDO $connexion, int $idJoueur): array
    {
        $sql = "SELECT 
                r.idItem, r.idJoueur, r.nomItem, r.prixOr, r.prixArgent, r.prixBronze,
                r.photoItem, r.qttItem, r.type, r.qtRevente,
                j.alias AS vendeur_alias,
                j.photoProfil AS vendeur_photo
            FROM revente r
            LEFT JOIN evaluations e ON r.idItem = e.Item_idItem
            LEFT JOIN joueursjeu j ON r.idJoueur = j.idJoueur
            WHERE r.idJoueur LIKE :idJoueur
            GROUP BY r.idItem, r.nomItem, r.photoItem, j.alias, j.photoProfil";

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }

    public static function selectByUserAndItem($conn, $idJoueur, $idItem)
    {
        $sql = "SELECT * FROM revente WHERE idJoueur = ? AND idItem = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idJoueur, $idItem]);
        return $stmt->fetch();
    }

    public static function updateQuantite($conn, $idJoueur, $idItem, $qt)
    {
        $sql = "UPDATE revente SET qttItem = ? WHERE idJoueur = ? AND idItem = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$qt, $idJoueur, $idItem]);
    }


}
?>