<?php

namespace Lakew\Page;

use ArrayAccess;
use ArrayIterator;
use Closure;
use Countable;
use DomainException;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

/**
 * 分页基础类
 */
abstract class Page 
{
    /**
     * 当前页
     * @var int
     */
    protected $currentPage;

    /**
     * 最后一页
     * @var int
     */
    protected $lastPage;

    /**
     * 数据总数
     * @var integer|null
     */
    protected $total;

    /**
     * 每页数量
     * @var int
     */
    protected $listRows;

    /**
     * 是否有下一页
     * @var bool
     */
    protected $hasMore;

    /**
     * 是否简洁模式
     * @var bool
     */
    protected $simple = false;

    /**
     * 分页配置
     * @var array
     */
    protected $options = [
        'var_page' => 'page',
        'path'     => '/',
        'query'    => [],
        'fragment' => '',
    ];

    /**
     * 获取当前页码
     * @var Closure
     */
    protected static $currentPageResolver;

    /**
     * 获取当前路径
     * @var Closure
     */
    protected static $currentPathResolver;

    /**
     * 构造函数
     */
    public function __construct(
        int $listRows, 
        int $currentPage = 1, 
        int $total = null, 
        bool $simple = false, 
        array $options = []
    ) {
        $this->options = array_merge($this->options, $options);

        $this->options['path'] = ('/' != $this->options['path']) 
            ? rtrim($this->options['path'], '/') 
            : $this->options['path'];

        $this->simple   = $simple;
        $this->listRows = $listRows;

        if ($simple) {
            $lastPage = (int) ceil($total / $listRows);
            $this->currentPage = $this->setCurrentPage($currentPage);
            $this->hasMore     = $this->currentPage < $lastPage;
        } else {
            $this->total       = $total;
            $this->lastPage    = (int) ceil($total / $listRows);
            $this->currentPage = $this->setCurrentPage($currentPage);
            $this->hasMore     = $this->currentPage < $this->lastPage;
        }
    }

    /**
     * 设置当前页
     */
    protected function setCurrentPage(int $currentPage): int
    {
        if (!$this->simple && $currentPage > $this->lastPage) {
            return $this->lastPage > 0 ? $this->lastPage : 1;
        }

        return $currentPage;
    }

    /**
     * 获取页码对应的链接
     *
     * @access protected
     * @param int $page
     * @return string
     */
    protected function url(int $page): string
    {
        if ($page <= 0) {
            $page = 1;
        }

        if (strpos($this->options['path'], '[PAGE]') === false) {
            $parameters = [$this->options['var_page'] => $page];
            $path       = $this->options['path'];
        } else {
            $parameters = [];
            $path       = str_replace('[PAGE]', (string) $page, $this->options['path']);
        }

        if (count($this->options['query']) > 0) {
            $parameters = array_merge($this->options['query'], $parameters);
        }

        $url = $path;
        if (!empty($parameters)) {
            $url .= '?' . http_build_query($parameters, '', '&');
        }

        return $url . $this->buildFragment();
    }

    /**
     * 自动获取当前页码
     * 
     * @param string $varPage
     * @param int    $default
     * @return int
     */
    public static function getCurrentPage(string $varPage = 'page', int $default = 1): int
    {
        if (isset(static::$currentPageResolver)) {
            return call_user_func(static::$currentPageResolver, $varPage);
        }

        return $default;
    }

    /**
     * 设置获取当前页码闭包
     * 
     * @param Closure $resolver
     */
    public static function currentPageResolver(Closure $resolver)
    {
        static::$currentPageResolver = $resolver;
    }

    /**
     * 自动获取当前的path
     * 
     * @param string $default
     * @return string
     */
    public static function getCurrentPath($default = '/'): string
    {
        if (isset(static::$currentPathResolver)) {
            return call_user_func(static::$currentPathResolver);
        }

        return $default;
    }

    /**
     * 设置获取当前路径闭包
     * 
     * @param Closure $resolver
     */
    public static function currentPathResolver(Closure $resolver)
    {
        static::$currentPathResolver = $resolver;
    }

    /**
     * 获取数据总条数
     * 
     * @return int
     */
    public function total(): int
    {
        if ($this->simple) {
            throw new DomainException('not support total');
        }

        return $this->total;
    }

    /**
     * 获取每页数量
     * 
     * @return int
     */
    public function listRows(): int
    {
        return $this->listRows;
    }

    /**
     * 获取当前页页码
     * 
     * @return int
     */
    public function currentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * 获取最后一页页码
     * 
     * @return int
     */
    public function lastPage(): int
    {
        if ($this->simple) {
            throw new DomainException('not support last');
        }

        return $this->lastPage;
    }

    /**
     * 数据是否足够分页
     * 
     * @access public
     * @return bool
     */
    public function hasPages(): bool
    {
        return !(1 == $this->currentPage && !$this->hasMore);
    }

    /**
     * 创建一组分页链接
     *
     * @access public
     * @param int $start
     * @param int $end
     * @return array
     */
    public function getUrlRange(int $start, int $end): array
    {
        $urls = [];

        for ($page = $start; $page <= $end; $page++) {
            $urls[$page] = $this->url($page);
        }

        return $urls;
    }

    /**
     * 设置URL锚点
     *
     * @access public
     * @param string|null $fragment
     * @return $this
     */
    public function fragment(string $fragment = null)
    {
        $this->options['fragment'] = $fragment;

        return $this;
    }

    /**
     * 添加URL参数
     *
     * @access public
     * @param array $append
     * @return $this
     */
    public function appends(array $append)
    {
        foreach ($append as $k => $v) {
            if ($k !== $this->options['var_page']) {
                $this->options['query'][$k] = $v;
            }
        }

        return $this;
    }

    /**
     * 构造锚点字符串
     *
     * @access public
     * @return string
     */
    protected function buildFragment(): string
    {
        return $this->options['fragment'] ? '#' . $this->options['fragment'] : '';
    }

    /**
     * 渲染分页html
     * 
     * @access public
     * @return mixed
     */
    abstract public function render();

    public function __toString()
    {
        return (string) $this->render();
    }

    /**
     * 转换为数组
     * 
     * @return array
     */
    public function toArray(): array
    {
        try {
            $total = $this->total();
        } catch (DomainException $e) {
            $total = null;
        }

        return [
            'total'        => $total,
            'per_page'     => $this->listRows(),
            'current_page' => $this->currentPage(),
            'last_page'    => $this->lastPage,
        ];
    }

    /**
     * Specify data which should be serialized to JSON
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

}
