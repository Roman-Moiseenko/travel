<?php
declare(strict_types=1);

namespace frontend\widgets\menu;

use booking\services\system\LoginService;
use yii\base\Widget;

class MainMenu extends Widget
{
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(LoginService $loginService, $config = [])
    {
        parent::__construct($config);
        $this->loginService = $loginService;
    }

    public function run()
    {
        $menu = [
            [
                'icon' => '<i class="fas fa-bars"></i>',
                'title' => 'Главная',
                'link' => '/'
            ],
            [
                'icon' => '<i class="fas fa-plane-departure"></i>',
                'title' => 'Туристам',
                'link' => '#',
                'items' => [
                    [
                        'icon' => '',
                        'title' => 'Экскурсии',
                        'link' => '/tours'
                    ],
                    [
                        'icon' => '',
                        'title' => 'Отдых',
                        'link' => '/funs'
                    ],
                    [
                        'icon' => '',
                        'title' => 'Проживание',
                        'link' => '/stays'
                    ],
                    [
                        'icon' => '',
                        'title' => 'Где поесть',
                        'link' => '/foods'
                    ],
                    [
                        'icon' => '',
                        'title' => 'Сувениры',
                        'link' => '/shops'
                    ],

                    [
                        'icon' => '',
                        'title' => 'Ночная жизнь',
                        'link' => '/night/nochnaya-zhizn-v-kaliningrade'
                    ],
                ]
            ],
            [
                'icon' => '<i class="fas fa-book-medical"></i>',
                'title' => 'МедТуризм',
                'link' => '#',
                'items' => [
                    [
                        'icon' => '',
                        'title' => 'Отдых и лечение',
                        'link' => '/medicine'
                    ],
                    [
                        'icon' => '',
                        'title' => 'Суррогатное материнство',
                        'link' => '/medicine/surrogatnoe-materinstvo-v-kaliningrade'
                    ],
                    [
                        'icon' => '',
                        'title' => 'Йога',
                        'link' => '/medicine/yoga'
                    ],
                    [
                        'icon' => '',
                        'title' => 'Форум',
                        'link' => '/forum/lechenie'
                    ],

                ]
            ],
            [
                'icon' => '<i class="fas fa-truck-moving"></i>',
                'title' => 'На ПМЖ в Калининград',
                'link' => '#',
                'items' => [
                    [
                        'icon' => '',
                        'title' => 'Как переехать в Калининград',
                        'link' => '/moving'
                    ],
                    [
                        'icon' => '',
                        'title' => 'Участки под ИЖС',
                        'link' => '/realtor'
                    ],
                    [
                        'icon' => '',
                        'title' => 'Форум',
                        'link' => '/forum/pereezd-na-pmzh'
                    ],

                ]
            ],
            [
                'icon' => '<i class="fab fa-blogger"></i>',
                'title' => 'Блог',
                'link' => '/post',
            ],
        ];

        return $this->render('main_menu', [
            'user' => $this->loginService->user(),
            'menu' => $menu,
        ]);
    }
}