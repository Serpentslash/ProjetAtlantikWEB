<table border="1">
  <thead >
    <h1>Compagnie Atlantik      Tarifs en euros</h1>
    <?php 
      echo "<h3>Liaison ".$liaison['noliaison']." : ".$liaison['port_depart']." - ".$liaison['port_arrivee'];
    ?>
    <tr>
      <th>Catégorie</th>
      <th>Type</th>
      <th>Période</th>
      <th colspan="3">Tarif</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $last_categorie = '';
      $last_type = '';
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
</table>