<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registreer</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="/login">
                <div class="form-group">
                    <label for="email">Naam</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Wachtwoord</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-secondary">Registreer</button>
            </form>
        </div>
    </div>
</div>
