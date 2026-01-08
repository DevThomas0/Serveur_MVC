<div class="hero">
 <h2>Mes commandes</h2>
 <p>Historique simple stocké côté session.</p>
</div>

<?php if (empty($orders)): ?>
 <p>Aucune commande pour le moment.</p>
<?php else: ?>
 <?php foreach ($orders as $order): ?>
  <div class="card" style="margin-bottom:1rem;">
   <div class="flex-between">
    <h3>Commande #<?= htmlspecialchars((string) $order['id']) ?></h3>
    <span><?= htmlspecialchars($order['date']) ?></span>
   </div>
   <table>
    <thead>
     <tr>
      <th>Produit</th>
      <th>Qté</th>
      <th>Total</th>
     </tr>
    </thead>
    <tbody>
     <?php foreach ($order['lignes'] as $ligne): ?>
      <tr>
       <td><?= htmlspecialchars($ligne['nom']) ?></td>
       <td><?= $ligne['qty'] ?></td>
       <td><?= number_format($ligne['total'], 2, ',', ' ') ?> €</td>
      </tr>
     <?php endforeach; ?>
    </tbody>
   </table>
   <p style="text-align:right; font-weight:700;">Total : <?= number_format($order['total'], 2, ',', ' ') ?> €</p>
  </div>
 <?php endforeach; ?>
<?php endif; ?>
