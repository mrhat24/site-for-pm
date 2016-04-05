<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */            
echo '<option value="">-Выберите задание-</option>';
             foreach($tasks as $task)
             {
                 echo '<option value="'.$task->id.'">'.$task->name.'</option>';
             }
             
