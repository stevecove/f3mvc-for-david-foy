<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 01/09/2015
 * Time: 11:35
 */

namespace Controllers;


class Card {

    private
        $f3,
        $card;
    function beforeRoute()
    {
        //used for access control, auth etc
    }

    function __construct()
    {
        //constructors must be parameterless due to F3 routing mechanism, so we might as well
        //use it as the composition route, and construct all our dependancies here
        $this->f3 = \Base::instance();
        $this->card = new \Models\Card();

    }

    /**
     * responds to GET /
     */
    function home()
    {
        $this->f3->set('content', '/card/home.phtml');
    }

    /**
     * responds to GET /cards/@category
     */
    function showList()
    {
        //extract the category from the PARAMS hive array
        $category = $this->f3->get('PARAMS.category');
        //set the data to be used by the view, we can use mset for multiple values
        $this->f3->mset(
            [
                'category'  =>  $category,
                'cardList'  =>  $this->card->getByCategory($category),
            ]
        );
        //set the inner page template
        $this->f3->set('content', '/card/list.phtml');
    }

    /**
     * responds to GET /card/@id
     */
    function showSingle()
    {
        //extract the id from the PARAMS hive array
        $id = $this->f3->get('PARAMS.id');
        //set the data to be used by the view, we can use set for single values
        $this->f3->set('card', $this->card->getById($id));
        //set the inner page template
        $this->f3->set('content', '/card/single.phtml');
    }

    function afterRoute(){
        //everything that must happen after every route
        //render the master template
        echo \Template::instance()->render('/layout.phtml');
    }
} 