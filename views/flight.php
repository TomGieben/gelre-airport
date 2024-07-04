<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Passagiers op vlucht <?= $flight ?></h3>
        </div>
        <div class="card-body">
            <?php if (empty($passengers)) : ?>
                <p>Geen passagiers gevonden</p>
            <?php else : ?>
                <table>
                    <thead>
                        <td>Passagiernummer</td>
                        <td>Naam</td>
                        <td>Geslacht</td>
                        <td>Balienummer</td>
                        <td>Stoel</td>
                    </thead>
                    <tbody>
                        <?php foreach ($passengers as $passenger) : ?>
                            <tr>
                                <td><?= $passenger->passagiernummer ?></td>
                                <td><?= $passenger->naam ?></td>
                                <td><?= $passenger->geslacht ?></td>
                                <td><?= $passenger->balienummer ?></td>
                                <td><?= $passenger->stoel ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </div>
</div>