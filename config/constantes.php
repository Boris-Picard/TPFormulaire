<?php 
    $minDate = (date('Y') - 100)."-01-01";
    $maxDate = date('Y-m-d');
    
    define('COUNTRY_ARRAY', [
            'France', 
            'Belgique', 
            'Suisse', 
            'Luxembourg', 
            'Allemagne', 
            'Italie', 
            'Espagne', 
            'Portugal'
]);
    define('CHECKBOX_ARRAY', [
        'HTML/CSS', 
        'PHP', 
        'Javascript', 
        'Python', 
        'Others']);
    
    define('IMAGE_TYPES',  ['image/jpeg', 'image/png']);
    define('IMAGE_SIZE', 2*1024*1024);
?>