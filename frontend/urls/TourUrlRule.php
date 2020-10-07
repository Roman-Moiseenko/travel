<?php


namespace frontend\urls;


use booking\helpers\scr;
use booking\repositories\booking\tours\TourRepository;
use booking\repositories\booking\tours\TypeRepository;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\caching\Cache;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlNormalizerRedirectException;
use yii\web\UrlRuleInterface;

class TourUrlRule extends BaseObject implements UrlRuleInterface
{
    private $repository;
    private $cache;

    public function __construct(TourRepository $repository, Cache $cache, $config = [])
    {
        parent::__construct($config);
        $this->repository = $repository;
        $this->cache = $cache;
    }

    public function parseRequest($manager, $request)
    {
        scr::p([$manager, $request]);
        $path = $request->pathInfo;
        $result = $this->cache->getOrSet(['page_route', 'path' => $path], function () use ($path) {
            if (!$page = $this->repository->findBySlug($this->getPathSlug($path))) {
                return ['id' => null, 'path' => null];
            }
            return ['id' => $page->id, 'path' => 'tour/view'];
        });

        if (empty($result['id'])) {
            return false;
        }

        if ($path != $result['path']) {
            throw new UrlNormalizerRedirectException(['tour/view', 'id' => $result['id']], 301);
        }

        return ['page/view', ['id' => $result['id']]];
    }

    public function createUrl($manager, $route, $params)
    {
      //  scr::p([$manager, $route, $params]);
        if ($route == 'tour/view') {
            if (empty($params['id'])) {
                throw new InvalidArgumentException('Empty id.');
            }
            $id = $params['id'];

            $url = $this->cache->getOrSet(['page_route', 'id' => $id], function () use ($id) {
                if (!$category = $this->repository->find($id)) {
                    return null;
                }
                return 'tour/' . $category->slug;
            });

            if (!$url) {
                throw new InvalidArgumentException('Undefined id.');
            }

            unset($params['id']);
            if (!empty($params) && ($query = http_build_query($params)) !== '') {
                $url .= '?' . $query;
            }

            return $url;
        }
        return false;
    }

    private function getPathSlug($path): string
    {
        $chunks = explode('/', $path);
        return end($chunks);
    }
}