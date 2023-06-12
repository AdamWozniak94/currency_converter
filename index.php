<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tabela i przelicznik walut</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>⚫️</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="fixed-top">
        <div class="position-absolute top-0 end-0">
            <a href="" class="btn btn-primary">Przelicznik walut</a>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <?php
                    require_once('Repository/CurrencyRepository.php');

                    $currencyRepository = new CurrencyRepository();

                    $rows = $currencyRepository->fetchAllRows();
                    ?>
                    <table class="table table-sm table-striped table-bordered table-hover" id="main-table">
                        <thead class="">
                        <tr class="table-primary">
                            <th>Nazwa waluty</th>
                            <th>Kod waluty</th>
                            <th>Kurs średni</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($rows as $row) {
                            echo "<tr>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['amount'] . ' ' . $row['code'] . "</td>";
                            echo "<td>" . $row['rate'] . "</td>";
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