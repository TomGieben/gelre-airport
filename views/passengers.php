<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-between">
                <h3 class="card-title">Passagiers</h3>
                <a href="/passengers/create" class="btn btn-primary">Toevoegen</a>
            </div>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <td>Passagiernummer</td>
                    <td>Naam</td>
                    <td>vluchtnummer</td>
                    <td>Geslacht</td>
                    <td>Balienummer</td>
                    <td>Stoel</td>
                    <td>Inchecktijdstip</td>
                </thead>
                <tbody>
                    <?php if (empty($passengers)) : ?>
                        <tr>
                            <td colspan="3">Geen passagiers gevonden</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($passengers as $passenger) : ?>
                            <tr>
                                <td><?= $passenger->passagiernummer ?></td>
                                <td><?= $passenger->naam ?></td>
                                <td><?= $passenger->vluchtnummer ?></td>
                                <td><?= $passenger->geslacht ?></td>
                                <td><?= $passenger->balienummer ?></td>
                                <td><?= $passenger->stoel ?></td>
                                <td><?= $passenger->inchecktijdstip ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
            <?= $paginator->render(); ?>
        </div>
    </div>
</div>