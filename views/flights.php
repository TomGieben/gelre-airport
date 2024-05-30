<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Vluchten</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="/flights">
                <div class="form-group">
                    <label for="flightnumber">Vluchtnummer</label>
                    <input type="text" class="form-control" id="flightnumber" name="flightnumber" value="<?= isset($_GET['flightnumber']) ? $_GET['flightnumber'] : '' ?>">
                </div>
                <?php if ($isEmployee) : ?>
                    <div class="d-flex align-center">
                        <div class="form-group margin-end">
                            <label for="with-old">Weergeef oude vluchten</label>
                            <input type="checkbox" class="form-control" id="with-old" name="with_old" <?= isset($_GET['with_old']) ? 'checked' : '' ?>>
                        </div>
                        <div class="form-group margin-end">
                            <label for="sort-airport">Sorteer op luchthaven/bestemming</label>
                            <input type="checkbox" class="form-control" id="sort-airport" name="sort_airport" <?= isset($_GET['sort_airport']) ? 'checked' : '' ?>>
                        </div>
                        <div class="form-group">
                            <label for="sort-time">Sorteer op tijd</label>
                            <input type="checkbox" class="form-control" id="sort-time" name="sort_time" <?= isset($_GET['sort_time']) ? 'checked' : '' ?>>
                        </div>
                    </div>
                <?php endif ?>
                <div class="d-flex align-center justify-between">
                    <div>
                        <button type="submit" class="btn btn-secondary">Zoeken</button>
                        <a href="/flights" class="btn btn-link">Reset</a>
                    </div>
                    <?php if ($isEmployee) : ?>
                        <a href="/flights/create" class="btn btn-primary">Nieuwe vlucht</a>
                    <?php endif ?>
                </div>
            </form>
            <div class="flights-container">
                <?php foreach ($flights as $flight) : ?>
                    <div class="flight-card">
                        <div class="flight-content">
                            <h3>Vluchtnummer: <?= $flight->vluchtnummer ?></h3>
                            <p>Bestemming: <?= $flight->bestemming ?></p>
                            <p>Gatecode: <?= $flight->gatecode ?></p>
                            <p>Max aantal: <?= $flight->max_aantal ?></p>
                            <p>Max gewicht pp: <?= $flight->max_gewicht_pp ?></p>
                            <p>Max gewicht totaal: <?= $flight->max_totaalgewicht ?></p>
                            <p>Vertrektijd: <?= $flight->vertrektijd ?></p>
                            <p>Maatschappijcode: <?= $flight->maatschappijcode ?></p>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
            <?= $paginator->render(); ?>
        </div>
    </div>
</div>