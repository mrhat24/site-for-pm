<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */            
             foreach($students as $student)
             {
                 echo '<option value="'.$student->id.'">'.$student->user->fullname.'</option>';
             }
             
