<?php

namespace App\Http\Controllers;

use App\Repositories\ArticlesRepository;
use App\Repositories\PortfoliosRepository;
use App\Repositories\SlidersRepository;
use Illuminate\Http\Request;
use Config;

class IndexController extends SiteController
{

    public function __construct(SlidersRepository $s_rep, PortfoliosRepository $p_rep, ArticlesRepository $a_rep)
    {
        parent::__construct(new \App\Repositories\MenusRepository(new \App\Menu));

        $this->a_rep = $a_rep;

        $this->p_rep = $p_rep;

        $this->s_rep = $s_rep;

        $this->bar = 'right';
        $this->template = env('THEME').'.index';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(){
        //
        $portfolios = $this->getPortfolio();
        $content = view(env('THEME').'.content')->with('portfolios', $portfolios)->render();
        $this->vars['content'] = $content;

        $sliderItems = $this->getSliders();
        $sliders = view(env('THEME').'.slider')->with('sliders', $sliderItems)->render();
        $this->vars['sliders'] = $sliders;

        $articles = $this->getArticles();
        $this->contentRightBar = view(env('THEME').'.indexBar')->with('articles', $articles)->render();
        $this->vars['articles'] = $articles;

        $this->keywords = 'Home Page';
        $this->meta_desc = 'Home Page';
        $this->title = 'Home Page';

        return $this->renderOutput();
    }

    protected function getArticles(){

        $articles = $this->a_rep->get(['title','created_at', 'img', 'alias'], Config::get('settings.home_articles_count'));

        return $articles;
    }

    protected function getPortfolio(){

        $portfolio = $this->p_rep->get();

        return $portfolio;
    }

    public function getSliders(){
        $sliders = $this->s_rep->get('*', Config::get('settings.home_port_count'));

        if($sliders->isEmpty()){
            return FALSE;
        }
        $sliders->transform(function ($item, $key){
            $item->img = Config::get('settings.slider_path').'/'.$item->img;
            return $item;
        });


        return $sliders;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
