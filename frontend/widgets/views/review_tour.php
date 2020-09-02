<?php
/* @var $array array */
$script = <<<JS
$(document).ready(function() {
    var i = 0;
    var arr_reviews = $array;
    var count = arr_reviews.length;
    $('#review-load').html(arr_reviews[0]);
    setInterval(function(){
            i++;
            if (i == count) {i=0;}
         $('#review-load').html(arr_reviews[i]);
        }, 4000);
});

JS;
$this->registerJs($script)
?>
<div id="review-load"></div>


