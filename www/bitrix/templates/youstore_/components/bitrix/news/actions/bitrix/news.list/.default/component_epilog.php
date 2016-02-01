<? 
   /* function sklonen($n,$s1,$s2,$s3, $b = false){
        $m = $n % 10; $j = $n % 100;
        if($b) $n = '<b>'.$n.'</b>';
        if($m==0 || $m>=5 || ($j>=10 && $j<=20)) return $n.' '.$s3;
        if($m>=2 && $m<=4) return  $n.' '.$s2;
        return $n.' '.$s1;
    }    */


    foreach($arResult['ACTION_END'] as $key=> $time){
        $seconds = strtotime($time)-time();
        if($seconds>0){
            $dt = new DateTime('@' . $seconds, new DateTimeZone('UTC'));
            $day = $dt->format('z');
            $day_t = GetMessage('TO_ACTION_END').' '.sklonen($day, GetMessage('DAY_1'),GetMessage('DAY_2'),GetMessage('DAY_3')); 
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
                    $('#<?=$key?>').text('<?=$day_t?>');
            })
        </script>
        <?
        }
        else{
              ?>
        <script type="text/javascript">
            $(document).ready(function(){
                    $('#<?=$key?>').text('<?=GetMessage('IS_OVER');?>');
            })
        </script>
        <?  }
    ?>

    <?   
    }
?>