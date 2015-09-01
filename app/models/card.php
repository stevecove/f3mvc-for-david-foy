<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 01/09/2015
 * Time: 11:39
 */

namespace Models;


class Card {

    private
        $f3,
        $db,
        $mapper;

    function __construct()
    {
        $this->f3 = \Base::instance();
        $this->db = $this->f3->get('db');
        $this->mapper = new \DB\SQL\Mapper($this->db, 'cards');
    }

    function getByCategory($category)
    {
        $cardsArray=[];
        foreach($this->mapper->find(['category=?', $category]) as $card)
        {
            $cardsArray[] = $card->cast();
        }
        return $cardsArray;
    }

    function getById($id)
    {
        $this->mapper->load(['id=?', $id]);
        return $this->mapper->cast();
    }
} 