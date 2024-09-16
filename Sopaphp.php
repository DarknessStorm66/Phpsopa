<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sopa de Letras</title>
    <style>
        body {font-family: 'Comic Sans MS', cursive, sans-serif;}
        table {border-collapse: collapse;}
        td {width: 20px; height: 20px; text-align: center; border: 7px solid black;}
        .resaltado {background-color: #57F08E;}
        .no-encontrada {color: red;}
        .lista-palabras {margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Sopa de Letras</h1>
    <?php
    $sopa_de_letras = 
        [['V', 'S', 'D', 'H', 'N', 'V', 'L', 'H', 'E', 'L'],
        ['A', 'P', 'H', 'P', 'H', 'T', 'O', 'S', 'J', 'M'],
        ['H', 'P', 'H', 'H', 'E', 'O', 'L', 'A', 'A', 'T'],
        ['T', 'C', 'A', 'H', 'A', 'H', 'A', 'M', 'P', 'L'],
        ['H', 'A', 'C', 'C', 'E', 'A', 'C', 'S', 'T', 'P'],
        ['J', 'H', 'L', 'A', 'H', 'E', 'H', 'A', 'O', 'H'],
        ['T', 'A', 'A', 'P', 'H', 'E', 'H', 'E', 'P', 'A'],
        ['S', 'S', 'C', 'T', 'G', 'P', 'H', 'H', 'P', 'V'],
        ['H', 'E', 'S', 'A', 'A', 'P', 'H', 'A', 'C', 'A'],
        ['P', 'H', 'T', 'S', 'E', 'P', 'G', 'N', 'A', 'J']];
    $palabras = ['css', 'php', 'java', 'apache', 'html', 'mysql'];
    $palabra_a_buscar = isset($_GET['word']) ? strtolower(trim($_GET['word'])) : '';

    function resaltarPalabra($sopa, $palabra) {
        $filas = count($sopa);
        $columnas = count($sopa[0]);
        $resaltada = array_map(fn($fila) => array_map(fn($celda) => ['letra' => $celda, 'resaltado' => false], $fila), $sopa);
        $encontrada = false;
        $palabra_inversa = strrev($palabra);

        for ($i = 0; $i < $filas; $i++) {
            for ($j = 0; $j <= $columnas - strlen($palabra); $j++) {
                $coincide = true;
                for ($k = 0; $k < strlen($palabra); $k++) {
                    if (strtolower($sopa[$i][$j + $k]) !== $palabra[$k]) {
                        $coincide = false;
                        break;
                    }
                }
                if ($coincide) {
                    $encontrada = true;
                    for ($k = 0; $k < strlen($palabra); $k++) {
                        $resaltada[$i][$j + $k]['resaltado'] = true;
                    }
                }
                $coincide = true;
                for ($k = 0; $k < strlen($palabra); $k++) {
                    if (strtolower($sopa[$i][$j + $k]) !== $palabra_inversa[$k]) {
                        $coincide = false;
                        break;
                    }
                }
                if ($coincide) {
                    $encontrada = true;
                    for ($k = 0; $k < strlen($palabra); $k++) {
                        $resaltada[$i][$j + $k]['resaltado'] = true;
                    }
                }
            }
        }

        for ($i = 0; $i <= $filas - strlen($palabra); $i++) {
            for ($j = 0; $j < $columnas; $j++) {
                $coincide = true;
                for ($k = 0; $k < strlen($palabra); $k++) {
                    if (strtolower($sopa[$i + $k][$j]) !== $palabra[$k]) {
                        $coincide = false;
                        break;
                    }
                }
                if ($coincide) {
                    $encontrada = true;
                    for ($k = 0; $k < strlen($palabra); $k++) {
                        $resaltada[$i + $k][$j]['resaltado'] = true;
                    }
                }
                $coincide = true;
                for ($k = 0; $k < strlen($palabra); $k++) {
                    if (strtolower($sopa[$i + $k][$j]) !== $palabra_inversa[$k]) {
                        $coincide = false;
                        break;
                    }
                }
                if ($coincide) {
                    $encontrada = true;
                    for ($k = 0; $k < strlen($palabra); $k++) {
                        $resaltada[$i + $k][$j]['resaltado'] = true;
                    }
                }
            }
        }

        for ($i = 0; $i <= $filas - strlen($palabra); $i++) {
            for ($j = 0; $j <= $columnas - strlen($palabra); $j++) {
                $coincide = true;
                for ($k = 0; $k < strlen($palabra); $k++) {
                    if (strtolower($sopa[$i + $k][$j + $k]) !== $palabra[$k]) {
                        $coincide = false;
                        break;
                    }
                }
                if ($coincide) {
                    $encontrada = true;
                    for ($k = 0; $k < strlen($palabra); $k++) {
                        $resaltada[$i + $k][$j + $k]['resaltado'] = true;
                    }
                }
                $coincide = true;
                for ($k = 0; $k < strlen($palabra); $k++) {
                    if (strtolower($sopa[$i + $k][$j + $k]) !== $palabra_inversa[$k]) {
                        $coincide = false;
                        break;
                    }
                }
                if ($coincide) {
                    $encontrada = true;
                    for ($k = 0; $k < strlen($palabra); $k++) {
                        $resaltada[$i + $k][$j + $k]['resaltado'] = true;
                    }
                }
            }
        }

        return ['resaltada' => $resaltada, 'encontrada' => $encontrada];
    }

    if (in_array($palabra_a_buscar, $palabras) && !empty($palabra_a_buscar)) {
        $resultado = resaltarPalabra($sopa_de_letras, $palabra_a_buscar);
    } else {
        $resultado = ['resaltada' => array_map(fn($fila) => array_map(fn($celda) => ['letra' => $celda, 'resaltado' => false], $fila), $sopa_de_letras), 'encontrada' => false];
    }

    $sopa_resaltada = $resultado['resaltada'];
    $encontrada = $resultado['encontrada'];
    ?>
    <form method="GET" action="">
        <label for="word">Buscar palabra:</label>
        <input type="text" id="word" name="word" value="<?php echo ($palabra_a_buscar); ?>">
        <input type="submit" value="Buscar">
    </form>
    <?php if ($palabra_a_buscar && !in_array($palabra_a_buscar, $palabras)): ?>
        <p class="no-encontrada">La palabra "<?php echo ($palabra_a_buscar); ?>" no está en la lista de palabras.</p>
    <?php elseif ($palabra_a_buscar && !$encontrada): ?>
        <p class="no-encontrada">La palabra "<?php echo ($palabra_a_buscar); ?>" no está en la sopa de letras.</p>
    <?php endif; ?>
    <table>
        <?php foreach ($sopa_resaltada as $fila): ?>
            <tr>
                <?php foreach ($fila as $celda): ?>
                    <td class="<?php echo $celda['resaltado'] ? 'resaltado' : ''; ?>">
                        <?php echo ($celda['letra']); ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="lista-palabras">
        <h2>Palabras en la sopa:</h2>
        <ul>
            <?php foreach ($palabras as $palabra): ?>
                <li><?php echo ($palabra); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
