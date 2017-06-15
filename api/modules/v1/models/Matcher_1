<?php

namespace api\modules\v1\models;

/**
 * Matcher1 - matcher for one match
 *
 * This class provides the functions implementation for single return matcher
 *
 */
 
 class Matcher1 implements Matcher
 {
     /**
     * Match 
     * Returns an array with the best (single) match
     * 
     * @param item => item to be matched
     * @param itemList => possible matches
     *
     * return array
     *
    */
     public function match($item, $itemList)
     {
         $best_compatibility = 0;
         
         foreach ($itemList as $itemB)
         {
            $compatibility = 0;
            $i = 0;
            $n = sizeof($item); //Number of attributes
            $match_comparator = new MatchComparator();
            
            //Compares the items attribute per attribute; compatibility receives the sum of attribute similarity
            while($i < $n){
                $compatatibility += $match_comparator->compareAttribute($item[i], $itemB[i]);
                $i++;
            }
           
           //Sum of attribute similarity between the items is divided by the number of attributes, resulting in a number between 0 and 1 (%)
           $compatibility = $compatibility/$n;
           
           //If the current item is the most compatible so far, it is saved in match
           if($compatibility > $best_compatibility){
               $best_compatibility = $compatibility;
               $match = $itemB;
           }
         }
         
         return $match;
     }
 }