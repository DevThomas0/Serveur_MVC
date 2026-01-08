<div class="card">
    <h2>Inscription</h2>
    <?php if (!empty($error ?? '')): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post" action="/register">
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required value="<?= htmlspecialchars($old['email'] ?? '') ?>">
        </div>
        <div>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label for="confirm">Confirmer</label>
            <input type="password" name="confirm" id="confirm" required>
        </div>
        <button class="btn btn-primary" type="submit">Créer mon compte</button>
    </form>
    <p style="margin-top:0.5rem;">Déjà inscrit ? <a href="/login">Connectez-vous</a></p>
</div>

