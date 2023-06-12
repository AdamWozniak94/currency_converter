<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Przelicznik walut</title>
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>⚫️</text></svg>">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    </head>
    <body>
        <div class="fixed-top">
            <div class="position-absolute top-0 end-0">
                <a href="index.php" class="btn btn-primary">Tabela kursów walut</a>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="card">
                        <?php
                        require_once('Repository/CurrencyRepository.php');

                        $currencyRepository = new CurrencyRepository();

                        $currencyRows = $currencyRepository->fetchAllRows();
                        ?>
                        <h2>Kalkulator walutowy</h2>
                        <form action="ConvertCurrency.php" method="post" class="row g-3 ms-1 mb-3">
                            <div class="col-auto">
                                <label>
                                    Kwota
                                    <input type="number" name="amount" step="0.01" class="form-control">
                                </label>
                            </div>
                            <div class="col-auto">
                                <label>
                                    Waluta bazowa
                                    <select name="base_currency_code" class="form-select">
                                        <?php
                                        echo '<option selected value="PLN">PLN</option>';
                                        foreach ($currencyRows as $currencyRow) {
                                            echo '<option value="' . $currencyRow['code'] . '">' . $currencyRow['code'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </label>
                                <label>
                                    Waluta docelowa
                                    <select name="target_currency_code" class="form-select">
                                        <?php
                                        echo '<option value="PLN">PLN</option>';
                                        foreach ($currencyRows as $currencyRow) {
                                            if ('EUR' == $currencyRow['code']) {
                                                echo '<option selected value="' . $currencyRow['code'] . '">' . $currencyRow['code'] . '</option>';
                                            } else {
                                                echo '<option value="' . $currencyRow['code'] . '">' . $currencyRow['code'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </label>
                            </div>
                            <div class="col-auto">
                                <input type="submit" value="Przelicz" class="btn btn-primary mt-4">
                            </div>
                        </form>
                    </div>
                    <div class="card">
                        <?php
                        require_once('Repository/ConversionRepository.php');

                        $conversionRepository = new ConversionRepository();

                        $rows = $conversionRepository->fetchAllRows();
                        ?>
                        <h2>Historia przeliczeń</h2>
                        <table class="table table-sm table-striped table-bordered table-hover" id="main-table">
                            <thead class="">
                            <tr class="table-info">
                                <th>Kwota początkowa</th>
                                <th>Waluta początkowa</th>
                                <th>Waluta docelowa</th>
                                <th>Wynik</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($rows as $row) {
                                echo "<tr>";
                                echo "<td>" . $row['amount'] . "</td>";
                                echo "<td>" . $row['base_currency_code'] . "</td>";
                                echo "<td>" . $row['target_currency_code'] . "</td>";
                                echo "<td>" . $row['result'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
