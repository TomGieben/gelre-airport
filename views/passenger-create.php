<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Passagier toevoegen</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="/passengers/store">
                <div class="form-group">
                    <label for="name">Naam</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="flightnumber">Vluchtnummer</label>
                    <select name="flightnumber" id="flightnumber" class="form-control">
                        <?php foreach ($flights as $flight) : ?>
                            <option value="<?= $flight->vluchtnummer ?>"><?= $flight->vluchtnummer ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gender">Geslacht</label>
                    <select name="gender" id="gender" class="form-control">
                        <?php foreach ($genders as $gender) : ?>
                            <option value="<?= $gender ?>"><?= $gender ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="counter">Balienummer</label>
                    <select name="counter" id="counter" class="form-control">
                        <?php foreach ($counters as $counter) : ?>
                            <option value="<?= $counter->balienummer ?>"><?= $counter->balienummer ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="seat">Stoel</label>
                    <input type="text" name="seat" id="seat" class="form-control">
                </div>
                <div class="form-group">
                    <label for="checkin">Inchecktijdstip</label>
                    <input type="datetime-local" name="checkin" id="checkin" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Wachtwoord</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password_confirm">Wachtwoord bevestigen</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                </div>
                <button type="submit" class="btn btn-secondary">Toevoegen</button>
            </form>
        </div>
    </div>
</div>