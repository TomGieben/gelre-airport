<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bagage</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="/luggage">
                <?php if (App\Helpers\Auth::user()->isEmployee() && !empty($passengers)) : ?>
                    <div class="form-group">
                        <label for="passenger">Passagier</label>
                        <select name="passenger" id="passenger" class="form-control">
                            <?php foreach ($passengers as $passenger) : ?>
                                <option value="<?= $passenger->passagiernummer ?>">
                                    <?= $passenger->passagiernummer ?> - <?= $passenger->naam ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                <?php endif ?>
                <div class="form-group">
                    <label for="weight">Gewicht</label>
                    <input type="number" name="weight" id="weight" class="form-control" step="0.01">
                </div>
                <button type="submit" class="btn btn-primary">Toevoegen</button>
            </form>
            <table>
                <thead>
                    <td>Passagiernummer</td>
                    <td>Objectvolgnummer</td>
                    <td>Gewicht</td>
                </thead>
                <tbody>
                    <?php if (empty($luggage)) : ?>
                        <tr>
                            <td colspan="3">Geen bagage gevonden</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($luggage as $object) : ?>
                            <tr>
                                <td><?= $object->passagiernummer ?></td>
                                <td><?= $object->objectvolgnummer ?></td>
                                <td><?= $object->gewicht ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>