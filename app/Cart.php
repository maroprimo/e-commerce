<?php

namespace App;

class Cart{
    
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    public $totalWeight = 0;
    


    public function __construct($oldCart){// $oldcart c'est le panier 
        // affecter les valeurs des propriété en fonction des valeurs du variable oldcart, s'il existe déjà qlq chose dans ce variable
        
        if($oldCart){
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
            $this->totalWeight = $oldCart->totalWeight;
        }

    }

    public function add($item, $product_id){
        // initialisation des valeurs de l'item, ici item est l'objet produits

        $storedItem = ['qty' => 0, 'product_id' => 0, 'product_name' => $item->product_name,
    'product_price' => $item->product_price, 'product_image' => $item->product_image, 'item' =>$item];
        // on saute cette condition s'il n'y pas car on ecrase l'id déjà existant si c'est la meme produit
    if($this->items){
        if(array_key_exists($product_id, $this->items)){
            $storedItem = $this->items[$product_id];
        }
    }

    $storedItem['qty']++;
    $storedItem['product_id'] = $product_id;
    $storedItem['product_name'] = $item->product_name;
    $storedItem['product_price'] = $item->product_price;
    $storedItem['product_image'] = $item->product_image;
    $storedItem['weight'] = $item->weight;
    $this->totalQty++;
    $this->totalPrice += $item->product_price;
    $this->items[$product_id] = $storedItem;
    $this->totalWeight += $item->weight;

    }

    public function updateQty($id, $qty){
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['product_price'] * $this->items[$id]['qty'];
        $this->totalWeight -= $this->items[$id]['item']->weight * $this->items[$id]['qty']; // Ajuster le poids

        $this->items[$id]['qty'] = $qty;
        $this->totalQty += $qty;
        $this->totalPrice += $this->items[$id]['product_price'] * $qty;
        $this->totalWeight += $this->items[$id]['item']->weight * $qty; // Recalculer le poids

    }

    public function removeItem($id){
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['product_price'] * $this->items[$id]['qty'];
        // nouveau panier qui contient l'ancien articles
    // Réduire le poids total
        $this->totalWeight -= $this->items[$id]['item']->poids * $this->items[$id]['qty'];
        unset($this->items[$id]);
    }

    public function has($id) {
        return isset($this->items[$id]);
    }


}


?>