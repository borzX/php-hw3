<?php


function validateData(string $date): bool {
    $dateBlocks = explode("-", $date);

    if(count($dateBlocks) < 3){
        return false;
    }

    if(isset($dateBlocks[0]) && $dateBlocks[0] > 31) {
        return false;
    }

    if(isset($dateBlocks[1]) && $dateBlocks[0] > 12) {
        return false;
    }

    if(isset($dateBlocks[2]) && $dateBlocks[2] > date('Y')) {
        return false;
    }

    return true;
};

function searchFunction(array $config): string {

    $address = $config['storage']['address'];

    echo "Ищем именинников на сегодня " . date("d.m") . "\r\n";

    $users = [];

    if (file_exists($address) && is_readable($address)) {
    
        $file = fopen($address, "rb");

        while (!feof($file)) {

            $user = fgets($file);

            $userData = explode(',', $user);
            if (isset($userData[1])){

                $dateData = explode('-', trim($userData[1])); 

                if($dateData[0] == date('d') && $dateData[1] == date('m')){
                    $users[] = $userData[0];
                }
            }
        }    
    }

    $contents = '';
    if (empty($users)){
        $contents = 'Именинников нет';

    }
    else {
        $contents = "Именинники: " . PHP_EOL;

        foreach ($users as $user){
            $contents = $user . "\r\n";
        }

    }
    fclose($file);

    return $contents;

}
