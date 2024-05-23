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
                <button type="submit" class="btn btn-secondary">Zoeken</button>
                <a href="/flights" class="btn btn-link">Reset</a>
            </form>
            <table>
                <thead>
                    <td>Vluchtnummer</td>
                    <td>Bestemming</td>
                    <td>Gatecode</td>
                    <td>Max aantal</td>
                    <td>Max gewicht pp</td>
                    <td>Max gewicht totaal</td>
                    <td>Vertrektijd</td>
                    <td>Maatschappijcode</td>
                </thead>
                <tbody>
                    <?php foreach ($flights as $flight) : ?>
                        <tr>
                            <td><?= $flight->vluchtnummer ?></td>
                            <td><?= $flight->bestemming ?></td>
                            <td><?= $flight->gatecode ?></td>
                            <td><?= $flight->max_aantal ?></td>
                            <td><?= $flight->max_gewicht_pp ?></td>
                            <td><?= $flight->max_totaalgewicht ?></td>
                            <td><?= $flight->vertrektijd ?></td>
                            <td><?= $flight->maatschappijcode ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>