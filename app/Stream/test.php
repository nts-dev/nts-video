<?php


$string1 = "2.2 Open learning login ";

$string2 = "2.2.3        Open learning login ";

$string3 = "2.2.3.4 Open learning  ";


list($headline_id, $headline_title) = getHeadlineInformation($string3);

echo $headline_id. "<br>";
echo $headline_title;



function getHeadlineInformation($string)
{
    $position = 0;
    $chapter_id = "";
    while (isValid(substr($string, $position, 1)))
        $chapter_id .= substr($string, $position++, 1);

    return array($chapter_id, substr($string, $position));

}



function isValid($string)
{
    return is_numeric($string) || ctype_punct($string);
}

