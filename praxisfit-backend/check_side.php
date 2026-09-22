<?php
$data = json_decode(file_get_contents('https://raw.githubusercontent.com/yuhonas/free-exercise-db/main/dist/exercises.json'), true);
foreach($data as $ex) {
    if ($ex['name'] === 'Side Bridge' || $ex['name'] === 'Side Jackknife') {
        echo $ex['name'] . "\n";
        print_r($ex['instructions']);
    }
}
