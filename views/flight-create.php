<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Vlucht toevoegen</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="/flights/store">
                <div class="form-group">
                    <label for="airport">Bestemming</label>
                    <select name="airport" id="airport" class="form-control">
                        <?php foreach ($airports as $airport) : ?>
                            <option value="<?= $airport->luchthavencode ?>"><?= $airport->naam ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gate">Gate</label>
                    <select name="gate" id="gate" class="form-control">
                        <?php foreach ($gates as $gate) : ?>
                            <option value="<?= $gate->gatecode ?>"><?= $gate->gatecode ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="company">Maatschappij</label>
                    <select name="company" id="company" class="form-control">
                        <?php foreach ($companies as $company) : ?>
                            <option value="<?= $company->maatschappijcode ?>"><?= $company->naam ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="departure">Vertrektijd</label>
                    <input type="datetime-local" name="departure" id="departure" class="form-control">
                </div>
                <div class="form-group">
                    <label for="max-amount">Maximaal aantal passagiers</label>
                    <input type="number" name="max_amount" id="max-amount" class="form-control">
                </div>
                <div class="form-group">
                    <label for="max-weight-pp">Maximaal gewicht per passagier</label>
                    <input type="number" name="max_weight_pp" id="max-weight-pp" class="form-control">
                </div>
                <div class="form-group">
                    <label for="max-weight-total">Maximaal totaalgewicht</label>
                    <input type="number" name="max_weight_total" id="max-weight-total" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Toevoegen</button>
            </form>
        </div>
    </div>
</div>