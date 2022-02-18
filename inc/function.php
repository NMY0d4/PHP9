<?php


/// debug les tableaux

function debug(array $array) {
    echo '<pre style="width:50%; height:200px; overflow-y:scroll;
                    font-size:.7rem; padding:.6rem; margin:0 auto;
                    font-family: Consolas,Monospace;
                    background-color: #000; color: #fff;">';
    print_r($array);
    echo '</pre>';
}

/////////// Check un input

function check($errors, $string, $key, $min= 3, $max = 70){
    if (!empty($string)) {
        if (mb_strlen($string) < $min) {
            $errors[$key] = 'erreurs : '. $min .' caractères minimum';
        } elseif (mb_strlen($string) > $max) {
            $errors[$key] = 'erreurs : '. $max .' caractères maximum';       
        } 
    } else {
        $errors[$key] = 'erreurs : veuillez renseignez ce champ';
    }
    return $errors;
}

/////////////// Check email

function checkEmail($errors, $string, $key) {
    if (!empty($string)) {
        if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
            $errors[$key] = 'erreurs : rentrez un email valide';               
        } 
    } else {
        $errors[$key] = 'erreurs : veuillez renseignez ce champ';
    }
    return $errors;
}