<?php
/* @var $array array */
$script = <<<JS
$(document).ready(function() {
    var i = 0;
    var arr_reviews = $array;
    var count = arr_reviews.length;
    var tick = false;
    $('#review-load').html(arr_reviews[i]);
    $('#review-load-next').hide();
    setInterval(function(){
            i++;
            if (i === count) {i=0;}
            if (tick === false) {
                $('#review-load-next').html(arr_reviews[i]);
                $('#review-load').slideUp(500);
                $('#review-load-next').slideDown(500);               
                tick = true;
                $('#rl').html(arr_reviews[i]);
            } else {
                $('#review-load').html(arr_reviews[i]);
                $('#review-load-next').slideUp(500); 
                $('#review-load').slideDown(500);                 
                tick = false
                }
        }, 5000);
});
JS;
$this->registerJs($script)
?>
    <div id="review-load"></div>
    <div id="review-load-next"></div>

