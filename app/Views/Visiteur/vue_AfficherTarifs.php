<table border="1">
  <thead >
    <h1>Compagnie Atlantik      Tarifs en euros</h1>
    <?php 
      echo "<h3>Liaison ".$liaison['noliaison']." : ".$liaison['port_depart']." - ".$liaison['port_arrivee'];
    ?>
    <tr>
      <th>Catégorie</th>
      <th>Type</th>
      <th colspan="4">Période</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $last_categorie = '';
      $last_type = '';
      foreach ($tarifs as $tarif) {
          $lettrecategorie = $tarif['lettrecategorie'];
          $libelle_categorie = $tarif['libelle_categorie'];
          $type = $tarif['type'];
          $datedebut = $tarif['datedebut'];
          $datefin = $tarif['datefin'];
          $tarif = $tarif['tarif'];
          
          echo "<tr>";
          if ($last_categorie != $lettrecategorie) {
            $compteur = 0;
            foreach ($tarifs as $compteurTarif) {
              if($compteurTarif['lettrecategorie'] == $lettrecategorie && !($compteurTarif['type'] == $type)){
                $compteur += 1;
              }
            }
              echo "<td rowspan=\"$compteur\">$lettrecategorie $libelle_categorie</td>";
              $last_categorie = $lettrecategorie;
          }
          if ($last_type != $type) {
            echo "<td>$type</td>";
            $last_type = $type;
          }
          echo "<td>$tarif</td>";
          echo "<td>tarif</td>";
          echo "<td>tarif</td>";
          echo "</tr>";
      }
      ?>
  </tbody>
</table>