<?php
$player = User::getUser();
if($player) {
    $lang = $player->ID_LANGUAGE;
} else {
    $lang = 1;
}
// Define Output HTML Formating
$html = '';
$html .= '<li class="result">';
$html .= '<a href="urlString">';
$html .= '<h3>nameString</h3>';
$html .= '<h4>typeString</h4>';
$html .= '</a>';
$html .= '</li>';

// Check If We Have Results
if (isset($searchResults)) {
    $returnedOutput="";
        foreach ($searchResults as $result) {

                // Format Output Strings And Hightlight Matches
                $display_name = preg_replace("/".$phrase."/i", "<b>".$phrase."</b>", DooTextHelper::limitChar($result->Data, $stringLimit));
                $display_type = preg_replace("/".$phrase."/i", "<b>".$phrase."</b>", ucfirst($this->__($result->FieldType)));
                $display_url = $result->FieldType."/".$result->URL;

                // Insert Name
                $output = str_replace('nameString', $display_name, $html);

                // Insert Function
                $output = str_replace('typeString', $display_type, $output);

                // Insert URL
                $output = str_replace('urlString', MainHelper::site_url($display_url), $output);

                // Output
                $returnedOutput .= $output;
        }
    echo $returnedOutput;
}
else return false;

?>