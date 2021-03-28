<?php


namespace frontend\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class BreadcrumbsWidget extends Widget
{
    public $tag = 'ul';

    public $options = ['class' => 'breadcrumb'];

    public $encodeLabels = true;

    public $homeLink;

    public $links = [];

    public function run()
    {
        if (empty($this->links)) {
            return;
        }
        $links = [];
        if ($this->homeLink === null) {
            $links[] = $this->renderItem([
                'label' => \Yii::t('yii', 'Home'),
                'url' => \Yii::$app->homeUrl,
            ]);
        } elseif ($this->homeLink !== false) {
            $links[] = $this->renderItem($this->homeLink);
        }
        foreach ($this->links as $i => $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link,  $i + 2);
        }
        $result = '<div itemscope="" itemtype="http://schema.org/BreadcrumbList">';
        $result .= Html::tag($this->tag, implode('', $links), $this->options);
        $result .= '</div>';
        echo $result;
    }

    protected function renderItem($link, $iterator = 1)
    {
        if (!array_key_exists('label', $link)) {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }
        if (isset($link['url'])) {
            $result = '
                        <div itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <li>
                            <a itemprop="item" href="'. \Yii::$app->params['frontendHostInfo'] . $link['url'] .'">
                                <span itemprop="name">'. $link['label'] . '</span>                                
                            </a>
                            <meta itemprop="position" content="'. $iterator . '">
                        </li>
                        </div>';
            return $result;
        } else {
            $result = '<li class="active">'. $link['label'] . '</li>';
            return $result;
        }
    }
}