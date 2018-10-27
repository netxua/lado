<?php
namespace Frontend\Models;
use Illuminate\Support\Facades\DB;
use Lang, Cache;

class Articles extends App
{
    protected $table = 'articles';
    public    $timestamps = true;

    public function getArticles(array $params = [], $isFrist = FALSE){
        $user = $this->getUser();
        $user_id = \HelperUser::getUserId($user);
        $language_id = $this->getLanguageId();
        if( !empty($params['language_id']) ) {
            $language_id = $params['language_id'];
        }

        $articles  =  $this->getModel('Articles')->selectRaw('articles.id, articles.users_id, articles.categories_id, articles.is_published, articles.is_delete, articles.is_hot, articles.is_news, articles.is_static, articles.ordering, articles.updated_at, articles.created_at, 
            articles.thumb,
            articles.articles_ref,

            articles_translate.seo_keywords,
            articles_translate.seo_description,
            articles_translate.title,
            articles_translate.slug,
            articles_translate.description,
            articles_translate.content ')
            ->join('articles_translate', function ($join) use ($language_id) {
                $join->on(DB::raw('articles_translate.articles_id = articles.id AND articles_translate.language_id = \''.$language_id.'\''),DB::raw(''),DB::raw(''));
            })
            ->join('users', 'users.id', '=', 'articles.users_id');

        if( !empty($params['id']) ) {
            $id = $params['id'];
            $articles     ->whereIn('articles.id', $this->parseArray($id));
        }

        if( !empty($params['slug']) ) {
            $slug = $params['slug'];
            $articles     ->where(array(
                                'articles_translate.slug'=> $slug
                            ));
        }

        if ( !$isFrist ) {
            $articles     ->where(array(
                'articles.is_static' => 0
            ));
        }

        if( isset($params['categories_id']) ) {
            $categories_id = $params['categories_id'];
            $articles     ->whereIn('articles.categories_id', $this->parseArray($categories_id));
        }

        if( isset($params['is_hot']) ) {
            $is_hot = $params['is_hot'];
            $articles     ->where(array(
                                'articles.is_hot'=> $is_hot
                            ));
        }

        if( isset($params['is_news']) ) {
            $is_news = $params['is_news'];
            $articles     ->where(array(
                                'articles.is_news'=> $is_news
                            ));
        }

        if( !empty($params['keyword']) ) {
            $keyword = strtolower($params['keyword']);
            $okeyword = $this->toAlias($keyword);
            $articles->whereRaw("(LOWER(articles_translate.title) LIKE '%$keyword%'

                                || Stored_ToAlias(articles_translate.title) LIKE '%$okeyword%' )");
        }

        $articles     ->where(array(
                        'articles.is_published' => 1,
                        'articles.is_delete' => 0
                    ));
        if ( $isFrist ) {
            return $articles->get()->first();
        } else {
            if ( $this->hasPaging($params) ) {
                $articles  =  $articles->offset($this->getOffsetPaging($params['page'], $params['limit']))
                                        ->limit($params['limit']);
            }
            $articles  =    $articles->orderBy('articles.ordering', 'ASC')
                                    ->get()->toArray();
            return $articles;
        }
    }

    public function getTotalArticles( array $params = [] ){
        $user = $this->getUser();
        $user_id = \HelperUser::getUserId($user);

        $articles  =  $this->getModel('Articles')->selectRaw('articles.id')
            ->join('users', 'users.id', '=', 'articles.users_id');

        if( isset($params['categories_id']) ) {
            $categories_id = $params['categories_id'];
            $articles     ->where(array(
                                'articles.categories_id'=> $categories_id
                            ));
        }

        if( isset($params['is_hot']) ) {
            $is_hot = $params['is_hot'];
            $articles     ->where(array(
                                'articles.is_hot'=> $is_hot
                            ));
        }

        if( isset($params['is_news']) ) {
            $is_news = $params['is_news'];
            $articles     ->where(array(
                                'articles.is_news'=> $is_news
                            ));
        }

        if( !empty($params['keyword']) ) {
            $keyword = strtolower($params['keyword']);
            $okeyword = $this->toAlias($keyword);
            $articles->whereRaw("(LOWER(articles_translate.title) LIKE '%$keyword%'

                                || Stored_ToAlias(articles_translate.title) LIKE '%$okeyword%' )");
        }

        $articles     ->where(array(
                        'articles.is_published' => 1,
                        'articles.is_delete' => 0
                    ));

        $total    =  $articles->count();
        return $total;
    }
}