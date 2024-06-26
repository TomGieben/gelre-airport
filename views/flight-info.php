<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mijn vlucht info</h3>
        </div>
        <div class="card-body">
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
            <table>
                <thead>
                    <td>Incheckbalie</td>
                    <td>Bagagebalie</td>
                    <td>Vluchtbalie</td>
                </thead>
                <tbody>
                    <?php if (!empty($checkin)) : ?>
                        <?php foreach ($checkin as $row) : ?>
                            <tr>
                                <td><?= $row->incheckcounter ?></td>
                                <td><?= $row->bagagecounter ?></td>
                                <td><?= $row->flightcounter ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3">Geen gegevens gevonden.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>