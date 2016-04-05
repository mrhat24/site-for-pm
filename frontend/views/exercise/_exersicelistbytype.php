<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

foreach ($exersices as $exersice)
{
                 echo '<option value="'.$exersice->id.'">'.$exersice->subject->name." - ".$exersice->name.'</option>';           
}