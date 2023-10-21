<?php
function dataIsRight($userError, $nameError, $surnamesError, $DNIError, $directionError, $emailError, $phoneError, $birthDateError): bool
{
    if (!isset($userError) && !isset($nameError) && !isset($surnamesError) && !isset($DNIError) && !isset($directionError) && !isset($emailError) && !isset($phoneError) && !isset($birthDateError))
        return true;
    else
        return false;
}


function getFirstWord(string $words)
{
    for ($i = 0; $i < strlen($words); $i++) {
        if ($words[$i] === ' ') {
            return substr($words, 0, $i);
        }
    }
}
