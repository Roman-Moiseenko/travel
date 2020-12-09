<?php


namespace frontend\urls;


use booking\repositories\booking\cars\TypeRepository;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\caching\Cache;
use yii\web\UrlNormalizerRedirectException;
use yii\web\UrlRuleInterface;

class CarTypeUrlRule extends BaseObject implements UrlRuleInterface
{
    private $repository;
    private $cache;

    public function __construct(TypeRepository $repository, Cache $cache, $config = [])
    {
        parent::__construct($config);
        $this->repository = $repository;
        $this->cache = $cache;
    }

    public function parseRequest($manager, $request)
    {
        //scr::p([$manager, $request]);
        $path = $request->pathInfo;
        $result = $this->cache->getOrSet(['cars_route', 'path' => $path], function () use ($path) {
            if (!$page = $this->repository->findBySlug($this->getPathSlug($path))) {
                return ['id' => null, 'path' => null];
            }
            return ['id' => $page->id, 'path' => 'cars/category'];
        });

        if (empty($result['id'])) {
            return false;
        }

        if ($path != $result['path']) {
            throw new UrlNormalizerRedirectException(['cars/category', 'id' => $result['id']], 301);
        }

        return ['cars/category', ['id' => $result['id']]];
    }

    public function createUrl($manager, $route, $params)
    {
        if ($route == 'cars/category') {
            if (empty($params['id'])) {
                throw new InvalidArgumentException('Empty id.');
            }
            $id = $params['id'];

            $url = $this->cache->getOrSet(['cars_route', 'id' => $id], function () use ($id) {
                if (!$category = $this->repository->find($id)) {
                    return null;
                }
                return 'cars/' . $category->slug;
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