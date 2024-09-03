<?php
/**
 * Copyright (c) 2019-2024. ReddingWebPro / Jason J. Olson, This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by the Free Software Foundation version 3
 * of the License.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License
 * for more details. You should have received a copy of the GNU General Public License along with this program.  If not,
 * see <https://www.gnu.org/licenses/>.
 */

/**
 * Created by ReddingWebPro/ReddingWebDev
 * User: Jason J. Olson
 * License: GNU GPLv3
 * Version 1.0
 * Date: 8/6/2023
 */

$defaultLabel = "PASTOR";    // Name of the label in mic board that you want to use by default
$micBoardAddress = "http://127.0.0.1:8058";  // Change to the address of MicBoard.io
$bg = $good = null;


$json = file_get_contents($micBoardAddress.'/data.json');
$obj = json_decode($json);
if ($_GET['name']) {
    $key = strip_tags(htmlspecialchars($_GET['name']));
} else {
    $key = $defaultLabel;
}

foreach ($obj->receivers as $data) {
    if ($data->tx[0]->name == $key) {
        if (($data->tx[0]->status) == "GOOD") {
            $good = true;
            $bg = "text-bg-success";
        } else {
            $good = false;
            $bg = "text-bg-danger";
        }
    }
}
?>

<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shure Microphone Status: <?= $key ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <meta http-equiv="refresh" content="1">
</head>
<body class="d-flex h-100 text-center <?= $bg ?>">


<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-auto">
        <div>
            <h3 class="float-md-start mb-0">MIC: <?= $key ?></h3>
        </div>
    </header>

    <main class="px-3">

        <?php
        if ($good) {
            echo "<h1>ALL GOOD</h1>";
        } else {
            echo "<h1>STOP ! ! ! !</h1><h3>YOUR MICROPHONE IS NOT TURNED ON</h3><h5>(This page updates every second)</h5>";
        }
        ?>
    </main>

    <footer class="mt-auto text-white-50">
        <p>&copy;2023 ReddingWebPro</p>
    </footer>
</div>
</body>
</html>
