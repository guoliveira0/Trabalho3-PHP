<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h2>Resultado</h2>
    </header>
    <main>
        <?php
        //require_once '../class/autoloader.class.php';
        require_once 'class/r.class.php';

        R::setup(
            'mysql:host=127.0.0.1;dbname=fintech',
            'root',
            ''
        );
        $s = R::dispense('simulation');
        $s->client = $_GET['client'];
        $s->initialcontribution = $_GET['initialContribution'];
        $s->contribution = $_GET['contribution'];
        $s->period = $_GET['period'];
        $s->income = $_GET['income'];
        $id = R::store($s);
        echo "<p>ID da simulação: $id</p>";
        echo "<p>Cliente: {$_GET['client']}</p>";
        echo "<p>Aporte inicial: {$_GET['initialContribution']}</p>";
        echo "<p>Aporte mensal: {$_GET['contribution']}</p>";
        echo "<p>Rendimento: {$_GET['income']}</p>";
        echo "<p>Período: {$_GET['period']}</p>";





        ?>
        <table>
            <?php
            error_reporting(0);
            $initialContribution = floatval($_GET['initialContribution']);
            $period = (int)$_GET['period'];
            $income = floatval($_GET['income']);
            $contribution = floatval($_GET['contribution']);
            function calc($initialContribution, $income, $contribution)
            {
                $results = array(
                    'income' => '',
                    'total' => ''
                );
                $results['income'] = ($initialContribution + $contribution) * ($income / 100);
                $results['total'] = ($initialContribution + $results['income'] + $contribution);
                return $results;
            }


            if (isset($_GET['initialContribution'])) {
                echo ("<tr>
                <th>Mês</th>
                <th>Valor Inicial(R$)</th>
                <th>Aporte(R$)</th>
                <th>Rendimento(R$)</th>
                <th>Total(R$</th>
                </tr>");
            }
            for ($x = 1; $x < $period + 1; $x++) {

                echo ("<tr>");
                echo ("<td>$x</td>");
                if ($x == 1) {
                    echo ("<td>$initialContribution</td>");
                    $result = calc($initialContribution, $income, 0);
                    $finalincome = round($result['income'], 2);
                    $total = round($result['total'], 2);
                    echo ("<td>----</td>");
                    echo ("<td>$finalincome</td>");
                    echo ("<td>$total</td>");
                } else {
                    echo ("<td>$total</td>");
                    $result = calc($total, $income, $contribution);
                    $finalincome = round($result['income'], 2);
                    $total = round($result['total'], 2);
                    echo ("<td>$contribution</td>");
                    echo ("<td>$finalincome</td>");
                    echo ("<td>$total</td>");
                }
                echo ("</tr>");
            }
            ?>
        </table>
        <a href="index.html">Página Principal</a>
    </main>
    <footer>
        <p>Luiz&Fernanda&copy;-2023</p>
    </footer>
</body>

</html>