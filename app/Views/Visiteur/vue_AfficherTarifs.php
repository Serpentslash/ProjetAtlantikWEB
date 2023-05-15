<table border="1">
  <thead >
    <tr>
      <th>Catégorie</th>
      <th>Type</th>
      <th>Période</th>
      <th>Tarif</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($tarifs as $tarif): ?>
        <tr>
        <td rowspan="<?php echo count($tarif['types']); ?>"><?php echo $tarif['nom']; ?></td>
        <?php foreach($tarif['types'] as $index => $type): ?>
        <?php if($index > 0): ?>
        </tr><tr>
        <?php endif; ?>
        <td><?php echo $type['nom']; ?></td>
        <td rowspan="<?php echo count($type['periodes']); ?>"><?php echo $type['nom']; ?></td>
        <?php foreach($type['periodes'] as $periode): ?>
        <td><?php echo $periode['tarif']; ?></td>
        </tr><tr>
        <?php endforeach; ?>
        <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
  </tbody>
</table>