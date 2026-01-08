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
        <?php foreach ($catalogue->getAllProducts() as $produit): ?>
            <div class="card">
                <h3>
                    <a href="/produit/<?= $produit->getProductId() ?>" style="color: inherit; text-decoration: none;">
                        <?= htmlspecialchars($produit->getProductName()) ?>
                    </a>
                </h3>
                <p style="font-weight:700;"><?= number_format($produit->getProductPrice(), 2, ',', ' ') ?> €</p>
                <?php if ($produit instanceof \Mini\Models\ProduitAlimentaireItem): ?>
                    <p style="color:#6b7280;">Expiration : <?= $produit->displayExpiratonDate() ?></p>
                <?php endif; ?>
                <div style="margin-top: 0.75rem;">
                    <a href="/produit/<?= $produit->getProductId() ?>" class="btn btn-secondary" style="margin-bottom: 0.5rem;">
                        Voir les détails
                    </a>
                </div>
                <form method="post" action="/panier/add">
                    <input type="hidden" name="id" value="<?= $produit->getProductId() ?>">
                    <div>
                        <label for="qty-<?= $produit->getProductId() ?>">Quantité</label>
                        <input type="number" id="qty-<?= $produit->getProductId() ?>" name="qty" min="1" value="1">
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