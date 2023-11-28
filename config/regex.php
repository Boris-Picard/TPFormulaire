<?php
    define('LAST_NAME', '^[A-Za-zéèçà \-]{2,50}$');
    define('POSTAL_CODE', '^[0-9]{5}$');
    define('URL_REGEX','^(http(s)?:\/\/)?([\w]+\.)?linkedin\.com\/(pub|in|profile)');
    define('DATE_REGEX', '^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$');
    define('PASSWORD_REGEX', '(?=.*[A-Z])(?=.*[0-9]).{8,}');
?>