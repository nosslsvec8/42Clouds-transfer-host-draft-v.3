<?

// next, find the attribyte 'src="'
function findAtrrSrc($string) {
    $position2 = stripos($string, 'src="');
    $string = substr($string, $position2+5);
    return $string;
}

// find the tag 'url("'
function findUrl($string) {
    $position2 = stripos($string, 'url(');
    $string = substr($string, $position2+4);
    if($position2 === FALSE){ $string = ''; }
    return $string;
}
 
function isCheckRepeat(Array $arr, $string) {
    foreach ($arr as $key => $value) {
        if($string == $value){
            return $key;
        }
    }
    return 0;
}

function findSpecificWord($string, $specificWord){
    $position = stripos($string, $specificWord);
    $string = substr($string, $position);
    if($position === FALSE){ $string = ''; }
    return $string;
}

function allMatchesImgArr($copy, Array $allResultsImgArr){
    while ($copy !== ''){
        $copy = findSpecificWord($copy, "<img");
        $copy = findAtrrSrc($copy);
        $position3 = stripos($copy, '"');
        if ($position3 !== false) {
            $index = count($allResultsImgArr);
            $allResultsImgArr[$index] = mb_strimwidth($copy, 0, $position3, "");
        }
        $copy = substr($copy, $position3);
    }
    return $allResultsImgArr;
}

function allMatchesBgArr($copy2, Array $allResultsBgArr){
    while ($copy2 !== ''){
        $copy2 = findUrl($copy2);
        $position3 = stripos($copy2, ')');
        if ($position3 !== false) {
            $index = count($allResultsBgArr);
            $allResultsBgArr[$index] = mb_strimwidth($copy2, 0, $position3, "");
        }
        $copy2 = substr($copy2, $position3);
    }
    return $allResultsBgArr;
}

function removeRepetitionArr(Array $allResultsArr, Array $noRepetitionArr){
    for($i = 0; $i < count($allResultsArr); $i++) {
        $index = isCheckRepeat($noRepetitionArr, $allResultsArr[$i]);
        if( $index ){} else{
            if($allResultsArr[$i] !== "") {
                $noRepetitionArr[count($noRepetitionArr)] = $allResultsArr[$i];
            }
        }
    }
    return $noRepetitionArr;
}

function fillProcessed($val, $newVal){
    $devName = "https://ext-dev.42clouds.com";
    $prodName = "https://42clouds.com";

    $newVal = $val;
    $newVal = str_replace($devName, "", $newVal);
    $newVal = str_replace($prodName, "", $newVal);

    return $newVal;
}

function main($string, $button){
    $html = $string;
    $copy = $html;
    $copy2 = $html;

    $allResultsImgArr[] = "";
    $resultsImgArr[] = "";
    $processedImgArr[] = "";

    $allResultsBgArr[] = "";
    $resultsBgArr[] = "";
    $processedBgArr[] = "";

    // find img
    if( isset($copy) ){

        $allResultsImgArr = allMatchesImgArr($copy, $allResultsImgArr);
        $resultsImgArr = removeRepetitionArr($allResultsImgArr, $resultsImgArr);

        if($button == "prod"){
            for($i = 1; $i < count($resultsImgArr); $i++){
                $processedImgArr[$i] = fillProcessed($resultsImgArr[$i], $processedImgArr[$i]);
            }
        }

        for($i = 1; $i < count($processedImgArr); $i++){
            $html = str_replace($resultsImgArr[$i], $processedImgArr[$i], $html);
        }
    }

    // find bg
    if( isset($copy2) ){

        $allResultsBgArr = allMatchesBgArr($copy2, $allResultsBgArr);
        $resultsBgArr = removeRepetitionArr($allResultsBgArr, $resultsBgArr);

        if($button == "prod"){
            for($i = 1; $i < count($resultsBgArr); $i++){
                $processedBgArr[$i] = fillProcessed($resultsBgArr[$i], $processedBgArr[$i]);
            }
        }

        for($i = 1; $i < count($processedBgArr); $i++){
            $html = str_replace($resultsBgArr[$i], $processedBgArr[$i], $html);
        }
    }

    $html = str_replace('<link rel="stylesheet" href="css/bootstrap.min.css">', "", $html);
    $html = str_replace('<link rel="stylesheet" href="css/main.css">', "", $html);
    $html = str_replace('<script src="js/jquery.min.js"></script>', "", $html);
    $html = str_replace('<script src="js/bootstrap.min.js"></script>', "", $html);
    
    $html = str_replace('<link rel="stylesheet" href="https://ext-dev.42clouds.com/local/templates/42clouds_ru-ru/styles.css">', "", $html);
    $html = str_replace('<link rel="stylesheet" href="https://ext-dev.42clouds.com/local/templates/42clouds_ru-ru/css/cld-styles.css">', "", $html);
    $html = str_replace('<script src="https://ext-dev.42clouds.com/local/templates/42clouds_ru-ru/js/main.js"></script>', "", $html);

    $html = str_replace('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">', "", $html);
    $html = str_replace('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">', "", $html);
    $html = str_replace('<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>', "", $html);
    // $html = str_replace('<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>', "", $html);

    $html = trim($html);
    echo "$html";
}



if (isset($_POST['action'])) {
    echo main($_POST['action'], $_POST['button']);
    exit;
}

?>