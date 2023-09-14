<?php
$hidden = isset($_POST['hidden']) ? $_POST['hidden'] : '';
$TextWithMapping = '';
$stringArray = array(
    "1"=>'%1$s - %2$s',
    "2"=>'%1$s changed the comment status',
    "3" => 'Managing site "%s"',
    "4"=>'"% d" comment moved to Spam.',
    "5" => '%1$s bytes (%2$s MB)',
    "6" => 'The quick brown %s fox jumps over the lazy dog in the middle of the night.(%2$s hits, %3$s misses)',
    "7"=> "No form definition found at %s.",
    "8" => 'Your version of %1$s is out of date. We recommend you upgrade to at least v%2$s, but preferably to the latest stable version.Plural category Zero',
    "9" => 'Translations don\'t match template. Run sync to update from "%s"',
    "10"=> 'Media error: "%s"'
);
    
$jsonString = json_encode($stringArray, JSON_UNESCAPED_UNICODE);

if(isset($_POST["merge_btn"])){
$mergedJson = formated_json($jsonString, $hidden);
}

function formated_json($jsonString,$hidden){
    $array1 = json_decode($jsonString, true);
    $array2 = json_decode($hidden, true);
    $result = [];
    $mapping = [
              '"% s"' => '"%s"',
              '"% d"' => '"%d"',
              '"% S"' => '"%s"',
              '"% D"' => '"%d"',
              '% s' => ' %s ',
              '% S'=> ' %s ',
              '% d'=> ' %d ',
              '% D'=> ' %d ',
              '٪ s' => ' %s ',
              '٪ S' => ' %s ',
              '٪ d' => ' %d ',
              '٪ D' => ' %d ',
              '٪ س' => ' %s ',
            ];
    $resultHtml = '<table class = "table">';
    $resultHtml .= '<tr><th scope="col">S. No.</th><th scope="col">String</th><th scope="col">Translated String</th></tr>';
    $i = 1;
    foreach ($array1 as $key => $value) {
        $hiddenValue = $array2[$key];
        $TextWithMapping = str_replace(array_keys($mapping), $mapping, $hiddenValue);
        $resultHtml .= "<tbody><tr><td>$key</td><td>$value</td><td>$TextWithMapping</td></tr></tbody>";
        $i++;
    }

    $resultHtml .= '</table>';
    return $resultHtml;
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaltor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>

<body>
    <div id="get_data_from_json"></div><br><br><br>
    <form method="post" name="myform">
        <label>Text:</label>
        <div class="row">
            <div class="col-6">
                <textarea class="form-control" id="txtArea" rows="3" cols="10"
                    name="text">You are a helpful assistant that translates English to Hindi and replies with well formed JSON arrays only in the code block. ["% s","% d","% S","% D",% s,% S,% d,% D,٪ س] These all are special placeholders please don't translate them.
                    Translate the following JSON array from english to a JSON array in hindi even if the values are the same:\n"<?php echo "$jsonString"?>
                </textarea>
            </div>
        </div>

        <button onclick="Copy()" class="btn btn-light" type="submit" class="copy" name="copy"><i style="font-size:24px"
                class="fa">&#xf0c5;</i></button>
    </form>

    <form method="post">
    <lable>Translation By Chat GPT in JSON form:</lable>
        <div class="row">
            <div class="col-12">
               
               <textarea name="hidden" rows="3" cols="112"></textarea>
               
            </div>
        </div>
        <input class="btn btn-light" type="submit" class="submit" value="merge" name="merge_btn">
    </form>
    <div>
        <?php
        if (isset($mergedJson)) {
            echo $mergedJson;
        }
        ?>
    </div>
</body>
<script>
    function Copy() {
        var copyText = document.getElementById("txtArea");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
    }
</script>

</html>