<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-between">
                <h3 class="card-title">Passagiers</h3>
                <a href="/passengers/create" class="btn btn-primary">Toevoegen</a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="/passengers">
                <?php if (App\Helpers\Auth::user()->isEmployee()) : ?>
                    <div class="form-group">
                        <label for="number">Passagiernummer</label>
                        <input type="number" name="number" id="number" class="form-control" value="<?= $searchForNumber ?? '' ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Zoeken</button>
                <?php endif ?>
            </form>
            <table>
                <thead>
                    <td>Passagiernummer</td>
                    <td>Naam</td>
                    <td>vluchtnummer</td>
                    <td>Geslacht</td>
                    <td>Balienummer</td>
                    <td>Stoel</td>
                    <td>Inchecktijdstip</td>
                    <?php if (App\Helpers\Auth::user()->isEmployee()) : ?>
                        <td>Acties</td>
                    <?php endif ?>
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
                                <?php if (App\Helpers\Auth::user()->isEmployee()) : ?>
                                    <td>
                                        <a href="/passengers/<?= $passenger->passagiernummer ?>/edit" class="btn btn-primary">Bewerken</a>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
            <?= $paginator->render(); ?>
        </div>
    </div>
</div>