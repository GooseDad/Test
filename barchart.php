<?php

function RenderBarChart($data, $width_pixels) {
    $party_order = ["con", "lib", "ndp", "grn", "bq", "oth"];
    $party_names = [
        "con" => "Conservative",
        "lib" => "Liberal",
        "ndp" => "NDP",
        "grn" => "Green",
        "bq" => "Bloc Qu&eacute;becois",
        "oth" => "Independent",
    ];
    $max_value = max($data);
    foreach ($party_order as $party) {
        if (array_key_exists($party, $data)) {
            $value = $data[$party];
        } else {
            $value = 0;
        }
        $party_name = $party_names[$party];
        $bar_length = $value / $max_value * $width_pixels;
        echo ("<div class=\"riding $party\"><span class=\"ridingname\">" .
              "$party_name</span>" .
              "<span class=\"sequence\">" .
              "<span class=\"projection barchart $party-proj\" " .
              "style=\"width: $bar_length\">&nbsp;</span>" .
              "<span class=\"estimate $party\">" .
              "$value</span></span></div>\n");
    }
}

function SqlBarChart($sql, $width_pixels) {
    $result = query($sql);
    $data = [];
    while ($row = mysql_fetch_row($result)) {
        $key = strtolower($row[0]);
        $value = $row[1];
        $data[$key] = $value;
    }
    mysql_free_result($result);
    RenderBarChart($data, $width_pixels);
}

?>
