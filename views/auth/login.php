<div class="container container-sm">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Login</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="/login">
                <div class="form-group">
                    <label for="number">Nummer</label>
                    <input type="number" class="form-control" id="number" name="number" required>
                </div>
                <div class="form-group">
                    <label for="password">Wachtwoord</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-secondary">Login</button>
                <a href="/register" class="btn btn-link">Registreer</a>
            </form>
        </div>
    </div>
</div>