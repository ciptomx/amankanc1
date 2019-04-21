<?php   
   set_time_limit(0);
   include_once('functs.php');
   if(!isset($_GET['wil'])) die('Error. General Wilayah');
?>
<html>
<head>
   <!--<meta http-equiv="refresh" content="60">-->
   <meta http-equiv="Content-type" content="text/html; charset=utf-8">
   <meta content="width=device-width, initial-scale=1, user-scalable=yes" name="viewport">      
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
   <style>
      html,body,table,td{
         font-family:Tahoma;
         font-size:12px;
      }
      a {
         text-decoration:none;
         padding:5px;
      }
      table,tr,th,td {
         border:1px solid #ccc;
         font-size:12px;
      }
      img.thumb {
         display:block;
         margin:0 auto;
         text-align:center;
         padding:4px;
         width:120px;
         height:auto;
      }
   </style>
</head>
<body>
   <?php
      $id = (int)$_GET['wil'];
      echo $_GET['nama'].'<br/><br/>';
      $url  = 'https://pemilu2019.kpu.go.id/static/json/wilayah/'.$id.'.json';
      $x    = crossSiteKawalPemilu($url);
      foreach ($x as $kabid=>$kabwil) {             
         echo "&nbsp;&nbsp;&nbsp;&nbsp;";
         echo '<a>++ '.$kabwil->nama.'</a><br/>';
         $url = 'https://pemilu2019.kpu.go.id/static/json/wilayah/'.$id.'/'.$kabid.'.json';
         $y    = crossSiteKawalPemilu($url);
         foreach ($y as $kecid=>$kecwil) {             
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";   
            echo '<a>+++ '.$kecwil->nama.'</a><br/>';

            $url  = 'https://pemilu2019.kpu.go.id/static/json/wilayah/'.$id.'/'.$kabid.'/'.$kecid.'.json';
            $z    = crossSiteKawalPemilu($url);
            foreach ($z as $lurid=>$lurwil) {
               echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";   
               echo '<a>++++ '.$lurwil->nama.'</a>';

               $url  = 'https://pemilu2019.kpu.go.id/static/json/wilayah/'.$id.'/'.$kabid.'/'.$kecid.'/'.$lurid.'.json';
               echo ' - source. <a href="'.$url.'" target="_blank">'.$url.'</a><br/><br/>';
               
               $abc = crossSiteKawalPemilu($url);

               foreach ($abc as $tpsid=>$tpswil) {
                  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";   
                  echo '<a style="background-color:#000;color:#fff;border-radius:4px;">'.$tpswil->nama.'</a>';

                  //$url  = 'https://pemilu2019.kpu.go.id/static/json/wilayah/'.$id.'/'.$kabid.'/'.$kecid.'/'.$lurid.'/'.$tpsid.'.json';
                  $url = 'https://pemilu2019.kpu.go.id/static/json/hhcw/ppwp/'.$id.'/'.$kabid.'/'.$kecid.'/'.$lurid.'/'.$tpsid.'.json';
                  echo ' - source. <a href="'.$url.'" target="_blank">'.$url.'</a><br/><br/>';

                  
                  $xyz  = crossSiteKawalPemilu($url);                           

                  if(is_object($xyz) && isset($xyz->ts)){

                     $images = '';
                     if(isset($xyz->images) && count($xyz->images)){
                        $lm_main = 'https://pemilu2019.kpu.go.id/img/c/'.substr($tpsid,0,3).'/'.substr($tpsid,3,3).'/'.$tpsid.'/';                                 
                        $lm_1 = $lm_main.$xyz->images[0];
                        $lm_2 = $lm_main.$xyz->images[1];
                        $images = '<a href="'.$lm_1.'" target="_blank"><img src="'.$lm_1.'" class="thumb" /><br/>'.$xyz->images[0].'</a> <br/> 
                                   <a href="'.$lm_2.'" target="_blank"><img src="'.$lm_2.'" class="thumb" /><br/>'.$xyz->images[1].'</a>';
                     }                              
                     
                     echo '<table>
                              <thead>
                                 <tr>
                                    <th>Keterangan</th>
                                    <th>Data</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <td colspan="2" align="center">Detail. '.$tpswil->nama.'</td>
                                 </tr>
                                 <tr>
                                    <td>Timestamp</td>
                                    <td>'.$xyz->ts.'</td>
                                 </tr>
                                 <tr>
                                    <td>Scanned Dokumen</td>
                                    <td>'.$images.'</td>
                                 </tr>                                  
                                 <tr>
                                    <td>Perolehan Jokowi Maruf</td>
                                    <td>'.$xyz->chart->{'21'}.'</td>
                                 </tr>
                                 <tr>
                                    <td>Perolehan Prabowo Sandi</td>
                                    <td>'.$xyz->chart->{'22'}.'</td>
                                 </tr>
                                 <tr>
                                    <td>DPT</td>
                                    <td>'.$xyz->pemilih_j.'</td>
                                 </tr>
                                 <tr>
                                    <td>Pengguna Hak Pilih</td>
                                    <td>'.$xyz->pengguna_j.'</td>
                                 </tr>
                                 <tr>
                                    <td>JUMLAH SELURUH SUARA SAH DAN SUARA TIDAK SAH</td>
                                    <td>'.$xyz->suara_total.'</td>
                                 </tr>
                                 <tr>
                                    <td>JUMLAH SELURUH SUARA SAH</td>
                                    <td>'.$xyz->suara_sah.'</td>
                                 </tr>
                                 <tr>
                                    <td>JUMLAH SUARA TIDAK SAH</td>
                                    <td>'.$xyz->suara_tidak_sah.'</td>
                                 </tr>                                    

                              </tbody>
                           </table><br/><br/>';
                  }                           

               }

               unset($abc);   
               

            }
            unset($z);

         }

         unset($y);
         
      }
      unset($x);
   ?>
</body>
</html>
