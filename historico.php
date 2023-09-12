<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header><h2>Histórico</h2></header>
    <main>
        <form action="historico.php" method="get">
            <fieldset>
                <legend>Simulação a recuperar</legend>
                <label for="id">ID da simulação: </label>
                <input type="number" name="id" id="id">
                <input type="submit" value="Recuperar" name = "recuperar">
            </fieldset>
        </form>
        <?php
        error_reporting(0);
        require_once 'class/r.class.php';
        R::setup(
            'mysql:host=127.0.0.1;dbname=fintech',
             'root', '' );
        $s = R::load( 'simulation', $_GET['id'] );
        if(isset($_GET['recuperar'])){
        if (!$s->id){
            echo "ID não encontrada";
        }
        else{
            
            if(isset($s->initialcontribution)){
                echo "<p>Cliente: {$s->client}</p>";
                echo "<p>Aporte inicial: {$s->initialcontribution}</p>";
                echo "<p>Aporte mensal: {$s->contribution}</p>";
                echo "<p>Rendimento: {$s->income}</p>";
                echo "<p>Período: {$s->period}</p>";
            }
        }
    }
        ?>
        <table>
            <?php
             
            $initialContribution = floatval($s->initialcontribution);
            $period = (int)$s->period;
            $income = floatval($s->income);
            $contribution = floatval($s->contribution);
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


            if (isset($s->initialcontribution)) {
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

</body>
</html>