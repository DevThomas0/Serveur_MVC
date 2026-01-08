<div class="hero">
    <h2>Bienvenue sur le mini catalogue POO</h2>
    <p>Ajoutez des produits, constituez un panier puis validez vos commandes.</p>
</div>

<?php if (isset($catalogue)): ?>
    <div class="flex-between" style="margin-bottom:0.5rem;">
        <h2>Produits disponibles</h2>
        <a class="btn btn-secondary" href="/add">+ Nouveau produit</a>
    </div>

    <div class="grid">
        <?php foreach ($catalogue->getProduits() as $produit): ?>
            <div class="card">
                <h3><?= htmlspecialchars($produit->getNom()) ?></h3>
                <p style="font-weight:700;"><?= number_format($produit->getPrix(), 2, ',', ' ') ?> €</p>
                <?php if ($produit instanceof \Mini\Models\ProduitAlimentaire): ?>
                    <p style="color:#6b7280;">Expiration : <?= $produit->afficherExpiration() ?></p>
                <?php endif; ?>
                <form method="post" action="/panier/add">
                    <input type="hidden" name="id" value="<?= $produit->getId() ?>">
                    <div>
                        <label for="qty-<?= $produit->getId() ?>">Quantité</label>
                        <input type="number" id="qty-<?= $produit->getId() ?>" name="qty" min="1" value="1">
                    </div>
                    <button class="btn btn-primary" type="submit">Ajouter au panier</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Catalogue introuvable.</p>
<?php endif; ?>

<p style="margin-top:1rem;"><a class="btn btn-secondary" href="/panier">Voir mon panier</a></p>
