<h1>Liste des liaisons</h1>
    <table border="1">
        <thead>
            <tr>
                <th rowspan="2">Secteur</th>
                <th colspan="4">Liaison</th>
            </tr>
            <tr>
                <th>Code liaison</th>
                <th>Distance en milles marin</th>
                <th>Port de départ</th>
                <th>Port d'arrivée</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $last_secteur = '';
            foreach ($liaisons as $liaison) {
                $noliaison = $liaison['noliaison'];
                $secteur = $liaison['secteur'];
                $distance = $liaison['distance'];
                $port_depart = $liaison['port_depart'];
                $port_arrivee = $liaison['port_arrivee'];
                
                echo "<tr><td>";
                if ($last_secteur != $secteur) {
                    echo "$secteur";
                    $last_secteur = $secteur;
                }
                echo "</td><td><a href=".site_url('afficher_tarifs')."?noliaison=$noliaison>$noliaison</a></td>";
                echo "<td>$distance</td>";
                echo "<td>$port_depart</td>";
                echo "<td>$port_arrivee</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>site_url('accueil')