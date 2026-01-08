<h2>Ajouter un produit</h2>

<?php if (!empty($error ?? '')): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post" action="/add">

    <div>

        <label for="nom">Nom *</label>
        <input type="text" id="nom" name="nom" required value="<?= htmlspecialchars($old['nom'] ?? '') ?>">
    </div>

    <div>
        <label for="prix">Prix (€) *</label>
        <input type="number" step="0.01" min="0.01" id="prix" name="prix" required
            value="<?= htmlspecialchars((string) ($old['prix'] ?? '')) ?>">
    </div>
    <div>
        <label for="expiration">Date d'expiration (optionnel)</label>
        <input type="date" id="expiration" name="expiration" value="<?= htmlspecialchars($old['expiration'] ?? '') ?>">
    </div>

    <button type="submit">Ajouter</button>
</form>

<p><a href="/">Retour au catalogue</a></p>