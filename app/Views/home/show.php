<div class="card">
 <h2><?= htmlspecialchars($produit->getProductName()) ?></h2>
 
 <div style="margin: 1.5rem 0;">
  <p style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">
   <?= number_format($produit->getProductPrice(), 2, ',', ' ') ?> €
  </p>
 </div>

 <div style="margin: 1.5rem 0;">
  <h3>Informations du produit</h3>
  <table>
   <tr>
    <th>ID</th>
    <td><?= htmlspecialchars((string)$produit->getProductId()) ?></td>
   </tr>
   <tr>
    <th>Nom</th>
    <td><?= htmlspecialchars($produit->getProductName()) ?></td>
   </tr>
   <tr>
    <th>Prix</th>
    <td><?= number_format($produit->getProductPrice(), 2, ',', ' ') ?> €</td>
   </tr>
   <?php if ($produit instanceof \Mini\Models\ProduitAlimentaireItem): ?>
    <tr>
     <th>Type</th>
     <td>Produit Alimentaire</td>
    </tr>
    <tr>
     <th>Date d'expiration</th>
     <td><?= htmlspecialchars($produit->displayExpiratonDate()) ?></td>
    </tr>
   <?php else: ?>
    <tr>
     <th>Type</th>
     <td>Produit Standard</td>
    </tr>
   <?php endif; ?>
  </table>
 </div>

 <div style="margin: 1.5rem 0; padding: 1rem; background: #f3f4f6; border-radius: 8px;">
  <h3>Ajouter au panier</h3>
  <form method="post" action="/panier/add">
   <input type="hidden" name="id" value="<?= $produit->getProductId() ?>">
   <div>
    <label for="qty">Quantité</label>
    <input type="number" id="qty" name="qty" min="1" value="1" style="max-width: 100px;">
   </div>
   <button class="btn btn-primary" type="submit" style="margin-top: 0.5rem;">
    Ajouter au panier
   </button>
  </form>
 </div>

 <div style="margin-top: 1.5rem;">
  <a class="btn btn-secondary" href="/">← Retour au catalogue</a>
 </div>
</div>
