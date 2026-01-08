<div class="hero">
    <h2>Votre panier</h2>
    <p>Vérifiez vos articles avant de passer commande.</p>
</div>

<?php $lines = $cart->detailedLines($catalogue); ?>

<?php if (empty($lines)): ?>
    <p>Aucun article pour le moment.</p>
    <p><a class="btn btn-primary" href="/">Retour au catalogue</a></p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Qté</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lines as $line): ?>
                <tr>
                    <td><?= htmlspecialchars($line['product']->getNom()) ?></td>
                    <td><?= $line['qty'] ?></td>
                    <td><?= number_format($line['total'], 2, ',', ' ') ?> €</td>
                    <td>
                        <form method="post" action="/panier/remove">
                            <input type="hidden" name="id" value="<?= $line['product']->getId() ?>">
                            <button class="btn btn-danger" type="submit">Retirer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p style="text-align:right; font-weight:700;">Total : <?= number_format($cart->total($catalogue), 2, ',', ' ') ?> €</p>

    <form method="post" action="/panier/checkout">
        <button class="btn btn-primary" type="submit">Valider la commande</button>
    </form>
<?php endif; ?>

