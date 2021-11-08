<?php


namespace frontend\urls;


use booking\helpers\scr;
use booking\repositories\touristic\fun\FunRepository;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\caching\Cache;
use yii\web\UrlNormalizerRedirectException;
use yii\web\UrlRuleInterface;

class FunUrlRule extends BaseObject implements UrlRuleInterface
{
    private $repository;
    private $cache;

    public function __construct(FunRepository $repository, Cache $cache, $config = [])
    {
        parent::__construct($config);
        $this->repository = $repository;
        $this->cache = $cache;
    }

    public function parseRequest($manager, $request)
    {
        //scr::p([$manager, $request]);
        $path = $request->pathInfo;
        $result = $this->cache->getOrSet(['fun_route', 'path' => $path], function () use ($path) {
            if (!$page = $this->repository->findBySlug($this->getPathSlug($path))) {
                return ['id' => null, 'path' => null];
            }
            return ['id' => $page->id, 'path' => 'funs/funs/fun'];
        });

        if (empty($result['id'])) {
            return false;
        }

        if ($path != $result['path']) {
            throw new UrlNormalizerRedirectException(['funs/funs/fun', 'id' => $result['id']], 301);
        }

        return ['funs/funs/fun', ['id' => $result['id']]];
    }

    public function createUrl($manager, $route, $params)
    {
        //scr::p([$manager, $route, $params]);
        if ($route == 'funs/funs/fun') {
            if (empty($params['id'])) {
                throw new InvalidArgumentException('Empty id.');
            }
            $id = $params['id'];

            $url = $this->cache->getOrSet(['fun_route', 'id' => $id], function () use ($id) {
                if (!$fun = $this->repository->find($id)) {
                    return null;
                }
                return 'fun/' . $fun->slug;
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