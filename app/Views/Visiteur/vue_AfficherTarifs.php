<table border="1">
  <thead >
    <h1>Compagnie Atlantik      Tarifs en euros</h1>
    <?php 
      echo "<h3>Liaison ".$liaison['noliaison']." : ".$liaison['port_depart']." - ".$liaison['port_arrivee'];

      $periodes = array();
      foreach ($tarifs as $tarif){
        $datedebut = $tarif['datedebut'];
        $datefin = $tarif['datefin'];

        $periodeCourante = array(
          'datedebut' => $datedebut,
          'datefin' => $datefin
        );

        if (!in_array($periodeCourante, $periodes)) {
            $periodes[] = $periodeCourante;
        }
      }
      $nbrPeriode = count($periodes)
    ?>
    <tr>
      <th rowspan="2">Catégorie</th>
      <th rowspan="2">Type</th>
      <?php echo "<th colspan=\"$nbrPeriode\">Période</th>"?>
    </tr>
    <?php 
      echo "<tr>";
      foreach($periodes as $periode){
         echo "<th>".$periode['datedebut']."</br>".$periode['datefin']."</th>";
      }
      echo "</tr>";
    ?>
  </thead>
  <tbody>
    <?php
      $last_categorie = '';
      $last_type = '';
      $nbrTarif = 0;

      foreach ($tarifs as $tarif) {
          $lettrecategorie = $tarif['lettrecategorie'];
          $libelle_categorie = $tarif['libelle_categorie'];
          $type = $tarif['type'];
          $datedebut = $tarif['datedebut'];
          $datefin = $tarif['datefin'];
          $tarif = $tarif['tarif'];
          
          if ($last_categorie != $lettrecategorie) {
            echo "<tr>";
            $compteur = 0;
            foreach ($tarifs as $compteurTarif) {
              if($compteurTarif['lettrecategorie'] == $lettrecategorie){
                $compteur += 1;
              }
            }
            $compteur = $compteur/$nbrPeriode;
            echo "<td rowspan=\"$compteur\">$lettrecategorie</td>";
            $last_categorie = $lettrecategorie;
          }
          if ($last_type != $type) {
            echo "<td>$type</td>";
            $last_type = $type;
          }
          echo "<td>".$tarif."</td>";
          $nbrTarif = $nbrTarif + 1;
          if($nbrTarif == $nbrPeriode){
            echo "</tr>";
            $nbrTarif = 0;
          }
      }
      ?>
  </tbody>
</table>