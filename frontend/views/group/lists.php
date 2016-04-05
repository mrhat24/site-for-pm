<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
            echo '<option value="0">-Выберите группу-</option>';
             foreach($groups as $group)
             {
                 echo '<option value="'.$group->id.'">'.$group->name.'</option>';
             }
             
