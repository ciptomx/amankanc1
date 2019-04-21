<?php
   function crossSiteKawalPemilu($url){               
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);      
      curl_setopt($ch, CURLOPT_VERBOSE, 0);      
      /*      
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);      
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);      
      curl_setopt($ch, CURLOPT_FAILONERROR, 1);
      */
      curl_setopt($ch, CURLOPT_ENCODING, '');
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $output = curl_exec($ch);
      if($output === false) $output = curl_error($ch);
      curl_close($ch);
      $output = json_decode($output);
      return $output;

   }
   
?>