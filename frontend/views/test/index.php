<?php


/* @var $this \yii\web\View */

use InstagramScraper\Model\Account;

/* @var $account Account */
/*
if ($account) {
    echo "Account info:\n";
    echo "Id: {$account->getId()}\n";
    echo "Username: {$account->getUsername()}\n";
    echo "Full name: {$account->getFullName()}\n";
    echo "Biography: {$account->getBiography()}\n";
    echo "Profile picture url: {$account->getProfilePicUrl()}\n";
    echo "External link: {$account->getExternalUrl()}\n";
    echo "Number of published posts: {$account->getMediaCount()}\n";
    echo "Number of followers: {$account->getFollowsCount()}\n";
    echo "Number of follows: {$account->getFollowedByCount()}\n";
    echo "Is private: {$account->isPrivate()}\n";
    echo "Is verified: {$account->isVerified()}\n";
} else {
    echo '-----';
}


*/

    $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $_SERVER['REMOTE_ADDR'] . '?lang=ru'));
    $region = $query['region'] == 'KGD' ? 'MOW' : 'KGD';
?>

<script src="//tp.media/content?currency=rub&promo_id=4041&shmarker=iddqd&campaign_id=100&trs=133807&searchUrl=www.aviasales.ru%2Fsearch&locale=ru&powered_by=true&one_way=false&only_direct=true&period=year&range=7%2C14&primary=%230C73FE&color_background=%23FFFFFF&achieve=%2345AD35&dark=%23000000&light=%23fffff&destination=<?= $region ?>" charset="utf-8"></script>
