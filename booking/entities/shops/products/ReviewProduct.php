<?php


namespace booking\entities\shops\products;


use booking\entities\admin\Legal;
use booking\entities\booking\BaseReview;

class ReviewProduct extends BaseReview
{

    public static function tableName(): string
    {
        return '{{%shops_product_reviews}}';
    }

    public function getLinks(): array
    {
        // TODO: Implement getLinks() method.
    }

    public function getType(): int
    {
        // TODO: Implement getType() method.
    }

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    public function getAdmin(): \booking\entities\admin\User
    {
        // TODO: Implement getAdmin() method.
    }

    public function getLegal(): Legal
    {
        // TODO: Implement getLegal() method.
    }
}