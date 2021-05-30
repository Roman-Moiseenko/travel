<?php


namespace booking\entities\office;


use yii\db\ActiveRecord;

/**
 * Class PriceList
 * @package booking\entities\office
 * @property integer $id
 * @property string $key
 * @property float $amount
 * @property integer $period
 * @property string $name [varchar(255)]
 */
class PriceList extends ActiveRecord
{
    const PERIOD_MONTH = 1;
    const PERIOD_DAY = 2;
    const PERIOD_WEEK = 3;
    const PERIOD_YEAR = 4;

    const PERIOD_ALL = 99;

    const ARRAY_PERIOD = [
        self::PERIOD_MONTH => 'Ежемесячно',
        self::PERIOD_DAY => 'Ежедневно',
        self::PERIOD_WEEK => 'Еженедельно',
        self::PERIOD_YEAR => 'Ежегодно',
        self::PERIOD_ALL => 'Разовый платеж',
    ];

    public static function create($key, $amount, $period, $name): self
    {
        throw new \DomainException('Закрыт доступ к созданию!');
        //TODO Удалить
        $price = new static();
        $price->key = $key;
        $price->amount = $amount;
        $price->period = $period;
        $price->name = $name;
        return $price;
    }

    public function edit($amount, $period): void
    {
        $this->amount = $amount;
        $this->period = $period;
    }

    public static function tableName()
    {
        return '{{%office_price_list}}';
    }

}