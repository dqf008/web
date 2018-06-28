<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: zhangyajun <448901948@qq.com>
// +----------------------------------------------------------------------

namespace think\paginator\driver;

use think\Paginator;

class Pagebox extends Paginator {

    /**
     * 上一页按钮
     *
     * @param string $text
     *
     * @return array
     */
    protected function getPreviousButton($text = "&laquo;") {

        if ($this->currentPage() <= 1) {
            return $this->getDisabledTextWrapper($text);
        }

        return $this->getPageLinkWrapper($this->currentPage() - 1, $text);
    }

    /**
     * 下一页按钮
     *
     * @param string $text
     *
     * @return array
     */
    protected function getNextButton($text = '&raquo;') {
        if (!$this->hasMore) {
            return $this->getDisabledTextWrapper($text);
        }

        return $this->getPageLinkWrapper($this->currentPage() + 1, $text);
    }

    /**
     * 页码按钮
     * @return array
     */
    protected function getLinks() {
        if ($this->simple)
            return [];

        $block = [
            'first'  => null,
            'slider' => null,
            'last'   => null,
        ];

        $side = 3;
        $window = $side * 2;

        if ($this->lastPage < $window + 6) {
            $block['first'] = $this->getUrlRange(1, $this->lastPage);
        } else if ($this->currentPage <= $window) {
            $block['first'] = $this->getUrlRange(1, $window + 2);
            $block['last'] = $this->getUrlRange($this->lastPage - 1, $this->lastPage);
        } else if ($this->currentPage > ($this->lastPage - $window)) {
            $block['first'] = $this->getUrlRange(1, 2);
            $block['last'] = $this->getUrlRange($this->lastPage - ($window + 2), $this->lastPage);
        } else {
            $block['first'] = $this->getUrlRange(1, 2);
            $block['slider'] = $this->getUrlRange($this->currentPage - $side, $this->currentPage + $side);
            $block['last'] = $this->getUrlRange($this->lastPage - 1, $this->lastPage);
        }

        $return = [];

        if (is_array($block['first'])) {
            $return = array_merge($return, $this->getUrlLinks($block['first']));
        }

        if (is_array($block['slider'])) {
            $return[] = $this->getDots();
            $return = array_merge($return, $this->getUrlLinks($block['slider']));
        }

        if (is_array($block['last'])) {
            $return [] = $this->getDots();
            $return = array_merge($return, $this->getUrlLinks($block['last']));
        }

        return $return;
    }

    /**
     * 创建一组分页链接
     *
     * @param  int $start
     * @param  int $end
     *
     * @return array
     */
    public function getUrlRange($start, $end) {
        $urls = [];

        for ($page = $start; $page <= $end; $page++) {
            $urls[$page] = $page;
        }

        return $urls;
    }

    /**
     * 渲染分页html
     * @return mixed
     */
    public function render() {
        if ($this->hasPages()) {
            if ($this->simple) {
                return [
                    $this->getPreviousButton(),
                    $this->getNextButton(),
                ];
            } else {
                $return = [$this->getPreviousButton()];
                $return = array_merge($return, $this->getLinks());
                $return[] = $this->getNextButton();
                return $return;
            }
        } else {
            return [];
        }
    }

    /**
     * 生成一个可点击的按钮
     *
     * @param  string $url
     * @param  int    $page
     *
     * @return array
     */
    protected function getAvailablePageWrapper($url, $page) {
        return [
            'text' => $page,
            'page' => $url,
        ];
    }

    /**
     * 生成一个禁用的按钮
     *
     * @param  string $text
     *
     * @return array
     */
    protected function getDisabledTextWrapper($text) {
        return [
            'text'     => $text,
            'disabled' => true,
        ];
    }

    /**
     * 生成一个激活的按钮
     *
     * @param  string $text
     *
     * @return array
     */
    protected function getActivePageWrapper($text) {
        return [
            'text'   => $text,
            'active' => true,
        ];
    }

    /**
     * 生成省略号按钮
     *
     * @return array
     */
    protected function getDots() {
        return $this->getDisabledTextWrapper('...');
    }

    /**
     * 批量生成页码按钮.
     *
     * @param  array $urls
     *
     * @return array
     */
    protected function getUrlLinks(array $urls) {
        $return = [];

        foreach ($urls as $page => $url) {
            $return[] = $this->getPageLinkWrapper($url, $page);
        }

        return $return;
    }

    /**
     * 生成普通页码按钮
     *
     * @param  string $url
     * @param  int    $page
     *
     * @return array
     */
    protected function getPageLinkWrapper($url, $page) {
        if ($page == $this->currentPage()) {
            return $this->getActivePageWrapper($page);
        }

        return $this->getAvailablePageWrapper($url, $page);
    }
}
