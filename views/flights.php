<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Vluchten</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="/flights">
                <div class="form-group">
                    <label for="flightnumber">Vluchtnummer</label>
                    <input type="text" class="form-control" id="flightnumber" name="flightnumber">
                </div>
                <button type="submit" class="btn btn-secondary">Zoeken</button>
                <button type="submit" name="reset" value="1" class="btn btn-link">Reset</button>
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